<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PostsController;

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

Route::get('/', [HomeController::class, 'home'])->name('home.index');
Route::get('contact',  [HomeController::class, 'contact'])->name('home.contact');
Route::get('single', AboutController::class);


Route::resource('posts', PostsController::class)->only(['index','show','create','store', 'edit','destroy', 'update']);//->only(['index', 'show', 'create', 'store', 'edit', 'update']);
// Route::get('/posts', function(Request $request) use ($posts) {
//     dd($request->boolean('limit'));
//     return view('posts.index', ['posts' => $posts]);
// })->name('posts.index');

// Route::get('/posts/{id?}', function($id=1) use ($posts) {
//      abort_if(!isset($posts[$id]), 404);
//     return view('posts.show', ['post' => $posts[$id]]);
// })->name('posts.show');

// Route::prefix('/fun')->name('fun.')->group(function() use ($posts) {

//         Route::get('/responses', function() use ($posts) {
//             return response($posts, 201)
//                         ->header('Content-Type', ' application/json')->cookie('My_COOKIE', 'Naaman' , 3600);
//         })->name('responses');
        
//         Route::get('/redirect', function() {
//             return redirect('/contact');
//         });

//         Route::get('/away', function() {
//             return redirect()->away('http://www.google.com');
//         });

//         Route::get('/json', function() use ($posts) {     
//             return response()->json($posts);
//         });
        
//         Route::get('/named-route', function() {
//             return redirect()->route('posts.show', ['id' => 1]);
//         });
// });
