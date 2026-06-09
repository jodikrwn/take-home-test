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
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ship_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal_servis');
            $table->string('jenis_servis');
            $table->decimal('biaya', 15, 2)->default(0);
            $table->enum('status', ['planned', 'ongoing', 'completed'])->default('planned');
            $table->timestamps();

            $table->index(['ship_id', 'status']);
            $table->index(['ship_id', 'tanggal_servis']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_logs');
    }
};
