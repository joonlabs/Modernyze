<?php

use Curfle\Support\Facades\Route;

/**
 * Here the default web routes can be registered. All routes in this directory get
 * will receive the web middleware stack. Now start creating something awesome!
 */

/**
 * Download a file from the "scripts" folder.
 */
Route::get("/download/{path}", function (\Curfle\Http\Request $request, \Curfle\Http\Response $response, \Curfle\FileSystem\FileSystem $files) {
    // check if file exists and download
    $filename = resource_path("/scripts/" . $request->input("path"));
    if ($files->exists($filename))
        return $response->setHeader(
            "Content-Disposition",
            "attachment; filename=\"{$files->name($filename)}\"")
            ->setContent($files->get($filename));

    // throw exception
    throw new \Curfle\Support\Exceptions\Http\Dispatchable\HttpNotFoundException();
})->where("path", "(\w|/)+");