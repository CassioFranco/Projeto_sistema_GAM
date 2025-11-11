<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('asset_transfer_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_transfer_id')->constrained('asset_transfers')->onDelete('cascade');
            $table->foreignId('asset_id')->constrained('assets');
            $table->enum('side', ['from', 'to']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_transfer_items');
    }
};
