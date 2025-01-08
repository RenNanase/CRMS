<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::table('news')->where('image', 'like', 'public/news%')->update([
            'image' => DB::raw("REPLACE(image, 'public/news', 'news')")
        ]);
    }

    public function down()
    {
        // If you need to reverse the changes
        DB::table('news')->where('image', 'like', 'news%')->update([
            'image' => DB::raw("CONCAT('public/', image)")
        ]);
    }
};
