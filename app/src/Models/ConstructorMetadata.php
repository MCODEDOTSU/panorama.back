<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Метаданные конструктора - информация о таблице и хранимых столбцах
 * Class ConstructorMetadata
 * @property mixed tech_title
 * @property mixed title
 * @property mixed type
 * @property mixed required
 * @property false|mixed|string enums
 * @property mixed group
 * @property mixed is_deleted
 * @property false|mixed|string options
 * @package App\src\Models
 * @method static select(string $string, string $string1)
 * @method where(string $string, string $tableIdentifier)
 * @method create(array $columnData)
 * @method find(int $id)
 */
class ConstructorMetadata extends Model
{
    protected $table = 'constructor_metadata';

    protected $fillable = [
        'table_identifier', // Идентификатор таблицы
        'title', // Наименование столбца при таблице
        'tech_title', // Техническое наименование столбца при таблице
        'required', // Является ли столбец nullable
        'type', // Тип столбца (namespace: src/Services/Constructor/Entities)
        'enums', // Перечисляемые значения для таблиц типа OneFromMany и ManyFromMany
        'group', // Группа к которой относится поле
        'is_deleted', // Признак того, что поле было удалено
        'options', // json поле в котором хранятся доп. настройки
    ];

    public function getEnumsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getRequiredAttribute($value)
    {
        if($value == 1) {
            return true;
        }

        return false;
    }

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }
}
