<?php

namespace App\Http\Controllers;


use Goutte\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Datascraping;
use Validator;
use App\Http\Resources\Datascraping as WebResource;




class ScraperController extends BaseController
{
    private $datawebscraping = [];

    public function get_data() {
        $client = new Client();

        $crawler = $client->request('GET', 'https://pe.jobrapido.com/Ofertas-de-trabajo-en-Arequipa?r=auto&shm=all&ae=60');


        //dd($url);
       // https://pe.jobrapido.com/Ofertas-de-trabajo-en-Arequipa?r=auto&p=2&shm=all&ae=60


        $crawler->filter('div.result-item')->each(function ($node) {
         //dump($node->text());
        });
       // dd($crawler);

        for ($i = 2; $i <= 10; $i++) {
            $url = 'https://pe.jobrapido.com/Ofertas-de-trabajo-en-Arequipa?r=auto'.$i.'&shm=all&ae=60';

            $crawler = $client->request('GET', $url);
            $crawler->filter('div.result-item')->each(function ($node) {
                array_push($this->datawebscraping, $node->text());
               });
        }



        $result = $this->store_void();

        return response($result, 200);
        
    }

    private function returnResult() {
        $output = [];
        for ($i = 0; $i <= 9; $i++) {
            $output['description'] = $this->datawebscraping[0];
        }

        return $output;
    }

    public function index()
    {
        $datascrapings = Datascraping::all();

        return $this->sendResponse(WebResource::collection($datascrapings), 'Data Webs retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   /* public function store(Request $request)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'description' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $datascraping = Datascraping::create($input);

        return $this->sendResponse(new WebResource($datascraping), 'Web created successfully.');
    }*/



    public function store_void()
    {
        for ($i = 0; $i <= 30; $i++) {
            $output['description'] = $this->datawebscraping[$i];

            $validator = Validator::make($output, [
                'description' => 'required'

            ]);

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }

            $datascraping = Datascraping::create($output);
        }
        return $this->sendResponse(new WebResource($datascraping), 'Web created successfully.');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datascraping = Datascraping::find($id);

        if (is_null($datascraping)) {
            return $this->sendError('Web not found.');
        }

        return $this->sendResponse(new WebResource($datascraping), 'Web retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Datascraping $datascraping)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'description' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $datascraping->description = $input['description'];

        $datascraping->save();

        return $this->sendResponse(new WebResource($datascraping), 'Web updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Datascraping $datascraping)
    {
        $datascraping->delete();

        return $this->sendResponse([], 'Web deleted successfully.');
    }
}
