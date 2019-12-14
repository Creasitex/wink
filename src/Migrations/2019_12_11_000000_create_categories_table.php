<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wink_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->string('name');
            $table->timestamps();

            $table->index('created_at');

            $table->text('meta')->nullable();
        });

        Schema::table('wink_posts', function (Blueprint $table) {
            $table->uuid('category_id')->index()->nullable();
            $table->foreign('category_id')->references('id')->on('wink_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('wink_posts', 'category_id')) {
            Schema::table('wink_posts', function ($table) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            });
        }

        Schema::dropIfExists('wink_categories');
    }
}
