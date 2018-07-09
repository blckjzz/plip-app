<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Petition;


class PetitionController extends Controller
{
    private $typeformController;
    private $petitionJsonList;
    private $plip;

    public function __construct()
    {
        $this->typeformController = new TypeformController();
        $this->plip = new Petition();
    }


    public function index()
    {
        $todayDate = Carbon::now()->toDateTimeString();
        //GET DATE FROM DATABASE AND PARSE TO METHOD
        $this->petitionJsonList = $this->typeformController->getTypeformAnswers('2018/07/01');
        $this->transformJsonToObjects();
        dd($this->petitionJsonList);
    }

    public function transformJsonToObjects()
    {
        foreach ($this->petitionJsonList['responses'] as $petition => $value) {

            /**
             *  "id" => "textfield_AkbyrKsQvlVJ"
             * "question" => "Qual o nome do seu projeto de lei?"
             *
             **/
            if (isset($value['answers']['textfield_WNCltuKyCogK'])) {

                $this->plip->name = $value['answers']['textfield_AkbyrKsQvlVJ'];
            }
            /**
             *  "id" => "textarea_bFx24eWPri6j"
             * "question" => "Insira aqui o texto do projeto de lei."
             **/
            if (isset($value['answers']['textfield_WNCltuKyCogK'])) {

                $this->plip->text = $value['answers']['textarea_bFx24eWPri6j'];
            }
            /**    "id" => "list_yd0ahtxZTFUs_choice"
             * "question" => "À qual esfera o projeto de lei se destina?"
             **/

            if (isset($value['answers']['textfield_WNCltuKyCogK'])) {
                $this->plip->text = $value['answers']['textarea_bFx24eWPri6j'];
            }
            /**
             * "id" => "dropdown_GtpM2IMm1BDM"
             * "question" => "Estado:"
             **/
            if (isset($value['answers']['dropdown_GtpM2IMm1BDM'])) {
                $this->plip->state = $value['answers']['dropdown_GtpM2IMm1BDM'];
            }

            /**
             * "id" => "textfield_WNCltuKyCogK"
             * "question" => "Município:"
             **/

            if (isset($value['answers']['textfield_WNCltuKyCogK'])) {

                $this->plip->municipality = $value['answers']['textfield_WNCltuKyCogK'];

            }

            /**  "id" => "website_qai1yFnkufjh"
             * "question" => "Envie um vídeo de até um minuto explicando sua proposta."
             **/

            if (isset($value['answers']['website_qai1yFnkufjh'])) {
                $this->plip->video_url = $value['answers']['website_qai1yFnkufjh'];
            }

            /**
             * "id" => "yesno_52264641"
             * "question" => "Conhece algum projeto similar que já tenha sido aprovado (mesmo que em outra esfera)?"
             * */

            if (isset($value['answers']['yesno_52264641'])) {
                $this->plip->references = $value['answers']['yesno_52264641'];
            }

            /**
             * "id" => "textfield_52264909"
             * "question" => "Descreva o projeto aqui e envie links sobre o mesmo."
             * */

            if (isset($value['answers']['textfield_52264909'])) {
                $this->plip->links = $value['answers']['textfield_52264909'];
            }

            /** "id" => "textfield_52268594"
             * "question" => "Nome:"
             **/

            if (isset($value['answers']['textfield_52264909'])) {
                $this->plip->sender_name = $value['answers']['textfield_52264909'];
            }

            /** "id" => "email_52268630"
             * "question" => "Email:"
             **/
            if (isset($value['answers']['email_52268630'])) {
                $this->plip->sender_mail = $value['answers']['email_52268630'];
            }

            /**
             * "id" => "textfield_DcjgsmwtRf0w"
             * "question" => "Telefone:"
             **/

            if (isset($value['answers']['email_52268630'])) {
                $this->plip->sender_telephone = $value['answers']['email_52268630'];
            }

            

            #dd($this->plip);
            $this->plip->save();

        }
    }


}
