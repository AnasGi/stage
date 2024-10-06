<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Tvat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class TvatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Initialize the query builder for Tvat
    $tvatData = Tvat::query(); // Start with a query builder instance
    
    // Admin filtering logic
    if (Auth::user()->role == 'Admin') {
        // Apply year filter
        $users = User::where('role', 'responsable')->get(); // Get users once at the start

        // Apply user filter if specified
        if ($request->input('name')) {
            $userId = $request->input('name');
            $tvatData->whereHas('clients', function ($query) use ($userId) {
                $query->where('users_id', '=', $userId);
            });
        }
        //for the addform component
        $clients = Client::all();

        
    } else {
        // Non-Admin filtering logic
        $tvatData->whereHas('clients', function ($query) {
            $query->where('users_id', '=', Auth::user()->id);
        });

        //for the addform component
        $clients = Client::where('users_id' , Auth::user()->id)->get();
    }

    if ($request->input('code')) {
        $clientId = Client::where('code', $request->input('code'))->value('id');
        if ($clientId) {
            $tvatData->where('clients_id', $clientId);
        }
    }

    // Filter by year (if provided)
    if ($request->input('annee')) {
        $tvatData->where('annee', $request->input('annee'));
    } else {
        // If no year is provided, default to the current year
        $tvatData->where('annee', Date('Y'));
    }

    // Finally, get the filtered data (only call `get()` once)
    $tvatData = $tvatData->get();

    // Return the view with filtered data
    return view('tvat', compact('clients' , 'tvatData') + ['users' => $users ?? null]);
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

        $clientId = Client::where('code' , $request->input('code'))->value('id');

        Tvat::create([
            "clients_id"=> $clientId,
            'date_depot_1' => $request->input('date_depot_1'),
            'num_depot_1' => $request->input('num_depot_1'),
            'date_depot_2' => $request->input('date_depot_2'),
            'num_depot_2' => $request->input('num_depot_2'),
            'date_depot_3' => $request->input('date_depot_3'),
            'num_depot_3' => $request->input('num_depot_3'),
            'date_depot_4' => $request->input('date_depot_4'),
            'num_depot_4' => $request->input('num_depot_4'),
            'annee' => Date('Y')
        ]);

        return back()->with('add' , "Nouvelles données a été inserser!");
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tvat $tvat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tvat $tvat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tvat $tvat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tvat $tvat)
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

        $dateDepot = [];
        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            if(!empty($row[3])){
                try{
                    array_push($dateDepot, Carbon::createFromFormat('d/m/Y', $row[3])->format('Y'));
                }
                catch(\Exception $e){
                    continue;
                }
            }

        }  
        $minYear = min($dateDepot);

        rewind($handle);
        
        // Loop through each row of the CSV
        while (($row = fgetcsv($handle, 1000, ',')) !== false) {

            for($i = 3 ; $i< 12 ; $i++){
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
                Tvat::create([
                        "clients_id"=> $clientId,
                        'date_depot_1' => $row[3],
                        'num_depot_1' => $row[4],
                        'date_depot_2' => $row[5],
                        'num_depot_2' => $row[6],
                        'date_depot_3' => $row[7],
                        'num_depot_3' => $row[8],
                        'date_depot_4' => $row[9],
                        'num_depot_4' => $row[10],
                        'annee' => $minYear
                ]);
            }

            
        }

        // Close the file handler
        fclose($handle);

        return back()->with('success', 'Tvat data imported successfully!');
    }
}
