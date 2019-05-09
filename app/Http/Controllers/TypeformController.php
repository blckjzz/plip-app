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
        $this->token = env("TYPEFORM_TOKEN");
        $this->baseUri = "https://api.typeform.com/forms/".$this->formId."/responses";
        $this->until = '';
    }

    public function getTypeformAnswers($since, $until = '')
    {
        try {

            $since = Carbon::parse($since)->toIso8601ZuluString();

//            $until = Carbon::parse($until)->toIso8601ZuluString();

            $headers = [
                'Authorization' => 'Bearer ' . $this->token,
                'Accept'        => 'application/json',
            ];

            $client = new Client();

            $uri = $this->baseUri.'?since='.$since.'&page_size=1000&completed';

            $response = $client->request('GET', $uri, [
                'headers' => $headers
            ]);

            echo 'API call: '. $uri.''.PHP_EOL;

            if ($response->getStatusCode() != 200) {
                return abort(404, 'Indisponível');
            }

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
