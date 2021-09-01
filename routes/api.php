<?php

use App\Models\User;
use Curfle\Http\Request;
use Curfle\Http\Response;
use Curfle\Support\Facades\File;
use Curfle\Support\Facades\Route;

/**
 * Here the api routes can be registered. All routes in this directory
 * will receive the "api" middleware group. Also, they will get the
 * "/api" prefix. Enjoy building your api!
 */

// all products
Route::get("/products/all", [\App\Http\Controllers\ProductController::class, "all"])->middleware("auth");

// all product versions
Route::get("/product/{product}/versions", [\App\Http\Controllers\ProductController::class, "versions"])->where("product", "([a-z]|[A-Z]|[0-9]|-)+")->middleware("auth");

// latest version of a product
Route::get("/product/{product}/latest", [\App\Http\Controllers\ProductController::class, "latest"])->where("product", "([a-z]|[A-Z]|[0-9]|-)+")->middleware("auth");

// information about a product version
Route::get("/product/{product}/{version}", [\App\Http\Controllers\ProductController::class, "version"])->where("product", "([a-z]|[A-Z]|[0-9]|-)+")->where("version", "[0-9]+\.[0-9]+\.[0-9]+")->middleware("auth");

// download a product version
Route::get("/product/{product}/{version}/download", function (Request $request, Response $response) {
    // download product version
    $product = $request->input("product");
    $version = "v" . $request->input("version") . ".zip";
    $filePath = base_path(env("SERVING_DIRECTORY")) . "/$product/$version";
    if (!File::exists($filePath))
        abort(404, "Not found");


    $response->setHeader("Content-type", "application/octet-stream");
    $response->setHeader("Content-Disposition", "attachment; filename=$version");
    $response->setHeader("Pragma", "no-cache");
    $response->setHeader("Expires", 0);
    $response->sendHeaders();
    readfile($filePath);
})->where("product", "([a-z]|[A-Z]|[0-9]|-)+")
    ->where("version", "[0-9]+\.[0-9]+\.[0-9]+")
    ->middleware("auth");