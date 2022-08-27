<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function __invoke()
    {
        return config('database.connections.mysql.host');
    }
}
