<?php


use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('signup', 'AuthController@signup');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
Route::ApiResource('/employee', 'EmployeeController');
Route::ApiResource('/category', 'CategoryController');
Route::ApiResource('/supplier', 'SupplierController');
Route::ApiResource('/customer', 'CustomerController');
Route::ApiResource('/product', 'ProductController');
Route::ApiResource('/expense', 'ExpenseController');

Route::Post('/salary/paid/{id}', 'SalaryController@paid');
Route::Get('/salary', 'SalaryController@salaries');
Route::Get('/salary/view/{id}', 'SalaryController@viewSalary');
Route::Get('/edit/salary/{id}', 'SalaryController@editSalary');
Route::Post('/salary/update/{id}', 'SalaryController@salaryUpdate');
Route::Post('/stock/update/{id}', 'SalaryController@stockUpdate');
