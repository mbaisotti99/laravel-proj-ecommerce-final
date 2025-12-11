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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("codice");
            $table->foreignId("user_id");
            $table->foreignId("order_id");
            $table->foreignId("address_id");
            $table->foreignId("ship_id");
            $table->decimal("costo", 8, 2);
            $table->string("status");
            $table->longText("note")->nullable();
            $table->string("coupon")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
