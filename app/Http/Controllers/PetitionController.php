<?php

namespace App\Http\Controllers;

use App\Analysis;
use App\Log;
use App\Volunteer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Petition;
use App\Status;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use function PHPSTORM_META\type;


class PetitionController extends Controller
{
    private $typeformController;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['isAdmin'])->except('showPetition');
        $this->typeformController = new TypeformController();
    }

    public function index()
    {
        $petitions = Petition::all();
        return view('petition.petition', ['petitions' => $petitions]);
    }

    public function syncPlips()
    {
        $latestSyncDate = DB::table('logs')->where('motive', '=', 'PLIP_SYNC')
            ->select('sync_date')
            ->latest('sync_date')->get();
        try {

//            echo $latestSyncDate;
//            $response = $this->typeformController->getTypeformAnswers($latestSyncDate[0]->sync_date);
            $response = $this->typeformController->getTypeformAnswers('2018-03-01 00:00:00');
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
            if (count($responses['items']) > 0) {
                foreach ($responses['items'] as $array) {
                    $plip = new Petition();
                    (isset($array['submitted_at'])) ? var_dump(str_limit($array['submitted_at'], 50)) : '';
                    (isset($array['response_id'])) ? var_dump(str_limit($array['response_id'], 50)) : '';
                    if (!array_key_exists('answers', $array)) {
                        next($array);
                    } else {
                        print('------- inicio pl ----' . PHP_EOL);
                        foreach ($array['answers'] as $answer) { // aqui tenho no answer um array de arrays, onde cada array é uma resposta do formulário
//                        print_r($answer);
                            $plip->submitDate = $array['submitted_at'];
                            $rep = array_merge($answer, $answer['field']);

                            if ($rep['id'] === 'AkbyrKsQvlVJ') {
                                print("Projeto de LEI:" . $rep['text']) . PHP_EOL;
                                if (empty($rep['text'])) {
                                    $plip->name = 'PROJETO DE LEI SEM NOME';
                                    print("Projeto de LEI:" . $plip->name) . PHP_EOL;
                                } else {
                                    print("Projeto de LEI:" . $rep['text']) . PHP_EOL;
                                    $plip->name = $rep['text'];
                                }

                            }

//                        // Texto do projeto
                            if ($rep['id'] == 'bFx24eWPri6j') {
                                print("Texto do Projeto: " . $rep['text'] . PHP_EOL);
                                $plip->text = $rep['text'];
                            }

                            // é nacional?
                            if ($rep['id'] == 'yd0ahtxZTFUs') {
                                print("Abrangencia: " . $rep['choice']['label'] . PHP_EOL);
                                $plip->wide = $rep['choice']['label'];

                            }

                            if ($rep['id'] == 'WNCltuKyCogK') {
                                print("É nacional? " . $rep['text'] . PHP_EOL);
                                $plip->municipality = $rep['text'];
                            }


                            if ($rep['id'] == 'GtpM2IMm1BDM') {
                                print("Estado? " . $rep['text'] . PHP_EOL);
                                $plip->state = $rep['text'];
                            }


                            if ($rep['id'] == 'qai1yFnkufjh') {
                                print("video: " . $rep['url'] . PHP_EOL);
                                $plip->video_url = $rep['url'];
                            }

                            if ($rep['id'] == '52264641') {
                                print("referencias: " . $rep['boolean'] . PHP_EOL);
                                $plip->references = $rep['boolean'];
                            }


                            if ($rep['id'] == '52268594') {
                                print("Proponente: " . $rep['text'] . PHP_EOL);
                                $plip->sender_name = $rep['text'];
                            }

                            if ($rep['id'] == '52268630') {
                                print("Email proponente: " . $rep['email'] . PHP_EOL);
                                $plip->sender_mail = $rep['email'];
                            }

                            if ($rep['id'] == 'DcjgsmwtRf0w') {
                                print("Telefone proponente: " . $rep['text'] . PHP_EOL);
                                $plip->sender_telephone = $rep['text'];
                            }

                            print('------- campo ----' . PHP_EOL);


                        }
                        $qtd++;
                        print('PL nro' . $qtd . PHP_EOL);
                        print('-------PLIP fim ----' . PHP_EOL);
                        //status_id = 1 means novo
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
            echo $e->getMessage();
            return response(['message' => 'Something went wrong, check the message', 'exceptions' => $e->getMessage()], 500)
                ->header('Content-Type', 'application/json');
        }

//        finally {
//            // Log the event everytime that plips are synced
//            $log->motive = 'PLIP_SYNC';
//            $log->sync_date = Carbon::now('America/Sao_Paulo');
//            $log->saveOrFail();
//            # Debug on console
//            echo 'Total of: [' . $log->quantity . '] project were synced';
//        }
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
        $petitions = Petition::all()->where('created_at', '>=', Carbon::today());
        return view('petition.petition', ['petitions' => $petitions]);
    }

    public
    function showPetitionsInAnalysis()
    {
        $petitions = Petition::all()->where('status_id', '=', 2);
        return view('petition.petition', ['petitions' => $petitions]);
    }

    public
    function assign()
    {
        // list petitions
        // add status equals novo # 1
        $petitions = Petition::all()->where('status_id', '=', '1');

        // list volunteers
        $volunteers = Volunteer::all();
        // list status
        $status = Status::all();
        // create another function where save the data and stores into the database
        return view('petition.create-assignment', ['petitions' => $petitions, 'volunteers' => $volunteers, 'status' => $status]);

    }

    public
    function saveAssign(Request $request)
    {
        try {

            $analysis = new Analysis();
            // find petition
            $petition = Petition::findOrFail($request->input('project_id'));
            // always with status two = analise
            $petition->status_id = 2;
            //find volunteer
            $volunteer = Volunteer::findOrFail($request->input('volunteer_id'));

            if ($petition->save()) {
                $analysis->volunteer_id = $volunteer->id;
                $analysis->petition_id = $petition->id;
                $analysis->save();
            }
            // save send a mail to volunteer with new task added

        } catch (Exception $e) {
            return $e->getMessage();
        }
        return redirect()->action('PetitionController@showPetitionsInAnalysis');
    }
}
