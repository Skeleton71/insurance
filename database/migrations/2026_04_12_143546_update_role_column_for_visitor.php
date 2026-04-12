<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'editor', 'visitor'])->change();
        });

        \DB::table('users')->where('role', 'viewer')->update(['role' => 'visitor']);
    }

    public function down(): void
    {
        \DB::table('users')->where('role', 'visitor')->update(['role' => 'viewer']);
        
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'editor', 'viewer'])->change();
        });
    }
};
