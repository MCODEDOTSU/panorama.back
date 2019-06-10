<?php

declare(strict_types=1);

namespace App\src\Services\Constructor;


use App\src\Repositories\Constructor\ConstructorRepository;
use App\src\Services\Constructor\Entities\FieldsResolver;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ConstructorService
{
    /**
     * Префикс используется при создании кастомных таблиц.
     * constructed_{id слоя}
     * @var string
     */
    private $tablePrefix = 'constructed_';

    private $fieldsResolver;
    private $constructorRepository;

    /**
     * ConstructorService constructor.
     * @param FieldsResolver $fieldsResolver
     * @param ConstructorRepository $constructorRepository
     */
    public function __construct(FieldsResolver $fieldsResolver, ConstructorRepository $constructorRepository)
    {
        $this->fieldsResolver = $fieldsResolver;
        $this->constructorRepository = $constructorRepository;
    }


    public function createTable(Request $request): string
    {
        Schema::create($this->tablePrefix . $request->table_title, function (Blueprint $table) use ($request) {
            $this->parseColumns($request, $table);
            $this->addGeoElementsAsForeignKey($table);
        });

        return $this->tablePrefix . $request->table_title;
    }

    /**
     * Удалить таблицу
     * @param $request :
     * Название таблицы
     */
    public function dropTable(Request $request): void
    {
        Schema::dropIfExists($request->table_title);
    }


    /**
     * Конвертирует json массив в столбцы новой таблицы
     * @param $request
     * @param $table
     */
    private function parseColumns($request, $table): void
    {
        $colArr = $request->columns;

        foreach ($colArr as $col) {
            $fieldType = $this->fieldsResolver->selectFieldType($col);

            $fieldType->constructField($table);
        }
    }

    /**
     * Добавить внещний ключ на таблицу geo_elements
     * TODO: Нужен ли только на geo_elements или на geo_layers - тоже???
     * @param $table - таблица с готовыми столбцами
     */
    private function addGeoElementsAsForeignKey($table)
    {
        $table->integer('element_id')->unsigned();
        $table->foreign('element_id')->references('id')->on('geo_elements');
    }


    public function getSpecificType(string $type)
    {
        return $type;
    }

    /**
     * Получить сводную информацию о столбцах
     * @param string $tableIdentifier
     * @return Collection
     */
    public function getTableInfo(string $tableIdentifier): Collection
    {
        $tableCols = Schema::getColumnListing($this->tablePrefix . $tableIdentifier);

        $tableColsSummary = new Collection();

        foreach ($tableCols as $tableCol) {
            $tableColsSummary->push([
                'title' => $tableCol,
                'type' => DB::getSchemaBuilder()->getColumnType($this->tablePrefix . $tableIdentifier, $tableCol)
            ]);

        }

        $columnsNullableInfo = $this->constructorRepository
            ->getInfoConcerningTableRequiredFields($this->tablePrefix . $tableIdentifier);

        // Сформировать required field
        // TODO: Вынести в отдельный метод
        $columnsNullableInfo->each(function ($column) use ($tableColsSummary) {
            switch ($column->required) {
                case 'YES':
                    return $column->required = true;
                    break;
                case 'NO':
                    return $column->required = false;
                    break;
            }
        });

        // Добавить type (тип) к коллекции
        // TODO: Вынести в отдельный метод
        $columnsNullableInfo->each(function ($column) use ($tableColsSummary) {
            foreach ($tableColsSummary as $item) {
                if ($item['title'] === $column->title) {
                    $column->type = $item['type'];
                }
            }
        });

        return $columnsNullableInfo;

    }

    /**
     * Проверить - существует ли таблица
     * @param string $tableIdentifier
     * @return string
     */
    public function isTableExists(string $tableIdentifier): string
    {
        if (!Schema::hasTable($this->tablePrefix . $tableIdentifier)) {
            return 'false';
        }

        return 'true';
    }


}
