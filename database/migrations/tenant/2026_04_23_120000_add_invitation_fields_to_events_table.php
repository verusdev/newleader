<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('invitation_token')->nullable()->unique()->after('status');
        });

        DB::table('events')->whereNull('invitation_token')->orderBy('id')->get()->each(function ($event) {
            DB::table('events')
                ->where('id', $event->id)
                ->update(['invitation_token' => Str::random(32)]);
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropUnique(['invitation_token']);
            $table->dropColumn('invitation_token');
        });
    }
};
