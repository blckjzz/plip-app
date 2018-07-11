<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Petition;

class TrelloController extends Controller
{
    protected $trelloBoard;
    protected $trelloListId;
    protected $card;
    protected $trelloClient;
    protected $cardOClient;

    public function __construct()
    {
        $this->trelloClient = new \Trello\Client(env('TRELLO_KEY'));
        $this->trelloClient->setAccessToken(env('TRELLO_TOKEN'));
        $this->board = new \Trello\Model\Board($this->trelloClient);
        $this->board->setId(env('TRELLO_BOARD_ID'));
        $this->trelloListId = env('TRELLO_LIST_ID');
        $this->card = new \Trello\Model\Card($this->trelloClient);
        $this->card->idList = $this->trelloListId;

    }

    public function getTrelloBoardInfos()
    {
        try {
            $http = new Client();
            $uri = env('TRELLO_BOARD_URL') . '' . env('TRELLO_BOARD_ID') . '?key=' . env('TRELLO_KEY') . '&token=' . env('TRELLO_TOKEN');
            $response = $http->request('GET', $uri);
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Create a card on trello board
     * @return string
     */
    public function createTrelloCard($petition)
    {

        try {
            // Card Creation
            $this->card->name = $petition->name;
            $this->card->desc = $petition->text;
            $this->card->pos = 'TOP';
            $this->card->due = $petition->submitDate;
            // para implementar assim que adicionar modulo de asign para voluntarios
            // $this->card->idMembers =
            $this->card->save();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
