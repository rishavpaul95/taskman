<?php

use App\Http\Controllers\AssignTaskController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ping', function () {
    $mailchimp = new \MailchimpMarketing\ApiClient();

    $mailchimp->setConfig([
        'apiKey' => config('services.mailchimp.key'),
        'server' => 'us18',
    ]);

    $response = $mailchimp->ping->get();
    print_r($response);
});

Route::get('/home', [DemoController::class, 'index']);
Route::get('/blog', [BlogController::class, 'index']);
Route::get('/blog/{post_name}', [BlogController::class, 'show']);

Route::get('/contact', [ContactController::class, 'index']);
Route::post('/contact', [ContactController::class, 'store']);
Route::get('/contact/success', [ContactController::class, 'success']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/demo/{name?}', [DemoController::class, 'show']);
    Route::get('/tasks', [TasksController::class, 'index']);
    Route::post('/tasks/add', [TasksController::class, 'store']);
    Route::get('/tasks/delete/{id}', [TasksController::class, 'delete']);
    Route::post('/tasks/edit/{id}', [TasksController::class, 'edit']);

    // Trash Section

    // Route::get('/tasks/permadelete/{id}', [TasksController::class, 'forceddelete']);
    // Route::get('/tasks/restore/{id}', [TasksController::class, 'restore']);
    // Route::get('/tasks/trash', [TasksController::class, 'viewtrash']);

    Route::middleware([
        'admin',
    ])->group(function () {



        Route::get('/admin/categories', [CategoriesController::class, 'index']);
        Route::post('/admin/categories/add', [CategoriesController::class, 'store']);
        Route::get('/admin/categories/delete/{id}', [CategoriesController::class, 'delete']);
        Route::post('/admin/categories/edit/{id}', [CategoriesController::class, 'edit']);

        Route::get('/admin/assigntask',[AssignTaskController::class, 'index']);
        Route::post('/admin/assigntask/add',[AssignTaskController::class, 'store']);
        Route::post('/admin/assigntask/edit/{id}',[AssignTaskController::class, 'edit']);
        Route::get('/admin/assigntask/delete/{id}',[AssignTaskController::class, 'delete']);

    });

    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');
});
