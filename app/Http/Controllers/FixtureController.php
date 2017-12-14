<?php

namespace HLW\Http\Controllers;

use HLW\Fixture;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \HLW\Fixture  $fixture
     * @return \Illuminate\Http\Response
     */
    public function show(Fixture $fixture)
    {
        $fixture->load([
           'clubHome',
           'clubAway',
           'stadium',
           'goals',
           'cards'
        ]);

        return view('fixtures.show', compact('fixture'));
    }

}
