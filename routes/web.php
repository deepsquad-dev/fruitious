<?php

use App\Http\Resources\FruitResource;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\FruitController;
use App\Models\Fruit;
use Inertia\Inertia;

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

//Route::get('{any}', function () {
//    return Inertia::render('Main', [
//        'items' => FruitResource::collection(Fruit::all())
//    ]);
//})->where('any', '.*');

Route::get('/fruit', [FruitController::class, 'index']);

Route::get('/', function () {
    return Inertia::render('Main', [
        'items' => FruitResource::collection(Fruit::all())
    ]);
})->where('/', '.*');

Route::get('/{id}/edit', function ($id) {
    return Inertia::render('Update', [
        'data' => Fruit::find($id)
    ]);
});

Route::put('update/{id}', [FruitController::class, 'update']);

