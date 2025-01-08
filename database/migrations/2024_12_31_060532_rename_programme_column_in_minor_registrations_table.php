<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('minor_registrations', function (Blueprint $table) {
            $table->renameColumn('programme', 'program_name');
        });
    }

    public function down()
    {
        Schema::table('minor_registrations', function (Blueprint $table) {
            $table->renameColumn('program_name', 'programme');
        });
    }
};
