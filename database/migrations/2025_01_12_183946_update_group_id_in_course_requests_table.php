<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('course_requests', function (Blueprint $table) {
            // First drop the existing column
            $table->dropColumn('group_id');

            // Then add the new foreign key column
            $table->foreignId('group_id')->nullable()->constrained('groups')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('course_requests', function (Blueprint $table) {
            // Remove the foreign key constraint
            $table->dropForeign(['group_id']);

            // Add back the original column
            $table->unsignedBigInteger('group_id')->nullable();
        });
    }
};
