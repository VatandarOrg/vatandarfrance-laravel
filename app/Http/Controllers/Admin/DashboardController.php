<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $usd_price = Redis::get('usd_price');

        return view('admin.dashboard', compact('usd_price'));
    }
}
