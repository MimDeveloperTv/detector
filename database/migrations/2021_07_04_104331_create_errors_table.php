<?php

use Illuminate\Database\Migrations\Migration;
use Tpetry\PostgresqlEnhanced\Schema\Blueprint;
use Tpetry\PostgresqlEnhanced\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('errors', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('provider', 50)->index();
            $table->string('code', 10)->index();
            $table->string('status', 3)->index();
            $table->integer('count')->index();
            $table->text('encoded_message')->nullable();
            $table->text('message')->nullable();

            $table->timestamps(6);
            $table->index('created_at');
            $table->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('errors');
    }
};
