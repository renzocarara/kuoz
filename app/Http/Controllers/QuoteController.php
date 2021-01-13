<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//
use App\Models\Quote;

class QuoteController extends Controller
{
    
    /**
     * Build response to be returned
     *
     * @return \Illuminate\Http\Response
     */

    private function buildResponse($data, $statusCode)
    {
        return response()->json($data, $statusCode)
                         ->header('Content-Type', 'application/json');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // read all quotes in DB
        // return Quote::orderBy('created_at', 'DESC')->get();
        return Quote::orderBy('created_at', 'DESC')->paginate(5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $newQuote = new Quote;
        $rxedData = $request->all();
        // these 2 lines can be written in one line using fill() method
        // $newQuote->author = $rxedData["author"];
        // $newQuote->text = $rxedData["text"];
        $newQuote->fill($rxedData);

        $is_saved = $newQuote->save();

        if ($is_saved) {
            // new record in db successfully added
            $data = $rxedData;
            $statusCode = 201;
        } else {
            // something went wrong, creation of new record has failed
            $data = 'No data saved in DB!';
            $statusCode = 500;
        }
        
        return $this->buildResponse($data, $statusCode);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $toBeUpdated = Quote::find($id); // get the id of the quote to be updated
        if ($toBeUpdated) { // if id exists
            $rxedData = $request->all(); // get the data received
            $isUpdated = $toBeUpdated->update($rxedData); // update DB and get the result
        
            if ($isUpdated) { // update succeded

                $data = $rxedData;
                $statusCode = 200;
            } else {  // update failed

                $data = 'Update failed';
                $statusCode = 500;
            }
        } else {
            $data = 'No record with id: ' . $id . ' found';
            $statusCode = 404;
        }

        return $this->BuildResponse($data, $statusCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $toBeDeleted = Quote::find($id); // get the id of the quote to be deleted
        if ($toBeDeleted) { // if id exists
            $isDeleted = $toBeDeleted->delete(); // update DB and get the result
        
            if ($isDeleted) { // delete succeded

                $data = [];
                $statusCode = 200;
            } else {  // delete failed

                $data = 'Delete failed';
                $statusCode = 500;
            }
        } else {
            $data = 'No record with id: ' . $id . ' found';
            $statusCode = 404;
        }

        return $this->BuildResponse($data, $statusCode);
    }
}
