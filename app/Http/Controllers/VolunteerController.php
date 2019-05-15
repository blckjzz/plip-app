<?php

namespace App\Http\Controllers;

use App\Http\Requests\VolunteerCreationRequest;
use App\User;
use App\Volunteer;
use Illuminate\Http\Request;
use DB;

class VolunteerController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $voluntarios = Volunteer::all();
        return view('volunteer.index', ['voluntarios' => $voluntarios]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('volunteer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(VolunteerCreationRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role_id = 2; // (1) - Admin ==== (2) -  volunteer
            $user->password = bcrypt($request->password);
            $user->is_active = 1;
            $user->save();
            $voluntario = new Volunteer($request->all());
            $voluntario->user_id = $user->id;
            $voluntario->save();
        });
        return redirect()->action('VolunteerController@index')->with(['message' => 'Voluntário criado com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Volunteer $volunteer
     * @return \Illuminate\Http\Response
     */
    public function show(Volunteer $volunteer)
    {
        dd($volunteer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Volunteer $volunteer
     * @return \Illuminate\Http\Response
     */
    public function edit(Volunteer $volunteer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Volunteer $volunteer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Volunteer $volunteer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Volunteer $volunteer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Volunteer $volunteer)
    {
        //
    }
}
