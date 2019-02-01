<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'xml'], function () {

    Route::prefix('items')->group(function() {
        Route::get('/', 'System\XML\ItemsController@index')->name('xml.items');
        Route::get('/custom', 'System\XML\ItemsController@customItems')->name('xml.items.custom');
        

        Route::post('/send', 'System\XML\ItemsController@sendXML')->name('xml.items.send');
    });
    
    
});