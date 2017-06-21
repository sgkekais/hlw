<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function index(){

        $log = Activity::all()->sortByDesc('id');

        return view('admin.log', compact('log'));
    }
}
