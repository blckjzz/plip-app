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


class PetitionController extends Controller
{
    private $typeformController;

    public function __construct()
    {
        $this->middleware(['auth','isAdmin']);
        $this->typeformController = new TypeformController();
    }

    public function index()
    {
        $petitions = Petition::all();
        return view('petition.petition', ['petitions' => $petitions]);
    }

    public function syncPlips()
    {
        $latestSyncDate = DB::table('logs')->where('motive', '=', 'PLIP_SYNC')->select('sync_date')->latest('sync_date')->get();
        try {

            $response = $this->typeformController->getTypeformAnswers($latestSyncDate[0]->sync_date);
            $log = $this->store($response);
            return response()->json($log);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public
    function store($petitionJsonList)
    {
        try {
            $log = new Log;
            $log->quantity = 0;

            if (isset($petitionJsonList['responses'])) {
                if (count($petitionJsonList['responses']) > 0) {
                    echo 'Processing PLIP SYNC..';
                    foreach ($petitionJsonList['responses'] as $key => $value) {
                        $plip = new Petition;
                        /**
                         *  "id" => "textfield_AkbyrKsQvlVJ"
                         * "question" => "Qual o nome do seu projeto de lei?"
                         *
                         **/
                        if (isset($value['answers']['textfield_AkbyrKsQvlVJ'])) {
                            $plip->name = $value['answers']['textfield_AkbyrKsQvlVJ'];
                            if ($plip->name == '') {
                                $plip->name = 'PETIÇÃO SEM NOME ';
                            }
                        }
                        /**
                         *  "id" => "textarea_bFx24eWPri6j"
                         * "question" => "Insira aqui o texto do projeto de lei."
                         **/
                        if (isset($value['answers']['textarea_bFx24eWPri6j'])) {
                            $plip->text = $value['answers']['textarea_bFx24eWPri6j'];
                        }
                        /**    "id" => "list_yd0ahtxZTFUs_choice"
                         * "question" => "À qual esfera o projeto de lei se destina?"
                         **/

                        if (isset($value['answers']['list_yd0ahtxZTFUs_choice'])) {
                            $plip->wide = $value['answers']['list_yd0ahtxZTFUs_choice'];
                        }

                        /**
                         * "id" => "dropdown_GtpM2IMm1BDM"
                         * "question" => "Estado:"
                         **/
                        if (isset($value['answers']['dropdown_GtpM2IMm1BDM'])) {
                            $plip->state = $value['answers']['dropdown_GtpM2IMm1BDM'];
                        }

                        /**
                         * "id" => "textfield_WNCltuKyCogK"
                         * "question" => "Município:"
                         **/

                        if (isset($value['answers']['textfield_WNCltuKyCogK'])) {

                            $plip->municipality = $value['answers']['textfield_WNCltuKyCogK'];

                        }

                        /**  "id" => "website_qai1yFnkufjh"
                         * "question" => "Envie um vídeo de até um minuto explicando sua proposta."
                         **/

                        if (isset($value['answers']['website_qai1yFnkufjh'])) {
                            $plip->video_url = $value['answers']['website_qai1yFnkufjh'];
                        }

                        /**
                         * "id" => "yesno_52264641"
                         * "question" => "Conhece algum projeto similar que já tenha sido aprovado (mesmo que em outra esfera)?"
                         * */

                        if (isset($value['answers']['yesno_52264641'])) {
                            $plip->references = $value['answers']['yesno_52264641'];
                        }

                        /**
                         * "id" => "textfield_52264909"
                         * "question" => "Descreva o projeto aqui e envie links sobre o mesmo."
                         * */

                        if (isset($value['answers']['textfield_52264909'])) {
                            $plip->links = $value['answers']['textfield_52264909'];
                        }

                        /** "id" => "textfield_52268594"
                         * "question" => "Nome:"
                         **/

                        if (isset($value['answers']['textfield_52268594'])) {
                            $plip->sender_name = $value['answers']['textfield_52268594'];
                        }

                        /** "id" => "email_52268630"
                         * "question" => "Email:"
                         **/
                        if (isset($value['answers']['email_52268630'])) {
                            $plip->sender_mail = $value['answers']['email_52268630'];
                        }

                        /**
                         * "id" => "textfield_DcjgsmwtRf0w"
                         * "question" => "Telefone:"
                         **/

                        if (isset($value['answers']['textfield_DcjgsmwtRf0w'])) {
                            $plip->sender_telephone = $value['answers']['textfield_DcjgsmwtRf0w'];
                        }

                        if (isset($value['metadata']['date_submit'])) {
                            $plip->submitDate = $value['metadata']['date_submit'];
                        }

                        //status_id = 1 means novo
                        $plip->status_id = 1;
                        $plip->saveOrFail();
                        $log->quantity++;
                        echo 'Saving [' . $plip->name . '] project to database.\n';

                    }
                }
            } else {
                return response(['message' => 'There is no plip to be synced'], 204)
                    ->header('Content-Type', 'application/json');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return response(['message' => 'Something went wrong, check the message', 'exceptions' => $e->getMessage()], 500)
                ->header('Content-Type', 'application/json');
        } finally {
            // Log the event everytime that plips are synced
            $log->motive = 'PLIP_SYNC';
            $log->sync_date = Carbon::now('America/Sao_Paulo');
            $log->saveOrFail();
            # Debug on console
            echo 'Total of: [' . $log->quantity . '] project were synced';
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


    public function edit($id)
    {
        $status = Status::all();
        return view('petition.edit', ['petition' => Petition::findOrFail($id), 'status' => $status]);
    }

    public function save(Request $request)
    {
        $petitionID = $request->only('id');

        Petition::where('id', $petitionID)->update($request->except(['_token', 'id']));

        return redirect()->back()->with(['message' => "Alteração feita com sucesso!"]);

    }

    public function showNewPetitions()
    {
        $petitions = Petition::all()->where('created_at', '>=', Carbon::today());
        return view('petition.petition', ['petitions' => $petitions]);
    }

    public function showPetitionsInAnalysis()
    {
        $petitions = Petition::all()->where('status_id', '=', '2');
        return view('petition.petition', ['petitions' => $petitions]);
    }

    public function assign()
    {
        // list petitions
        // add status equals novo # 1
        $petitions = Petition::all()->where('status_id', '=', '1')->where('volunteer_id', '=', '');

        // list volunteers
        $volunteers = Volunteer::all();
        // list status
        $status = Status::all();
        // create another function where save the data and stores into the database
        return view('petition.assign', ['petitions' => $petitions, 'volunteers' => $volunteers, 'status' => $status]);

    }

    public function saveAssign(Request $request)
    {
        try {

            $analysis = new Analysis();
            // find petition
            $petition = Petition::findOrFail($request->input('project_id'));
            $petition->status_id = $request->input('status');
            //find volunteer
            $volunteer = Volunteer::findOrFail($request->input('volunteer_id'));
            if($petition->save()){
                $analysis->volunteer_id = $volunteer->id;
                $analysis->petition_id = $petition->id;
                $analysis->save();
            }
            // save send a mail to volunteer with new task added
            dd($analysis);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return redirect()->action('PetitionController@showPetitionsInAnalysis');
    }
}
