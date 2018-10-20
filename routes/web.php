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

Route::group(['prefix' => 'api/v1', 'namespace' => 'Api\V1'], function() {
    //tasks level 1
    Route::post('scan', 'BooksController@scan');
    Route::get('top_authors', 'BooksController@topAuthors');
    Route::get('books', 'BooksController@getBooks');

    //tasks level 2
    Route::get('average_by_years', 'BooksController@getAverageByYears');
});
