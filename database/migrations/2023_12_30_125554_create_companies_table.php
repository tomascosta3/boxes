<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->string('business_name')->nullable();

            $table->string('cuit', 20)->nullable();

            $table->string('address')->nullable();

            $table->string('city')->nullable();

            $table->string('province')->nullable();

            $table->string('country')->nullable();

            $table->string('domain')->nullable();

            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
