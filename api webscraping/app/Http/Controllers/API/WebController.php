<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Web;
use Validator;
use App\Http\Resources\Web as WebResource;

class WebController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $webs = Web::all();

        return $this->sendResponse(WebResource::collection($webs), 'Webs retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'name' => 'required',
            'URL' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $web = Web::create($input);

        return $this->sendResponse(new WebResource($web), 'Web created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $web = Web::find($id);

        if (is_null($web)) {
            return $this->sendError('Web not found.');
        }

        return $this->sendResponse(new WebResource($web), 'Web retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Web $web)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'URL' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $web->name = $input['name'];
        $web->URL = $input['URL'];
        $web->save();

        return $this->sendResponse(new WebResource($web), 'Web updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Web $web)
    {
        $web->delete();

        return $this->sendResponse([], 'Web deleted successfully.');
    }
}
