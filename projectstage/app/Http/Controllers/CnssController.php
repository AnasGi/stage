<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Cnss;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CnssController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $code = Client::where('code' , $request->input('code'))->value('id');

        if($code){
            $cnssData = Cnss::where('clients_id' , $code)->get();
        }
        else{
            $cnssData = Cnss::all();
        }
        return view('cnss' , compact('cnssData'));
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
    public function show(Cnss $cnss)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cnss $cnss)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cnss $cnss)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cnss $cnss)
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

            for($i = 3 ; $i<=14 ; $i++){
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


            $clientId = Client::where('code' , $row[0])->value('id');

            // Create a client record for each row

            if(!is_null($clientId)){

                Cnss::create([
                        "clients_id"=> $clientId,
                        'date_depot_1' => $row[3],
                        'date_depot_2' => $row[4],
                        'date_depot_3' => $row[5],
                        'date_depot_4' => $row[6],
                        'date_depot_5' => $row[7],
                        'date_depot_6' => $row[8],
                        'date_depot_7' => $row[9],
                        'date_depot_8' => $row[10],
                        'date_depot_9' => $row[11],
                        'date_depot_10' => $row[12],
                        'date_depot_11' => $row[13],
                        'date_depot_12' => $row[14],
                ]);
            }

            
        }

        // Close the file handler
        fclose($handle);

        return back()->with('success', 'Cnss data imported successfully!');
    }
}
