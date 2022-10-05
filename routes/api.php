<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use SaltFile\Controllers\FilesResourcesController;

$version = config('app.API_VERSION', 'v1');

Route::middleware(['api'])
    ->prefix("api/{$version}")
    ->group(function () {

    // API: FILES RESOURCES
    Route::get("files", [FilesResourcesController::class, 'index']); // get entire collection
    Route::post("files", [FilesResourcesController::class, 'store']); // create new collection

    Route::get("files/trash", [FilesResourcesController::class, 'trash']); // trash of collection

    Route::post("files/import", [FilesResourcesController::class, 'import']); // import collection from external
    Route::post("files/export", [FilesResourcesController::class, 'export']); // export entire collection
    Route::get("files/report", [FilesResourcesController::class, 'report']); // report collection

    Route::get("files/{id}/trashed", [FilesResourcesController::class, 'trashed'])->where('id', '[a-zA-Z0-9-]+'); // get collection by ID from trash

    // RESTORE data by ID (id), selected IDs (selected), and All data (all)
    Route::post("files/{id}/restore", [FilesResourcesController::class, 'restore'])->where('id', '[a-zA-Z0-9-]+'); // restore collection by ID

    // DELETE data by ID (id), selected IDs (selected), and All data (all)
    Route::delete("files/{id}/delete", [FilesResourcesController::class, 'delete'])->where('id', '[a-zA-Z0-9-]+'); // hard delete collection by ID

    Route::get("files/{id}", [FilesResourcesController::class, 'show'])->where('id', '[a-zA-Z0-9-]+'); // get collection by ID
    Route::put("files/{id}", [FilesResourcesController::class, 'update'])->where('id', '[a-zA-Z0-9-]+'); // update collection by ID
    Route::patch("files/{id}", [FilesResourcesController::class, 'patch'])->where('id', '[a-zA-Z0-9-]+'); // patch collection by ID
    // DESTROY data by ID (id), selected IDs (selected), and All data (all)
    Route::delete("files/{id}", [FilesResourcesController::class, 'destroy'])->where('id', '[a-zA-Z0-9-]+'); // soft delete a collection by ID

    Route::post("files/upcreate", [FilesResourcesController::class, 'upCreate']);

});
