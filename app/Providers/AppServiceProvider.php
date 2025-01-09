<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use DB;

class AppServiceProvider extends ServiceProvider
{
public function boot()
{
// Set timezone for database connection
DB::statement("SET time_zone = '+08:00'");

// Optional: You can also configure MySQL session timezone
DB::statement("SET SESSION time_zone = '+08:00'");
}

public function register()
{
//
}
}
