<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*

|--------------------------------------------------------------------------

| Admin Routes

|--------------------------------------------------------------------------

|

| Here is where you can register admin routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| contains the "admin" middleware group. Now create something great!

|

*/



Route::get('/', function () {
    return 'Welcome to admin user routes.';
});
Route::get('/admin/{name}', function ($name) {
    return "Welcome to admin user routes. Your name $name";
});
Route::post('/auth/login', [AuthController::class, 'admin_login']);
