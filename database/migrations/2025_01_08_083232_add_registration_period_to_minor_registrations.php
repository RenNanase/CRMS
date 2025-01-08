<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('minor_registrations', function (Blueprint $table) {
            $table->foreignId('registration_period_id')
                ->nullable()
                ->constrained('registration_periods')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('minor_registrations', function (Blueprint $table) {
            $table->dropForeign(['registration_period_id']);
            $table->dropColumn('registration_period_id');
        });
    }
};
