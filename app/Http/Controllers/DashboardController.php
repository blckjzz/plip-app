<?php

namespace App\Http\Controllers;

use App\Petition;
use Carbon\Carbon;
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

        $publicados = DB::table('analyses')
            ->join('petitions', 'petitions.id', '=', 'analyses.petition_id')
            ->join('volunteers', 'volunteers.id', '=', 'analyses.volunteer_id')
            ->where('volunteer_id', '=', Auth::user()->volunteer->id)
            ->where('petitions.status_id', '=', 6)
            ->get()->count();


        $reprovadas = DB::table('analyses')
            ->join('petitions', 'petitions.id', '=', 'analyses.petition_id')
            ->join('volunteers', 'volunteers.id', '=', 'analyses.volunteer_id')
            ->where('volunteer_id', '=', Auth::user()->volunteer->id)
            ->where('petitions.status_id', '=', [4, 5])
            ->get()->count();

        $meusPLs = DB::table('analyses')
            ->join('petitions', 'petitions.id', '=', 'analyses.petition_id')
            ->join('volunteers', 'volunteers.id', '=', 'analyses.volunteer_id')
            ->where('volunteer_id', '=', Auth::user()->volunteer->id)
            ->where('petitions.status_id', '=', 2)
            ->get()->count();


        return view('layouts.home', compact('reprovadas', 'analiseAprovada', 'publicados', 'meusPLs'));
    }


    public function getAdminCardValues()
    {
        $petitionCount = Petition::all()->count();
        $petitionInAnalisys = Petition::all()->where('status_id', '=', '2')->count();
        $new_projects = Petition::all()->where('submitDate', '>=', Carbon::today()->subDays(7))->count();
        return view('layouts.home', compact('petitionCount', 'petitionInAnalisys', 'new_projects'));
    }
}
