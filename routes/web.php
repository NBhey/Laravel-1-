<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('tasks');
});

Route::get('/tasks', 'TaskController@index')->name('tasks.index');
Route::get('/tasks/create', 'TaskController@create')->name('tasks.create');
Route::post('/tasks', 'TaskController@store')->name('tasks.store');
Route::get('/tasks/{task}', 'TaskController@show')->name('tasks.show');
Route::get('/tasks/{task}/edit', 'TaskController@edit')->name('tasks.edit');
Route::put('/tasks/{task}', 'TaskController@update')->name('tasks.update');
Route::delete('/tasks/{task}', 'TaskController@destroy')->name('tasks.destroy');
