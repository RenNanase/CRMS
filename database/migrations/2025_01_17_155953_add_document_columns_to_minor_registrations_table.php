<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentColumnsToMinorRegistrationsTable extends Migration
{
    public function up()
    {
        Schema::table('minor_registrations', function (Blueprint $table) {
            $table->string('transcript_path')->after('signed_form_path');
            $table->string('additional_docs_path')->nullable()->after('transcript_path');
        });
    }

    public function down()
    {
        Schema::table('minor_registrations', function (Blueprint $table) {
            $table->dropColumn(['transcript_path', 'additional_docs_path']);
        });
    }
}
