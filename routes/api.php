<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
	"prefix" => "v1",
	"namespace" => "Api\V1",
	"middleware" => ["auth:api"]
], function(){
	Route::apiResources([
		'posts' => 'PostController',
		'users' => 'UserController',
		'comments' => 'CommentController'
	]);

	Route::get('/posts/{post}/relationships/author', 'PostRelationshipController@author')->name('posts.relationships.author');

	Route::get('/posts/{post}/author', 'PostRelationshipController@author')->name('posts.author');

	Route::get('/posts/{post}/relationships/comments', 'PostRelationshipController@comments')->name('posts.relationships.comments');

	Route::get('/posts/{post}/comments', 'PostRelationshipController@comments')->name('posts.comments');

});

Route::post('login', 'Api\AuthController@login');
Route::post('signup', 'Api\AuthController@signup');