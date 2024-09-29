<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Cm;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $code = Client::where('code' , $request->input('code'))->value('id');

        if($code){
            $cmData = Cm::where('clients_id' , $code)->get();
        }
        else{
            $cmData = Cm::all();
        }
        return view('cm' , compact('cmData'));
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
    public function show(Cm $Cm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cm $Cm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cm $Cm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cm $Cm)
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

            if (!empty($row[3])) {
                try {
                    // Convert the date (adjust the format according to your CSV)
                    $row[3] = Carbon::createFromFormat('d/m/Y', $row[3])->format('Y-m-d');
                } catch (\Exception $e) {
                    // Handle invalid date format
                    $row[3] = null; // Set it to null or handle the error as needed
                }
            } else {
                $row[3] = null; // If the date field is empty, set it to null
            }

            $clientId = Client::where('code' , $row[0])->value('id');

            // Create a client record for each row

            if(!is_null($clientId)){
                Cm::create([
                        "clients_id"=> $clientId,
                        'date_depot' => $row[3],
                        'num_depot' => $row[4],
                        'montant' => $row[5],
                ]);

            }

            
        }

        // Close the file handler
        fclose($handle);

        return back()->with('success', 'Cm data imported successfully!');
    }
}
