<?php

use Illuminate\Support\Facades\Route;

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



Auth::routes();

Route::post('follow/{user}', [App\Http\Controllers\FollowsController::class,'store']);

//home page
Route::get('/', [App\Http\Controllers\PostsController::class,'index']);
//Route to show the create post page
Route::get('/p/create', [App\Http\Controllers\PostsController::class,'create']);
//Route to store the created post (then redirect the page to /profile)
Route::post('/p', [App\Http\Controllers\PostsController::class,'store']);
//Route to see the details of post
Route::get('p/{post}', [App\Http\Controllers\PostsController::class, 'show']);

//Route::get('p/{post}', [App\Http\Controllers\PostsController::class, 'delete']);
## Beware that the order of route matter! 
## It will search from top to down
## Hence, it's a good practice to put the one with {{}} lowest possible
## cuz it will link to actual file first, then go to dynamic flie

                                //this is the controller used                   //this is the function used. 'index' is a function inside ProfilesController
Route::get('/profile/{user}', [App\Http\Controllers\ProfilesController::class, 'index'])->name('profile.show');
            //the actual route user will access                                             //profile.show is route name from laravel

//Route to show the profile edit page
Route::get('/profile/{user}/edit', [App\Http\Controllers\ProfilesController::class, 'edit'])->name('profile.edit');
//Route to update the profile 
Route::patch('/profile/{user}', [App\Http\Controllers\ProfilesController::class, 'update'])->name('profile.update');
