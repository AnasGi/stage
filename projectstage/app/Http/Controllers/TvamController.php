<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Tvam;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TvamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $code = Client::where('code' , $request->input('code'))->value('id');

        if($code){
            $tvamData = Tvam::where('clients_id' , $code)->get();
        }
        else{
            $tvamData = Tvam::all();
        }
        return view('tvam' , compact('tvamData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tvam $tvam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tvam $tvam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tvam $tvam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tvam $tvam)
    {
        //
    }

    public function import(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        
        // Open and read the file
        $handle = fopen($request->file('file')->getRealPath(), 'r');

        // Skip the first line
        for ($i = 0; $i < 1; $i++) {
            fgetcsv($handle, 1000, ',');
        }

        // Loop through each row of the CSV
        while (($row = fgetcsv($handle, 1000, ',')) !== false) {

            for($i = 3 ; $i< 27 ; $i++){
                if($i % 2 !== 0){
                    if (!empty($row[$i])) {
                        try {
                            // Convert the date (adjust the format according to your CSV)
                            $row[$i] = Carbon::createFromFormat('d/m/Y', $row[$i])->format('Y-m-d');
                        } catch (\Exception $e) {
                            // Handle invalid date format
                            $row[$i] = null; // Set it to null or handle the error as needed
                        }
                    } else {
                        $row[$i] = null; // If the date field is empty, set it to null
                    }
                }
            }


            $clientId = Client::where('code' , $row[0])->value('id');

            // Create a client record for each row

            if(!is_null($clientId)){
                Tvam::create([
                        "clients_id"=> $clientId,
                        'date_depot_1' => $row[3],
                        'num_depot_1' => $row[4],
                        'date_depot_2' => $row[5],
                        'num_depot_2' => $row[6],
                        'date_depot_3' => $row[7],
                        'num_depot_3' => $row[8],
                        'date_depot_4' => $row[9],
                        'num_depot_4' => $row[10],
                        'date_depot_5' => $row[11],
                        'num_depot_5' => $row[12],
                        'date_depot_6' => $row[13],
                        'num_depot_6' => $row[14],
                        'date_depot_7' => $row[15],
                        'num_depot_7' => $row[16],
                        'date_depot_8' => $row[17],
                        'num_depot_8' => $row[18],
                        'date_depot_9' => $row[19],
                        'num_depot_9' => $row[20],
                        'date_depot_10' => $row[21],
                        'num_depot_10' => $row[22],
                        'date_depot_11' => $row[23],
                        'num_depot_11' => $row[24],
                        'date_depot_12' => $row[25],
                        'num_depot_12' => $row[26],
                ]);

            }

            
        }

        // Close the file handler
        fclose($handle);

        return back()->with('success', 'Tvam data imported successfully!');
    }
}
