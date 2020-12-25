<?php

use Illuminate\Support\Facades\Route;

// Аутентификация
Route::post('login', 'Auth\LoginController@login');
//Route::post('register', 'Auth\UserController@register');
//Route::post('register', 'Auth\RegisterController@create');

Route::group([ 'middleware' => 'auth:api' ], function() {

    Route::get('logout', 'Auth\LoginController@logout');

    Route::post('export', 'ToolController@export');

    Route::prefix('/export')->group(function () {
        Route::post('/excel', 'ToolController@exportExcel');
    });

    /**
     * Модули
     */
    // Route::get('modules', 'ModuleController@getModules');
    // Route::get('all_modules', 'ModuleController@getAllModules');

    /**
     * Регионы
     */
    Route::prefix('/regions')->group(function () {
        Route::get('/', 'RegionController@index');
    });

    /**
     * Контрагенты
     */
    Route::prefix('/contractor')->group(function () {
        Route::get('/', 'ContractorController@getAll');
        Route::get('/{id}', 'ContractorController@getById');
        Route::post('/', 'ContractorController@create');
        Route::put('/', 'ContractorController@update');
        Route::delete('/{id}', 'ContractorController@delete');
        Route::get('/{id}/attach/module/{module_id}', 'ContractorController@attachModule');
        Route::get('/{id}/detach/module/{module_id}', 'ContractorController@detachModule');
        Route::post('/upload', 'ContractorController@uploadLogo');
        // Route::post('/detach_parent_contractor', 'ContractorController@detachParentContractor');
    });

    /**
     * ТОСы
     */
    Route::prefix('/tos')->group(function () {
        Route::get('/', 'ContractorTosController@getAll');
        Route::get('/{id}', 'ContractorTosController@getById');
        Route::post('/', 'ContractorTosController@create');
        Route::put('/{id}', 'ContractorTosController@update');
        Route::delete('/{id}', 'ContractorTosController@delete');
        Route::post('/address/{tos}', 'ContractorTosController@addAddress');
        Route::delete('/address/{tos}/{address}', 'ContractorTosController@deleteAddress');
        Route::get('/fias/{fias_id}', 'ContractorTosController@getByAddress');
    });

    /**
     * ТСЖ
     */
    Route::prefix('/tszh')->group(function () {
        Route::get('/', 'ContractorTszhController@getAll');
        Route::get('/{id}', 'ContractorTszhController@getById');
        Route::post('/', 'ContractorTszhController@create');
        Route::put('/{id}', 'ContractorTszhController@update');
        Route::delete('/{id}', 'ContractorTszhController@delete');
        Route::get('/fias/{fias_id}', 'ContractorTszhController@getByAddress');
    });

    /**
     * Физические лица
     */
    Route::prefix('/person')->group(function () {
        Route::get('/birthday/', 'PersonController@birthday');
        Route::get('/', 'PersonController@getAll');
        Route::get('/{id}', 'PersonController@getById');
        Route::post('/', 'PersonController@create');
        Route::put('/{id}', 'PersonController@update');
        Route::delete('/{id}', 'PersonController@delete');
        Route::post('/upload', 'PersonController@uploadPhoto');
        Route::post('/history/{person}', 'PersonController@createHistory');
        Route::put('/history/{person}', 'PersonController@updateHistory');
        Route::delete('/history/{person}/{history}', 'PersonController@deleteHistory');
    });

    /**
     * Пользователи
     */
    Route::prefix('/user')->group(function () {
        Route::get('/', 'UserController@getUser');
        Route::get('/{contractor_id}', 'UserController@getAllByContractor');
        Route::post('/', 'UserController@create');
        Route::put('/', 'UserController@update');
        Route::delete('/{id}', 'UserController@delete');
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
        Route::get('/contractor/get', 'LayerController@getAllToContractor');
        Route::get('/type/{type}', 'LayerController@getByType');
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
        Route::get('/layer/{layerId}/{limit}/{page}', 'ElementController@getAllLimit');
        Route::get('/search/{search}/{limit}/{page}', 'ElementController@getSearchLimit');
        Route::get('/layer/count/{layerId}', 'ElementController@getCount');
        Route::get('/search/count/{search}', 'ElementController@getSearchCount');
        Route::get('/{id}', 'ElementController@getById');
        Route::put('/{id}', 'ElementController@update');
        Route::post('/', 'ElementController@create');
        Route::delete('/{id}', 'ElementController@delete');
        Route::post('/delete/some', 'ElementController@deleteSome');
        Route::get('/graph/{id}', 'ElementController@getNext');
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

    /**
     * Additional
     */
    Route::prefix('/files')->namespace('Constructor')->group(function () {
        Route::post('/upload', 'UploadController@uploadFiles');
    });

    // TODO: check if route and cooresponding method are used
    Route::get('/constructor/get_specific_type/{type}', 'Constructor\ConstructorController@getSpecificType');
    // Route::post('/util/file/upload', 'Constructor\UploadController@uploadFile');
    Route::post('/util/file/download', 'Constructor\UploadController@downloadFile');
    Route::post('/util/file/delete', 'Constructor\UploadController@deleteFile');

    /**
     * Парсер
     */
    Route::prefix('/kmz')->namespace('Utilities')->group(function () {
        Route::post('/parse', 'KMZParseController@parse');
    });

    Route::prefix('/xls')->namespace('Utilities')->group(function () {
        Route::post('/parse', 'XLSParseController@parse');
    });


});

Route::get('/directory', 'Constructor\DirectoryController@get');
Route::get('/directory/entities/{entity_name}', 'Constructor\DirectoryController@getEntities');

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


