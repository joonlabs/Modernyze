<?php

use Curfle\Database\Migrations\Migration;
use Curfle\Database\Schema\Blueprint;
use Curfle\Support\Facades\Schema;

class CreateTableAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("access", function (Blueprint $table) {
            $table->id("id");
            $table->string("token", 100);
            $table->string("secret", 100);
            $table->string("domain", 250)->unique();
            $table->datetime("created")->defaultCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("access");
    }
}