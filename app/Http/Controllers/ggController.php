<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Cache;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class HomeController extends Controller
{

    private $client;

    public function __construct(){

        $ts = time();
        $hash = md5($ts . config('marvel.private_key') . config('marvel.public_key'));

        $this->client = new Client([
            'base_uri' => 'http://gateway.marvel.com/v1/public/',
            'query' => [
                'apikey' => config('marvel.public_key'),
                'ts' => $ts,
                'hash' => $hash
            ]
        ]);
        
    }


    public function comics(Request $request){

        $search_term = '';
        if($request->has('query')){
            
            $search_term = $request->input('query');

            $query = $this->client->getConfig('query');
            $query['titleStartsWith'] = $search_term;

            $response = $this->client->get('comics', ['query' => $query]);
            $response = json_decode($response->getBody(), true);
            
            $comics = $response['data']['results'];
            
        }else{
            $comics = Cache::get('comics');
            $comics = array_slice($comics, 0, 10);
        }
        
        
        return view('comics', ['comics' => $comics, 'query' => $search_term]);

    }


    public function comic($id){

        $page_data = [];

        $response = $this->client->get('comics/' . $id);
        $response = json_decode($response->getBody(), true);

        $comic = $response['data']['results'][0];
        $page_data['comic'] = $comic;

        if(!empty($comic['series'])){

            $series_response = $this->client->get($comic['series']['resourceURI']);
            $series_response = json_decode($series_response->getBody(), true);

            $page_data['series'] = $series_response['data']['results'][0];
        }
        

        return view('comic', $page_data);
    }


    public function characters(Request $request){

        $search_term = '';
        if($request->has('query')){
            
            $search_term = $request->input('query');

            $query = $this->client->getConfig('query');
            $query['nameStartsWith'] = $search_term;

            $response = $this->client->get('characters', ['query' => $query]);
            $response = json_decode($response->getBody(), true);
            
            $characters = $response['data']['results'];
            
        }else{
            $characters = Cache::get('characters');   
        }
        
        
        $current_page = LengthAwarePaginator::resolveCurrentPage();

        if(is_null($current_page)){
            $current_page = 1;
        }

        $characters_collection = new Collection($characters);

        $items_per_page = 8;

        $current_page_results = $characters_collection->slice(($current_page - 1) * $items_per_page, $items_per_page)->all();
        $paginated_results = new LengthAwarePaginator($current_page_results, count($characters_collection), $items_per_page);

        return view('characters', ['paginated_results' => $paginated_results, 'characters' => $characters, 'query' => $search_term]);

    }

    
}
