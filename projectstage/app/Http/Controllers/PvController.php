<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Pv;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class PvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Initialize the query builder
    $pvData = Pv::query(); // Start with a query builder instance

    // For the Admin role
    if (Auth::user()->role == 'Admin') {
        $users = User::all();

        // Filter by selected user if provided
        if ($request->input('name')) {
            $userId = $request->input('name');
            $pvData->whereHas('clients', function ($query) use ($userId) {
                $query->where('users_id', '=', $userId);
            });
        }
        //for the addform component
        $clients = Client::all();

        
    } else {
        // For non-Admin users, restrict the query by logged-in user's ID
        $pvData->whereHas('clients', function ($query) {
            $query->where('users_id', '=', Auth::user()->id);
        });

        //for the addform component
        $clients = Client::where('users_id' , Auth::user()->id)->get();
    }

    // Filter by client code (if provided)
    if ($request->input('code')) {
        $clientId = Client::where('code', $request->input('code'))->value('id');
        if ($clientId) {
            $pvData->where('clients_id', $clientId);
        }
    }

    // Filter by date (if provided)
    if ($request->input('date')) {
        $pvData->where('date_depot', $request->input('date'));
    }

    // Filter by year (if provided)
    if ($request->input('annee')) {
        $pvData->where('annee', $request->input('annee'));
    } else {
        // If no year is provided, default to the current year
        $pvData->where('annee', Date('Y'));
    }

    if($request->input('rc')){
        $pvData->where('num_depot', $request->input('rc'));
    }

    if(request('alertFilter')){
        $pvData->where('date_depot' , null);

        if (Auth::user()->role == 'Admin') {    

            if ($request->input('namecollab')) {
                $userId = $request->input('namecollab');
                $pvData->whereHas('clients', function ($query) use ($userId) {
                    $query->where('users_id', '=', $userId);
                });
    
            }
    
        } 
    }

    // Finally, get the filtered data (only call `get()` once)
    $pvData = $pvData->get();

    // Return the view with filtered data
    return view('pv', compact('clients' , 'pvData') + ['users' => $users ?? null]);
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

        Pv::create([
            "clients_id"=> $clientId,
            'date_depot' => $request->input('date_depot'),
            'num_depot' => $request->input('num_depot'),
            'annee' => Date('Y')
        ]);

        return back()->with('add' , "Nouvelles données a été inserser!");
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pv $Pv)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pv $Pv)
    {
        $activeData = $Pv;
        $page = 'pv';
        return view('edit' , compact('activeData' , 'page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pv $Pv)
    {
        $Pv->update([
            'date_depot' => $request->input('date_depot'),
            'num_depot' => $request->input('num_depot'),
            'motif' => $request->input('motif'),
        ]);

        return back()->with('mod' , "Modification reussite!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pv $Pv)
    {
        $Pv->delete();

        return back()->with('success' ,  'Supprission réussite!');
    }
}
