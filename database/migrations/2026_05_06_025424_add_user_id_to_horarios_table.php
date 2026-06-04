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
        Schema::table('horarios', function (Blueprint $table) {
            if (!Schema::hasColumn('horarios', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('profesor_id')->constrained('users')->onDelete('cascade');
            }
        });

        if (Schema::hasColumn('horarios', 'profesor_id')) {
            DB::table('horarios')
                ->join('profesores', 'horarios.profesor_id', '=', 'profesores.id')
                ->whereNotNull('profesores.user_id')
                ->update([
                    'horarios.user_id' => DB::raw('profesores.user_id')
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('horarios', function (Blueprint $table) {
            if (Schema::hasColumn('horarios', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};
