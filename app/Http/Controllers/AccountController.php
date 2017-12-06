<?php

namespace HLW\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     *
     */
    public function update()
    {

    }
}
