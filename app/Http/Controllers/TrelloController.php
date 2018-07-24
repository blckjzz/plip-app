<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Petition;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TrelloController extends Controller
{
    protected $trelloBoard;
    protected $trelloListId;
    protected $card;
    protected $trelloClient;
    protected $cardOClient;

    public function __construct()
    {

        $this->middleware(['auth','isAdmin']);
        $this->trelloClient = new \Trello\Client(env('TRELLO_KEY'));
        $this->trelloClient->setAccessToken(env('TRELLO_TOKEN'));
        $this->board = new \Trello\Model\Board($this->trelloClient);
        $this->board->setId(env('TRELLO_BOARD_ID'));
        $this->trelloListId = env('TRELLO_LIST_ID');
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
            $card = new \Trello\Model\Card($this->trelloClient);
            $card->name = $petition->name;
            $card->desc = $petition->text;
            $card->pos = 'top';
            $card->due = $petition->submitDate->format('d/m/Y');
            $card->idList = $this->trelloListId;

            // para implementar assim que adicionar modulo de asign para voluntarios
            // $this->card->idMembers =
            $card->save();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function pushPlipToTrello()
    {
        $log = new Log();
        $log->quantity = 0;

        try {
            $latestSyncDate = DB::table('logs')->where('motive', '=', 'PLIP_SYNC')->select('sync_date', 'quantity')->latest('sync_date')->get();

            $petitions = Petition::where('created_at', '>=', $latestSyncDate[0]->sync_date)->get();

            echo 'Ultima sincronização de petições:' . $latestSyncDate[0]->sync_date;

            if ($petitions->count() > 0) {
                foreach ($petitions as $petition) {
                    echo $petition->name . '- with id: [' . $petition->id . '] were synced.';
                    $this->createTrelloCard($petition);
                    $log->quantity++;
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
            $log->motive = 'TRELLO_SYNC';
            $log->sync_date = Carbon::now();
            $log->saveOrFail();
            # Debug on console
            echo 'Total of: [' . $log->quantity . '] cards were pushed';
        }
        return response(['message' => 'There is no project to be synced', 'log' => $log], 200)
            ->header('Content-Type', 'application/json');


    }
}
