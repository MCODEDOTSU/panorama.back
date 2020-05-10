<?php

use Illuminate\Support\Facades\Route;

// Аутентификация
Route::post('login', 'Auth\LoginController@login');
Route::post('register', 'Auth\UserController@register');
//Route::post('register', 'Auth\RegisterController@create');

Route::group([ 'middleware' => 'auth:api' ], function() {

    Route::get('logout', 'Auth\LoginController@logout');
    Route::get('user', 'UserController@getUser');

    /**
     * Модули
     */
    Route::get('modules', 'ModuleController@getModules');
    Route::get('all_modules', 'ModuleController@getAllModules');

    /**
     * Редактор контрагентов
     */
    Route::prefix('/manager/contractor')->namespace('Manager')->group(function () {
        Route::get('/', 'ContractorController@getAll');
        Route::get('/{id}', 'ContractorController@getById');
        Route::put('/{id}', 'ContractorController@update');
        Route::post('/', 'ContractorController@create');
        Route::delete('/{id}', 'ContractorController@delete');
        Route::get('/{id}/attach/module/{module_id}', 'ContractorController@attachModule');
        Route::get('/{id}/detach/module/{module_id}', 'ContractorController@detachModule');
        Route::post('/upload', 'ContractorController@uploadLogo');
    });

    /**
     * Редактор пользователей контрагента
     */
    Route::prefix('/manager/user')->group(function () {
        Route::get('/{contractor_id}', 'UserController@getAllByContractor');
        Route::put('/', 'UserController@update');
        Route::post('/', 'UserController@create');
        Route::delete('/{id}', 'UserController@delete');
        Route::post('/upload', 'UserController@uploadPhoto');
    });

    /**
     * Редактор модулей
     */
    Route::prefix('/manager/module')->namespace('Manager')->group(function () {
        Route::get('/', 'ModuleController@getAll');
        Route::put('/{id}', 'ModuleController@update');
        Route::post('/', 'ModuleController@create');
        Route::delete('/{id}', 'ModuleController@delete');
    });

    /**
     * Редактор слоев
     */
    Route::prefix('/manager/layer')->namespace('Manager')->group(function () {
        Route::get('/', 'LayerController@getAll');
        Route::get('/{id}', 'LayerController@getById');
        Route::put('/{id}', 'LayerController@update');
        Route::post('/', 'LayerController@create');
        Route::delete('/{id}', 'LayerController@delete');
        Route::post('/upload', 'LayerController@uploadIcon');
    });

    /**
     * Редактор элементов слоя
     */
    Route::prefix('/manager/element')->namespace('Manager')->group(function () {
        Route::get('/layer/{layerId}', 'ElementController@getAll');
        Route::get('/{id}', 'ElementController@getById');
        Route::put('/{id}', 'ElementController@update');
        Route::post('/', 'ElementController@create');
        Route::delete('/{id}', 'ElementController@delete');
    });

    /**
     * GIS-редактор
     */
    Route::prefix('/gis')->namespace('Gis')->group(function () {
        Route::get('/layer/contractor', 'LayerController@getAllToContractor');
        Route::post('/element', 'ElementController@create');
        Route::put('/element/{id}', 'ElementController@update');
        Route::put('/geometry/{id}', 'ElementController@updateGeometry');
        Route::delete('/element/{id}', 'ElementController@delete');
    });

    /**
     * Конструктор полей
     */
    Route::prefix('/constructor')->namespace('Constructor')->group(function () {
        Route::get('/{layerId}', 'ConstructorController@getToLayer');
        Route::post('/{layerId}', 'ConstructorController@create');
        Route::put('/{layerId}', 'ConstructorController@update');
    });

    // TODO: check if route and cooresponding method are used
    Route::get('/constructor/get_specific_type/{type}', 'Constructor\ConstructorController@getSpecificType');
    Route::post('/util/file/upload', 'Constructor\UploadController@uploadFile');
    Route::post('/util/file/download', 'Constructor\UploadController@downloadFile');
    Route::post('/util/file/delete', 'Constructor\UploadController@deleteFile');


});

/**
 * GIS
 */
Route::prefix('/gis')->namespace('Gis')->group(function () {
    Route::get('/layer', 'LayerController@getAll');
    Route::post('/layer/few', 'LayerController@getFewById');
    Route::get('/element/link/{id}', 'ElementController@links');
});

/**
 * Конструктор полей
 */
Route::prefix('/constructor')->namespace('Constructor')->group(function () {
    Route::get('/{layerId}/{elementId}', 'AdditionalInfoController@getData');
});


Route::prefix('/kmz')->namespace('Utilities')->group(function () {
   Route::post('/parse', 'KMZParseController@parse');
});
