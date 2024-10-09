<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Auth;
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

        if(Auth::user()->role == 'Admin'){
            $clients = Client::all();

            $userId = $request->input('name');
            $users = User::where('role' , 'responsable')->get();
            if ($request->input('name')) {
            
                $clients = Client::where('users_id', '=', $userId)->get();
            }
        }
        else{
            $clients = Client::where('users_id' , Auth::user()->id)->get();
        }
        
        if($code){
            $clients = Client::where('code' , $code)->get();
        }
        
        return view('clients', compact('clients' )  + ['users' => $users ?? null]);
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

        $valid = $request->validate([
            'code' => 'unique:clients'
        ]);

        // Create a client record for each row
        Client::create([
            'code' => $request->input('code'),
            'nom' => $request->input('nom'),
            'status' => $request->input('status'),
            'adresse' => $request->input('adresse'),
            'IF' => $request->input('IF'),
            'TP' => $request->input('TP'),
            'ICE' => $request->input('ICE'),
            'CNSS' => $request->input('CNSS'),
            'RC' => $request->input('RC'),
            'debut_activite' => $request->input('debut_activite'),
            'activite' => $request->input('activite'),
            'users_id' => $request->input('users_id'),
        ]);

        return back()->with('add' , "Nouvel client a été inserer!");
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
        $users = User::all();
        $activeData = $client;
        $page = 'clients';
        return view('edit' , compact('activeData' , 'page' , 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {

        $codeClient = Client::where('code' , $client->code)->value('code');
        
        if($request->input('code') != $codeClient){
            $valid = $request->validate([
                'code' => 'unique:clients'
            ]);
        }
        
        $client->update([
            'code' => $request->input('code'),
            'nom' => $request->input('nom'),
            'status' => $request->input('status'),
            'adresse' => $request->input('adresse'),
            'IF' => $request->input('IF'),
            'TP' => $request->input('TP'),
            'ICE' => $request->input('ICE'),
            'CNSS' => $request->input('CNSS'),
            'RC' => $request->input('RC'),
            'debut_activite' => $request->input('debut_activite'),
            'activite' => $request->input('activite'),
            'users_id' => $request->input('users_id'),
        ]);

        return back()->with('mod' , "Modification reussite!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return back()->with('success' ,  'Supprission réussite!');
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

            $collabId = User::where('name' , $row[11])->value('id');

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
                'users_id' => $collabId,
            ]);
        }

        // Close the file handler
        fclose($handle);

        return back()->with('success', 'Clients imported successfully!');
    }
}
