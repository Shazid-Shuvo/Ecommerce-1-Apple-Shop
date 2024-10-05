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
        Schema::create('sslcomerz_acccounts', function (Blueprint $table) {
            $table->id();

            $table->string('store_id',50);
            $table->string('store_password',50);
            $table->string('currency',50);
            $table->string('success_url',50);
            $table->string('fail_url',50);
            $table->string('cancel_url',50);
            $table->string('ipn_url',50);
            $table->string('init_url',50);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sslcomerz_acccounts');
    }
};
