<?php

namespace App\Http\Controllers;

use App\Petition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getCardValues()
    {
        $analiseAprovada = DB::table('analyses')
            ->join('petitions', 'petitions.id', '=', 'analyses.petition_id')
            ->join('volunteers', 'volunteers.id', '=', 'analyses.volunteer_id')
            ->where('volunteer_id', '=', Auth::user()->volunteer->id)
            ->where('petitions.status_id', '=', 5)
            ->get()->count();


        $reprovadas = DB::table('analyses')
            ->join('petitions', 'petitions.id', '=', 'analyses.petition_id')
            ->join('volunteers', 'volunteers.id', '=', 'analyses.volunteer_id')
            ->where('volunteer_id', '=', Auth::user()->volunteer->id)
            ->where('petitions.status_id', '=', [4,5])
            ->get()->count();


        return view('layouts.home', compact( 'reprovadas','analiseAprovada'));
    }
}
