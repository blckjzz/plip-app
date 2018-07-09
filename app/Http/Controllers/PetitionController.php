<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Petition;


class PetitionController extends Controller
{
    private $typeformController;

    public function __construct()
    {
        $this->typeformController = new TypeformController();
    }

    public function index()
    {
        $petitions = Petition::simplePaginate(15);
        return view('petition.petition', ['petitions' => $petitions]);
    }
    public function syncPlips()
    {
        $todayDate = Carbon::now()->toDateTimeString();
        //GET DATE FROM DATABASE AND PARSE TO METHOD
        try {
            $response = $this->typeformController->getTypeformAnswers('2018/03/01');
            $this->transformJsonToObjects($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public
    function transformJsonToObjects($petitionJsonList)
    {
        foreach ($petitionJsonList['responses'] as $key => $value) {
            $plip = new Petition;
            //echo $value['answers']['email_52268630'];
            //echo '</br>';
            //echo $value['answers']['textfield_AkbyrKsQvlVJ'];
            //echo '</br>';
            //echo $value['answers']['textarea_bFx24eWPri6j'];
            /**
             *  "id" => "textfield_AkbyrKsQvlVJ"
             * "question" => "Qual o nome do seu projeto de lei?"
             *
             **/
            if (isset($value['answers']['textfield_AkbyrKsQvlVJ'])) {
                $plip->name = $value['answers']['textfield_AkbyrKsQvlVJ'];
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
            $plip->save();
        }
        $log = new Log;
        $log->quantity;
    }


}
