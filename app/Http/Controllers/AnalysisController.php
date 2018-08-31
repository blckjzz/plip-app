<?php

namespace App\Http\Controllers;

use App\Analysis;
use App\Petition;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\User;

class AnalysisController extends Controller
{


    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['isVolunteer']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = User::findOrfail(Auth::user()->id);
        $petitions = $user->volunteer->analysis;
        $title = 'Minhas tarefas';
        return view('volunteer-dashboard.assignments', compact('petitions','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($petition_id)
    {
        // returns page where volunteer post analysis for a project
        $petition = Petition::findOrFail($petition_id);
        $status  = Status::all();
        return view('volunteer-dashboard.register-assignment', compact('petition', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // stores volunteer analysis
        $user = User::findOrfail(Auth::user()->id);
        #dd($request->all());
        $analysis = new Analysis($request->all());
        $analysis->volunteer_id = $user->volunteer->id;
        $analysis->syncChanges($analysis, array($analysis));
        $petition = Petition::find($request->only('petition_id'));
        dd($petition);
        return redirect()->action('AnalysisController@index')->with(['message' => "Análise alterada com sucesso!"]);;

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // show volunteer analysis
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // volunteer can edit its analysis
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // update analysis
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        abort(403, 'you can not perform this action!');
    }
}
