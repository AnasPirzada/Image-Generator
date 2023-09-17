<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('translated_title'); // Add translated_title column.
            $table->text('translated_description'); // Add translated_description column.
            $table->string('image_url')->nullable(); // Add image_url column.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('translated_title');
            $table->dropColumn('translated_description');
            $table->dropColumn('image_url');
        });
    }
};
