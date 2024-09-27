<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $code = $request->input('code');
        if($code){
            $clients = Client::where('code' , $code)->get();
        }
        else{
            $clients = Client::all();
        }
        return view('welcome', compact('clients'));
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
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
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

            if (!empty($row[9])) {
                try {
                    // Convert the date (adjust the format according to your CSV)
                    $dateActivite = Carbon::createFromFormat('d/m/Y', $row[9])->format('Y-m-d');
                } catch (\Exception $e) {
                    // Handle invalid date format
                    $dateActivite = null; // Set it to null or handle the error as needed
                }
            } else {
                $dateActivite = null; // If the date field is empty, set it to null
            }

            // Create a client record for each row
            Client::create([
                'code' => $row[0],
                'nom' => $row[1],
                'status' => $row[2],
                'adresse' => $row[3],
                'IF' => $row[4],
                'TP' => $row[5],
                'ICE' => $row[6],
                'CNSS' => $row[7],
                'RC' => $row[8],
                'debut_activite' => $dateActivite,
                'activite' => $row[10],
                'collaborateur' => $row[11],
            ]);
        }

        // Close the file handler
        fclose($handle);

        return back()->with('success', 'Clients imported successfully!');
    }
}
