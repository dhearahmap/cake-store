<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\{CakeController, CakeTypeController, StoreController};

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    "auth:sanctum",
    config("jetstream.auth_session"),
    "verified",
])->group(function () {
    // Cakes Endpoint
    Route::group(
        [
            "prefix" => "cakes",
            "as" => "cakes.",
        ],
        function () {
            Route::get("/", [CakeController::class, "index"])->name("index");
            Route::get("create", [CakeController::class, "create"])->name(
                "create"
            );
            Route::post("store", [CakeController::class, "store"])->name(
                "store"
            );
            Route::get("{id}/edit", [CakeController::class, "edit"])->name(
                "edit"
            );
            Route::put("{id}/update", [CakeController::class, "update"])->name(
                "update"
            );
            Route::get("{id}/destroy", [
                CakeController::class,
                "destroy",
            ])->name("destroy");

            // Cake Types Endpoint
            Route::group(
                [
                    "prefix" => "types",
                    "as" => "types.",
                ],
                function () {
                    Route::get("/", [
                        CakeTypeController::class,
                        "index",
                    ])->name("index");
                    Route::get("create", [
                        CakeTypeController::class,
                        "create",
                    ])->name("create");
                    Route::post("store", [
                        CakeTypeController::class,
                        "store",
                    ])->name("store");
                    Route::get("{id}/edit", [
                        CakeTypeController::class,
                        "edit",
                    ])->name("edit");
                    Route::put("{id}/update", [
                        CakeTypeController::class,
                        "update",
                    ])->name("update");
                    Route::get("{id}/destroy", [
                        CakeTypeController::class,
                        "destroy",
                    ])->name("destroy");
                }
            );

            // Cake Stores Endpoint
            Route::group(
                [
                    "prefix" => "stores",
                    "as" => "stores.",
                ],
                function () {
                    Route::get("/", [
                        StoreController::class,
                        "index",
                    ])->name("index");
                    Route::get("create", [
                        StoreController::class,
                        "create",
                    ])->name("create");
                    Route::post("store", [
                        StoreController::class,
                        "store",
                    ])->name("store");
                    Route::get("{id}/edit", [
                        StoreController::class,
                        "edit",
                    ])->name("edit");
                    Route::put("{id}/update", [
                        StoreController::class,
                        "update",
                    ])->name("update");
                    Route::get("{id}/destroy", [
                        StoreController::class,
                        "destroy",
                    ])->name("destroy");
                }
            );
        }
    );
});
