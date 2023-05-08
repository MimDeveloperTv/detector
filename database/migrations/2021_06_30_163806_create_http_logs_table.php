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
        Schema::create('http_logs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('user_id', 36)->nullable()->index();
            $table->string('reference_id', 50)->index();
            $table->string('type', 50)->index();
            $table->string('supplier', 50)->index();
            $table->string('status', 3)->index();
            $table->text('url')->nullable();
            $table->decimal('duration', 15, 12)->nullable();
            $table->text('request')->nullable();
            $table->text('response')->nullable();
            $table->timestamp('created_at', 6)->index()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('http_logs');
    }
};
