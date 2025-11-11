<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('asset_transfers', function (Blueprint $table) {
        $table->id();
        $table->foreignId('from_user_id')->constrained('users');
        $table->foreignId('to_user_id')->constrained('users');
        $table->decimal('total_from', 12, 2);
        $table->decimal('total_to', 12, 2);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_transfers');
    }
};
