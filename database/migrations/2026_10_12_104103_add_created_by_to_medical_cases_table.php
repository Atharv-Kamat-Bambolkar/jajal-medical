<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('medical_cases', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->after('id')
            ->constrained('users')->nullOnDelete();
        });

        // Correct existing demo data.
        DB::table('medical_cases')->where('priority', 'Normal')
        ->update(['priority' => 'Medium']);

        DB::table('medical_cases')->where('priority', 'Urgent')
        ->update(['priority' => 'High']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_cases', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by');
        });
    }
};
