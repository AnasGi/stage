<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Tp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class TpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Initialize the query builder
    $tpData = Tp::query(); // Start with a query builder instance

    // For the Admin role
    if (Auth::user()->role == 'Admin') {
        $users = User::where('role', 'responsable')->get();

        // Filter by selected user if provided
        if ($request->input('name')) {
            $userId = $request->input('name');
            $tpData->whereHas('clients', function ($query) use ($userId) {
                $query->where('users_id', '=', $userId);
            });
        }
    } else {
        // For non-Admin users, restrict the query by logged-in user's ID
        $tpData->whereHas('clients', function ($query) {
            $query->where('users_id', '=', Auth::user()->id);
        });
    }

    // Filter by client code (if provided)
    if ($request->input('code')) {
        $clientId = Client::where('code', $request->input('code'))->value('id');
        if ($clientId) {
            $tpData->where('clients_id', $clientId);
        }
    }

    // Filter by date (if provided)
    if ($request->input('date')) {
        $tpData->where('date_depot', $request->input('date'));
    }

    // Filter by year (if provided)
    if ($request->input('annee')) {
        $tpData->where('annee', $request->input('annee'));
    } else {
        // If no year is provided, default to the current year
        $tpData->where('annee', Date('Y'));
    }

    // Finally, get the filtered data (only call `get()` once)
    $tpData = $tpData->get();

    // Return the view with filtered data
    return view('tp', compact('tpData') + ['users' => $users ?? null]);
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
    public function show(Tp $Tp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tp $Tp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tp $Tp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tp $Tp)
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
            try{
                array_push($dateDepot, Carbon::createFromFormat('d/m/Y', $row[3])->format('Y'))-1;
            }
            catch(\Exception $e){
                continue;
            }

        }  
        $minYear = min($dateDepot);

        rewind($handle);
        
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
                Tp::create([
                        "clients_id"=> $clientId,
                        'date_depot' => $row[3],
                        'num_depot' => $row[4],
                'annee' => $minYear
                ]);

            }

            
        }

        // Close the file handler
        fclose($handle);

        return back()->with('success', 'Tp 9421 data imported successfully!');
    }
}