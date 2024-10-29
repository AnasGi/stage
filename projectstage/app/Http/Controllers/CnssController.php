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
        $users = User::all();

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

    if(request('alertFilter')){
        $cnssData->where('date_depot_'.Date('n') , null);
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
            
            'motif_1' => $request->input('motif_1'),
            'motif_2' => $request->input('motif_2'),
            'motif_3' => $request->input('motif_3'),
            'motif_4' => $request->input('motif_4'),
            'motif_5' => $request->input('motif_5'),
            'motif_6' => $request->input('motif_6'),
            'motif_7' => $request->input('motif_7'),
            'motif_8' => $request->input('motif_8'),
            'motif_9' => $request->input('motif_9'),
            'motif_10' => $request->input('motif_10'),
            'motif_11' => $request->input('motif_11'),
            'motif_12' => $request->input('motif_12'),
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

}
