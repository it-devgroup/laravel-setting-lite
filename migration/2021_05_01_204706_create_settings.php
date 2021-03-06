<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSettings
 */
class CreateSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{{TABLE_NAME}}', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->unique()->index();
            $table->text('description')->nullable();
            $table->text('value')->nullable();
            $table->json('options')->nullable();
            $table->string('type');
            $table->string('group')->index()->nullable();
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('{{TABLE_NAME}}');
    }
}
