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
        Schema::table('guests', function (Blueprint $table) {
            $table->string('invitation_token')->nullable()->unique()->after('category');
            $table->string('rsvp_status')->nullable()->after('confirmed');
            $table->timestamp('responded_at')->nullable()->after('rsvp_status');
        });

        DB::table('guests')->whereNull('invitation_token')->orderBy('id')->get()->each(function ($guest) {
            DB::table('guests')
                ->where('id', $guest->id)
                ->update([
                    'invitation_token' => Str::random(32),
                    'rsvp_status' => $guest->confirmed ? 'confirmed' : null,
                ]);
        });
    }

    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropUnique(['invitation_token']);
            $table->dropColumn([
                'invitation_token',
                'rsvp_status',
                'responded_at',
            ]);
        });
    }
};
