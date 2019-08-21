<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Метаданные конструктора - информация о таблице и хранимых столбцах
 * Class ConstructorMetadata
 * @package App\src\Models
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
        'enums' // Перечисляемые значения для таблиц типа OneFromMany и ManyFromMany
    ];
    
    public function getEnumsAttribute($value)
    {
        return json_decode($value, true);
    }
}
