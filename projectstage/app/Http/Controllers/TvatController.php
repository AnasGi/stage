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
        $users = User::all(); // Get users once at the start

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

    if(request('alertFilter')){
        $tvatData->where('date_depot_'.(ceil(Date('n')/3)) , null);

        if (Auth::user()->role == 'Admin') {    

            if ($request->input('namecollab')) {
                $userId = $request->input('namecollab');
                $tvatData->whereHas('clients', function ($query) use ($userId) {
                    $query->where('users_id', '=', $userId);
                });
    
            }
    
        } 
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

        $request->validate([
            'code' => 'exists:clients'
        ]);

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
        $activeData = $tvat;
        $page = 'tvat';
        return view('edit' , compact('activeData' , 'page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tvat $tvat)
    {
        $tvat->update([
            'date_depot_1' => $request->input('date_depot_1'),
            'num_depot_1' => $request->input('num_depot_1'),
            'date_depot_2' => $request->input('date_depot_2'),
            'num_depot_2' => $request->input('num_depot_2'),
            'date_depot_3' => $request->input('date_depot_3'),
            'num_depot_3' => $request->input('num_depot_3'),
            'date_depot_4' => $request->input('date_depot_4'),
            'num_depot_4' => $request->input('num_depot_4'),

            'motif_1' => $request->input('motif_1'),
            'motif_2' => $request->input('motif_2'),
            'motif_3' => $request->input('motif_3'),
            'motif_4' => $request->input('motif_4'),
        ]);

        return back()->with('mod' , "Modification reussite!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tvat $tvat)
    {
        $tvat->delete();

        return back()->with('success' ,  'Supprission réussite!');
    }

}
