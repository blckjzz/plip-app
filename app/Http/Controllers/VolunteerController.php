<?php

namespace App\Http\Controllers;

use App\Analysis;
use App\Http\Requests\AnalysisCreateRequest;
use App\Http\Requests\VolunteerCreationRequest;
use App\Notifications\NewAssignment;
use App\Petition;
use App\User;
use App\Volunteer;
use http\Exception\RuntimeException;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class VolunteerController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin')->only(['index', 'create', 'store']);
        $this->middleware('checkAuthorityAnalysis')->only(['cadastraAnalise', 'getAnaliseView']);
    }

    /**
     * Lista todos os voluntários cadastrados.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $voluntarios = Volunteer::all();
        return view('volunteer.index', ['voluntarios' => $voluntarios]);
    }

    /**
     * Exibe a view de cadastro do voluntário pelo admin
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('volunteer.create');
    }

    /**
     * Cria um novo voluntário e seu usuário para acessar o painel
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
     * Exibe detalhes do voluntário para edição/visualização
     *
     * @param \App\Volunteer $volunteer
     * @return \Illuminate\Http\Response
     */
    public function show(Volunteer $volunteer)
    {
        return "Página em Construção!";
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

    /**
     * Carrega view onde o voluntário pode "Adotar PL"
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSelfAssignView()
    {
        // Petitions novas status_id = 1
        $petitions = Petition::all()->where('status_id', '=', 1);
        return view('volunteer-dashboard.auto-assign', ['petitions' => $petitions]);
    }

    /**
     * Salva um "Adota PL"
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveSelfAssign($id)
    {
        try {

            $petition = Petition::findOrFail($id);
            if (!$petition->analise) {
                $analise = new Analysis();
                $analise->volunteer_id = Auth::user()->volunteer->id;
                $analise->petition_id = $petition->id;
                $petition->status_id = 2; // em análise
                $petition->save();
                $analise->save();
                return redirect()->back()->with(['success' => 'Você adotou um PL. Agora poderá fazer sua análise. Parabéns =)']);
            }
            return redirect()->action('VolunteerController@getSelfAssignView')
                ->with('error', 'Parece que algo deu errado. Tente novamente!');
        } catch (Exception $exception) {
            return $exception->getTrace();
        }
    }

    /**
     * Voluntário pode ver detalhes da petição ao qual adotou
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewPetitionDetails($id)
    {

        return view('volunteer-dashboard.show-assignment',
            [
                'petition' => Petition::findOrFail($id),

            ]
        );
    }

    /**
     * Voluntário carrega a view onde exibe os PL's disponíveis para "adotar"
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAnalisesView()
    {

        $analises = Auth::user()->volunteer->analises;
        $title = "Meus PL's adotados";
        return view('volunteer-dashboard.assignments', compact('analises', 'title'));
    }

    public function getAnaliseView($id)
    {
        try {
            $analise = Analysis::findOrFail($id);
            return view('volunteer-dashboard.analises.analise', compact('analise'));
        } catch (Exeption $e) {
            echo $e->getCode();
            echo $e->getTrace();

        }
    }

    public function cadastraAnalise(AnalysisCreateRequest $request)
    {
        try {

            $analise = Analysis::findOrFail($request->analysis_id);
            $analise->analisys_text = $request->analisys_text;
            $analise->law_link = $request->referral_law;
            $analise->percent_votes = $request->percent_votes;
            $analise->vote_number = $request->vote_number;
            $analise->minimum_signatures = $request->minimum_signatures;
            $analise->petition()->update(['status_id' => $request->status]);
            $analise->save();

            // SALVAR STATUS NOVO DA PETIÇÃO
            return redirect()->action('VolunteerController@getAnaliseView', $analise->id)->with('success', 'Sua análise foi registrada com sucesso!');

        } catch (Exception $e) {
            return $e->getTrace();
        }
    }


    public function newNotification($id)
    {
        $u = User::find($id);
        $analise = Analysis::find(4);
        $u->notify(new NewAssignment($u, $analise));
        return $u;

    }
}
