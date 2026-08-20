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
        Schema::create('whatsapp_lead_clicks', function (Blueprint $table) {
            $table->id();
            $table->string('source_page')->nullable()->index();
            $table->string('button_location')->nullable()->index();
            $table->text('prefilled_message')->nullable();
            $table->string('ip_address', 64)->nullable()->index();
            $table->text('user_agent')->nullable();
            $table->string('referrer')->nullable();
            $table->string('country', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_lead_clicks');
    }
};
