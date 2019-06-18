<?php

namespace App\Http\Controllers;

use App\Analysis;
use App\Log;
use App\Notifications\NewAssignment;
use App\Volunteer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Petition;
use App\Status;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\NewAssigmentRequest;


class PetitionController extends Controller
{
    private $typeformController;
    private $petition;

    public function __construct()
    {
        $this->typeformController = new TypeformController();

    }

    public function index()
    {
        $petitions = Petition::all();
        return view('petition.petition', ['petitions' => $petitions, 'title' => 'Lista de Petições']);
    }

    public function syncPlips()
    {
        $latestSyncDate = DB::table('logs')->where('motive', '=', 'PLIP_SYNC')
            ->select('sync_date')
            ->latest('sync_date')->get();
        try {

//            echo $latestSyncDate;
            $response = $this->typeformController->getTypeformAnswers($latestSyncDate[0]->sync_date);
//            $response = $this->typeformController->getTypeformAnswers('2019-03-01 00:00:00');
            $this->store($response);
            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public
    function store($responses)
    {
        try {
            $log = new Log;
            $log->quantity = 0;

            echo PHP_EOL . 'Total de respostas:' . count($responses['items']) . PHP_EOL;
            $qtd = 0;
            if (is_array($responses['items']) && count($responses['items']) > 0) {
                foreach ($responses['items'] as $form) {
                    if (!array_key_exists('answers', $form)) {
                        next($form);
                    } else {
                        print('------- inicio pl ----' . PHP_EOL);
                        $plip = new Petition();
                        $plip->submitDate = Carbon::parse($form['submitted_at']);
                        $plip->token = $form['token'];
                        foreach ($form['answers'] as $answer) { // aqui tenho no answer um array de arrays, onde cada array é uma resposta do formulário
                            $this->fillPetitionObject($answer, $plip);  // cada answer é uma resposta de um formulário
                        }
                        $qtd++;
                        print('Petition number: [' . $qtd . '] ' . PHP_EOL);
                        /**
                         * status 1 means under review of a volunteer
                         */
                        $plip->status_id = 1;
                        $plip->save();
                        $log->quantity++;
                        echo 'Saving [' . $plip->name . '] project to database' . PHP_EOL;
                    }

                }
            } else {
                return response(['message' => 'There is no plip to be synced'], 204)
                    ->header('Content-Type', 'application/json');
            }
        } catch
        (\Exception $e) {
            print_r($e->getMessage());
            return response(['message' => 'Something went wrong, check the message', 'exceptions' => $e->getMessage()], 500)
                ->header('Content-Type', 'application/json');
        } finally {
            // Log the event everytime that plips are synced
            $log->motive = 'PLIP_SYNC';
            $log->sync_date = Carbon::now('America/Sao_Paulo');
            $log->saveOrFail();
            # Debug on console
            echo 'Total of: [' . $log->quantity . '] project were synced' . PHP_EOL;
        }
        return response(['message' => 'There is no plip to be synced', 'log' => $log], 200)
            ->header('Content-Type', 'application/json');
    }

    public
    function showPetition($id)
    {

        return view('petition.show',
            [
                'petition' => Petition::findOrFail($id),

            ]
        );
    }


    public
    function edit($id)
    {
        $status = Status::all();
        return view('petition.edit', ['petition' => Petition::findOrFail($id), 'status' => $status]);
    }

    public
    function save(Request $request)
    {
        $petitionID = $request->only('id');

        Petition::where('id', $petitionID)->update($request->except(['_token', 'id']));

        return redirect()->back()->with(['message' => "Alteração feita com sucesso!"]);

    }

    public
    function showNewPetitions()
    {
        $petitions = Petition::all()->where('submitDate', '>=', Carbon::today()->subDays(7));
        return view('petition.petition', ['petitions' => $petitions]);
    }

    public
    function showPetitionsInAnalysis()
    {
        $petitions = Petition::all()->where('status_id', '=', 2);
        return view('petition.petition', ['petitions' => $petitions]);
    }

    public
    function showApprovedPetitions()
    {
        $petitions = Petition::all()->where('status_id', '=', 5);
        return view('petition.petition', ['petitions' => $petitions, 'title' => 'Petições Aprovadas']);
    }

    public
    function assign()
    {
        // list petitions
        // add status equals novo # 1
        $petitions = Petition::all()->where('status_id', '=', '1');

        // list volunteers
        $volunteers = Volunteer::all();
        // create another function where save the data and stores into the database
        return view('petition.create-assignment', ['petitions' => $petitions, 'volunteers' => $volunteers]);

    }

    public
    function saveAssign(NewAssigmentRequest $request)
    {
        $volunteer = DB::transaction(function () use ($request) {
            $analysis = new Analysis();
            // find petition
            $petition = Petition::find($request->input('project_id'));
            // always with status two = analise
            $petition->status_id = 2;
            //find volunteer
            $volunteer = Volunteer::find($request->input('volunteer_id'));


            $petition->save();
            $analysis->volunteer_id = $volunteer->id;
            $analysis->petition_id = $petition->id;
            $analysis->save();

            // save send a mail to volunteer with new task added

            $this->newAssignmentNotification($volunteer, $analysis);

            return $volunteer;

        });

        return redirect()->action('PetitionController@assign')->with('success', 'Tarefa adicionada! ' . $volunteer->user->name . ' receberá um e-mail de notificação em breve!');
    }


    public function newAssignmentNotification(Volunteer $volunteer, Analysis $analise)
    {
        $volunteer->user->notify(new NewAssignment($volunteer, $analise));
    }

    /**
     * @param $answer
     * @param Petition $plip
     */
    public function fillPetitionObject($answer, Petition $plip): void
    {

        if ($answer['field']['id'] === 'AkbyrKsQvlVJ') {
            print("Projeto de LEI:" . $answer['text']) . PHP_EOL;
            $plip->name = $answer['text'];
        }

        //                        // Texto do projeto
        if ($answer['field']['id'] == 'bFx24eWPri6j') {
            print("Texto do Projeto: " . $answer['text'] . PHP_EOL);
            $plip->text = $answer['text'];
        }

        // é nacional? //true or false (0/1)
        if ($answer['field']['id'] == 'yd0ahtxZTFUs') {
            print("Abrangencia: " . $answer['choice']['label'] . PHP_EOL);
            $plip->wide = $answer['choice']['label'];

        }

        if ($answer['field']['id'] == 'WNCltuKyCogK') {
            print("É Municipio? " . $answer['text'] . PHP_EOL);
            $plip->municipality = $answer['text'];
        }

        // se for nacional ou municipal, campo vazio.
        if ($answer['field']['id'] == 'GtpM2IMm1BDM') {
            print("Estado? " . $answer['text'] . PHP_EOL);
            $plip->state = $answer['text'];
        }


        if ($answer['field']['id'] == 'qai1yFnkufjh') {
            print("video: " . $answer['url'] . PHP_EOL);
            $plip->video_url = $answer['url'];
        }

        if ($answer['field']['id'] == '52264641') {
            print("referencias: " . $answer['boolean'] . PHP_EOL);
            $plip->references = $answer['boolean'];
        }


        if ($answer['field']['id'] == '52268594') {
            print("Proponente: " . $answer['text'] . PHP_EOL);
            $plip->sender_name = $answer['text'];
        }

        if ($answer['field']['id'] == '52268630') {
            print("Email proponente: " . $answer['email'] . PHP_EOL);
            $plip->sender_mail = $answer['email'];
        }

        if ($answer['field']['id'] == 'DcjgsmwtRf0w') {
            print("Telefone proponente: " . $answer['text'] . PHP_EOL);
            $plip->sender_telephone = $answer['text'];
        }
    }
}
