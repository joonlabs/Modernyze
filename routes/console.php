<?php

use Curfle\Support\Facades\Buddy;

/**
 * This file is where you may define all of your Closure based console
 * commands. Each Closure is bound to a command instance allowing a
 * simple approach to interacting with each command's IO methods.
 */

Buddy::command("inspire", function (\Curfle\Console\Input $input) {
    $inspiring = [
        "“Ruby is rubbish! PHP is phpantastic!” – Nikita Popov",
        "“Simplicity is the soul of efficiency.” – Austin Freeman",
        "“Code is like humor. When you have to explain it, it’s bad.” – Cory House"
    ];
    $this->write($inspiring[array_rand($inspiring)]);
});

/**
 * Create the databse and run migrations.
 */
Buddy::command("setup", function (\Curfle\Console\Input $input, \Curfle\FileSystem\FileSystem $fileSystem) {
    // create database
    $dbFileName = base_path("database/database.sqlite");
    if (!$fileSystem->exists($dbFileName)) {
        $fileSystem->put($dbFileName, "");
        $this->success("Successfully created sqlite database");
    } else {
        $this->warning("Database already exists");
    }


    // call migrations
    $this->write(
        Buddy::run(\Curfle\Console\Input::fromString("migrate"))->getContent()
    );
});

/**
 * Generate a new access.
 */
Buddy::command("modernyze:generate {domain}", function (\Curfle\Console\Input $input) {
    $token = bin2hex(random_bytes(50));
    $secret = bin2hex(random_bytes(50));
    $domain = $input->namedArgument("domain");
    try {
        \App\Models\Access::create([
            "token" => $token,
            "secret" => $secret,
            "domain" => $domain
        ]);

        $this->write("Token: ");
        $this->write("$token");
        $this->write("Secret: ");
        $this->write("$secret");
        $this->warning("Remember to keep the secret safe as it valdaties the integrity of the downloaded update file.");
        $this->success("Domain [$domain] created successfully.");
    } catch (Exception $e) {
        $this->error("Could not create domain [$domain].");
    }
})->where("domain", "([a-z]|[A-Z]|[0-9]|\.|-)+");

/**
 * Delete an access.
 */
Buddy::command("modernyze:delete {id}", function (\Curfle\Console\Input $input) {
    $id = (int)$input->namedArgument("id");
    $access = \App\Models\Access::get($id);
    if ($access !== null && $access->delete())
        $this->success("Domain [{$access->domain}] deleted successfully.");
    else
        $this->warning("Could not delete entry with id [$id].");
})->where("id", "[0-9]+");

/**
 * Display all accesses.
 */
Buddy::command("modernyze:list", function (\Curfle\Console\Input $input) {
    $this->write(print_r(\App\Models\Access::all(), true));
});

/**
 * Returns the latest version of a product.
 */
Buddy::command("modernyze:latest {product}", function (\Curfle\Console\Input $input) {
    $product = $input->namedArgument("product");
    $version = \Curfle\Support\Facades\App::resolve(\App\Http\Controllers\ProductController::class)
        ->latest($product)["version"];
    $this->write($version);
})->where("product", "(\w|\-)+");
