<?php

namespace HLW\Http\Controllers\Admin;

use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function index(){

        $log = Activity::orderBy('id', 'desc')->paginate(25);

        return view('admin.log', compact('log'));
    }
}
