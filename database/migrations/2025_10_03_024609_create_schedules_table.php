<?php

use App\Enums\ScheduleStatus;
use App\Models\Hall;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Hall::class)->constrained()->cascadeOnDelete();
            $table->string('event_name');
            $table->string('responsible_person');
            $table->longText('description')->nullable();
            $table->enum('status', [ScheduleStatus::PENDING, ScheduleStatus::APPROVED, ScheduleStatus::REJECTED])->default(ScheduleStatus::PENDING);
            $table->string('document')->nullable();
            $table->longText('notes')->nullable();
            $table->foreignIdFor(User::class, 'approved_rejected_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
