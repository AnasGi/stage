<?php

namespace App\Http\Controllers;

use App\Models\Acompte;
use App\Models\Client;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class AcompteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Initialize the query builder
    $acompteData = Acompte::query(); // Start with a query builder instance

    // For the Admin role
    if (Auth::user()->role == 'Admin') {
        $users = User::where('role', 'responsable')->get();

        // Filter by selected user if provided
        if ($request->input('name')) {
            $userId = $request->input('name');
            $acompteData->whereHas('clients', function ($query) use ($userId) {
                $query->where('users_id', '=', $userId);
            });
        }
    } else {
        // For non-Admin users, restrict the query by logged-in user's ID
        $acompteData->whereHas('clients', function ($query) {
            $query->where('users_id', '=', Auth::user()->id);
        });
    }

    // Filter by client code (if provided)
    if ($request->input('code')) {
        $clientId = Client::where('code', $request->input('code'))->value('id');
        if ($clientId) {
            $acompteData->where('clients_id', $clientId);
        }
    }

    // Filter by year (if provided)
    if ($request->input('annee')) {
        $acompteData->where('annee', $request->input('annee'));
    } else {
        // If no year is provided, default to the current year
        $acompteData->where('annee', Date('Y'));
    }

    // Finally, get the filtered data (only call `get()` once)
    $acompteData = $acompteData->get();

    // Return the view with filtered data
    return view('acompte', compact('acompteData') + ['users' => $users ?? null]);
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
    public function show(Acompte $acompte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Acompte $acompte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Acompte $acompte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Acompte $acompte)
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

            for($i = 3 ; $i< 14 ; $i++){
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
                Acompte::create([
                        "clients_id"=> $clientId,
                        'date_depot_0' => $row[3],
                        'num_depot_0' => $row[4],
                        'date_depot_1' => $row[5],
                        'num_depot_1' => $row[6],
                        'date_depot_2' => $row[7],
                        'num_depot_2' => $row[8],
                        'date_depot_3' => $row[9],
                        'num_depot_3' => $row[10],
                        'date_depot_4' => $row[11],
                        'num_depot_4' => $row[12],
                        'annee'=>$minYear
                ]);
            }

            
        }

        // Close the file handler
        fclose($handle);

        return back()->with('success', 'Acompte data imported successfully!');
    }
}
