<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Droittimber;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class DroittimberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Initialize the query builder for Droittimber
    $droittimberData = Droittimber::query();
    
    // Check the user's role and apply the appropriate filter
    if (Auth::user()->role == 'Admin') {
        // Fetch users with role 'responsable' for the dropdown
        $users = User::where('role', 'responsable')->get();    
        // If a specific user is selected, apply the filter
        if ($request->input('name')) {
            $userId = $request->input('name');
            $droittimberData->whereHas('clients', function ($query) use ($userId) {
                $query->where('users_id', '=', $userId);
            });
        }
    } else {
        // For non-admin users, filter by their user ID
        $droittimberData->whereHas('clients', function ($query) {
            $query->where('users_id', '=', Auth::user()->id);
        });
    }

    // Apply the client code filter if provided
    if ($request->input('code')) {
        $clientId = Client::where('code', $request->input('code'))->value('id');
        if ($clientId) {
            $droittimberData->where('clients_id', $clientId);
        }
    }
    if ($request->input('annee')) {
        $droittimberData->where('annee', $request->input('annee'));
    } else {
        $droittimberData->where('annee', Date('Y'));
    }

    // Execute the query to retrieve the filtered data
    $droittimberData = $droittimberData->get();

    // Return the view with the filtered data and users
    return view('droittimbre', compact('droittimberData') + ['users' => $users ?? null]);
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
    public function show(Droittimber $Droittimber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Droittimber $Droittimber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Droittimber $Droittimber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Droittimber $Droittimber)
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
                Droittimber::create([
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
                'annee' => $minYear
                ]);

            }

            
        }

        // Close the file handler
        fclose($handle);

        return back()->with('success', 'Droit de timber data imported successfully!');
    }
}
