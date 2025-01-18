<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lookups', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // e.g., 'country', 'role', etc.
            $table->string('name'); // e.g., 'Admin', 'User', etc.
            $table->string('code')->nullable(); // Optional code for lookup (e.g., country code)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lookups');
    }
};
