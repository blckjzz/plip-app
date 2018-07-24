<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;

class TypeformController extends Controller
{
    private $formId;
    private $key;
    private $baseUri;
    private $since;
    private $until;

    public function __construct()
    {
        $this->middleware(['auth','isAdmin']);
        $this->formId = env("TYPEFORM_FORM_ID");
        $this->key = env("TYPEFORM_KEY");
        $this->baseUri = "https://api.typeform.com/v1/form/$this->formId?key=$this->key";
    }

    public function getTypeformAnswers($since, $until = '')
    {
        try {

            $this->since = Carbon::createFromFormat('Y-m-d H:i:s', $since, 'America/Sao_Paulo')->timestamp;

            if (isset($until) || $until == '') {
                $until = Carbon::now('America/Sao_Paulo');
            }

            $this->until = Carbon::createFromFormat('Y-m-d H:i:s', $until)->timestamp;
            $client = new Client();
            $uri = $this->baseUri . '&since=' . $this->since . '&until=' . $this->until;
            $result = $client->request('GET', $uri);

            if ($result->getStatusCode() != 200) {
                abort(404, 'Indisponível');
                return false;
            }
            return json_decode($result->getBody(), true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
