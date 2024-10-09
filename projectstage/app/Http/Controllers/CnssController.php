<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Cnss;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CnssController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{

    // Start building the query
    $cnssData = Cnss::query(); // Initialize a query builder instance

    // For the Admin role
    if (Auth::user()->role == 'Admin') {
        $users = User::where('role', 'responsable')->get();

        // Filter by selected user if provided
        if ($request->input('name')) {
            $userId = $request->input('name');
            $cnssData->whereHas('clients', function ($query) use ($userId) {
                $query->where('users_id', '=', $userId);
            });
        }
        //for the addform component
        $clients = Client::all();

        

    } else {
        // For non-Admin users, restrict the query by logged-in user's ID
        $cnssData->whereHas('clients', function ($query) {
            $query->where('users_id', '=', Auth::user()->id);
        });

        //for the addform component
        $clients = Client::where('users_id' , Auth::user()->id)->get();
    }

    // Filter by client code (if provided)
    if ($request->input('code')) {
        $clientId = Client::where('code', $request->input('code'))->value('id');
        if ($clientId) {
            $cnssData->where('clients_id', $clientId);
        }
    }

    // Filter by date (if provided)
    if ($request->input('date')) {
        $cnssData->where('date_depot', $request->input('date'));
    }

    // Filter by year (if provided)
    if ($request->input('annee')) {
        $cnssData->where('annee', $request->input('annee'));
    } else {
        // If no year is provided, default to the current year
        $cnssData->where('annee', Date('Y'));
    }

    // Finally, get the filtered data (only call `get()` once)
    $cnssData = $cnssData->get();

    // Return the view with filtered data
    return view('cnss', compact('cnssData' , 'clients') + ['users' => $users ?? null]);
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

        Cnss::create([
            "clients_id"=> $clientId,
            'date_depot_1' => $request->input('date_depot_1'),
            'date_depot_2' => $request->input('date_depot_2'),
            'date_depot_3' => $request->input('date_depot_3'),
            'date_depot_4' => $request->input('date_depot_4'),
            'date_depot_5' => $request->input('date_depot_5'),
            'date_depot_6' => $request->input('date_depot_6'),
            'date_depot_7' => $request->input('date_depot_7'),
            'date_depot_8' => $request->input('date_depot_8'),
            'date_depot_9' => $request->input('date_depot_9'),
            'date_depot_10' => $request->input('date_depot_10'),
            'date_depot_11' => $request->input('date_depot_11'),
            'date_depot_12' => $request->input('date_depot_12'),
            'annee' => Date('Y')
        ]);

        return back()->with('add' , "Nouvelles données a été inserser!");


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
        $activeData = $cnss;
        $page = 'cnss';
        return view('edit' , compact('activeData' , 'page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cnss $cnss)
    {
        $cnss->update([
            'date_depot_1' => $request->input('date_depot_1'),
            'date_depot_2' => $request->input('date_depot_2'),
            'date_depot_3' => $request->input('date_depot_3'),
            'date_depot_4' => $request->input('date_depot_4'),
            'date_depot_5' => $request->input('date_depot_5'),
            'date_depot_6' => $request->input('date_depot_6'),
            'date_depot_7' => $request->input('date_depot_7'),
            'date_depot_8' => $request->input('date_depot_8'),
            'date_depot_9' => $request->input('date_depot_9'),
            'date_depot_10' => $request->input('date_depot_10'),
            'date_depot_11' => $request->input('date_depot_11'),
            'date_depot_12' => $request->input('date_depot_12'),
        ]);

        return back()->with('mod' , "Modification reussite!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cnss $cnss)
    {
        $cnss->delete();

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

        $dateDepot = [];
        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            try{
                array_push($dateDepot, Carbon::createFromFormat('d/m/Y', $row[4])->format('Y'));
            }
            catch(\Exception $e){
                continue;
            }

        }  
        $minYear = min($dateDepot);

        rewind($handle);
        
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
                        'annee' => $minYear
                ]);
            }

            
        }

        // Close the file handler
        fclose($handle);

        return back()->with('success', 'Cnss data imported successfully!');
    }
}
