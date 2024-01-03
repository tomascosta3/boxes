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
        Schema::create('clients', function (Blueprint $table) {
            
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->string('first_name');

            $table->string('last_name');

            $table->string('address')->nullable();

            $table->string('locality')->nullable();

            $table->string('province')->nullable();

            $table->string('postal_code')->nullable();

            $table->string('phone_number');

            $table->string('email');

            $table->string('cuit')->nullable();

            $table->boolean('subscribed_client')->default(false);

            $table->boolean('end_client')->default(true);

            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
