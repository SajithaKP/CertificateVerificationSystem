<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('field_settings', function (Blueprint $table) {
            $table->id();
            $table->string('field_name'); // Name of the field, e.g., 'address'
            $table->boolean('is_enabled')->default(true); // If true, field is enabled
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('field_settings');
    }
};
