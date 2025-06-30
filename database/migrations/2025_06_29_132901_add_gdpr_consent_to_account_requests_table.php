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
        Schema::table('account_requests', function (Blueprint $table) {
            $table->boolean('gdpr_consent')->default(false)->after('customer_number');
            $table->timestamp('gdpr_consent_date')->nullable()->after('gdpr_consent');
            $table->string('gdpr_consent_ip', 45)->nullable()->after('gdpr_consent_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('account_requests', function (Blueprint $table) {
            $table->dropColumn(['gdpr_consent', 'gdpr_consent_date', 'gdpr_consent_ip']);
        });
    }
};
