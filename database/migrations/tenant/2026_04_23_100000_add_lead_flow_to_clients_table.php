<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('type')->default('lead')->after('name');
            $table->string('pipeline_stage')->default('new_lead')->after('type');
            $table->timestamp('contract_signed_at')->nullable()->after('pipeline_stage');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'pipeline_stage',
                'contract_signed_at',
            ]);
        });
    }
};
