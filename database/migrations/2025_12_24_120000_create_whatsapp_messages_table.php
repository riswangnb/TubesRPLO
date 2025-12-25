<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('target')->nullable();
            $table->string('country_code')->nullable();
            $table->text('message')->nullable();
            $table->longText('response')->nullable();
            $table->string('request_id')->nullable();
            $table->string('status')->nullable(); // queued, sent, failed, delivered
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_messages');
    }
};
