<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Bilan;
use App\Models\User;
use Carbon\Carbon;
use Date;
use Illuminate\Http\Request;
use Auth;

class BilanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Start building the query
    $bilanData = Bilan::query();

    // Filter for Admins
    if (Auth::user()->role == 'Admin') {
        $users = User::all();

        // Filter by selected user if provided
        if ($request->input('name')) {
            $userId = $request->input('name');
            $bilanData->whereHas('clients', function ($query) use ($userId) {
                $query->where('users_id', '=', $userId);
            });
        }
        //for the addform component
        $clients = Client::all();

        
    } else {
        // For non-Admin users, restrict the query by logged-in user's ID
        $bilanData->whereHas('clients', function ($query) {
            $query->where('users_id', '=', Auth::user()->id);
        });

        //for the addform component
        $clients = Client::where('users_id' , Auth::user()->id)->get();
    }

    // Apply additional filters

    // Filter by client code (if provided)
    if ($request->input('code')) {
        $clientId = Client::where('code', $request->input('code'))->value('id');
        if ($clientId) {
            $bilanData->where('clients_id', $clientId);
        }
    }

    // Filter by date (if provided)
    if ($request->input('date')) {
        $bilanData->where('date_depot', $request->input('date'));
    }

    // Filter by year (if provided)
    if ($request->input('annee')) {
        $bilanData->where('annee', $request->input('annee'));
    } else {
        // If no year is provided, default to the current year
        $bilanData->where('annee', Date('Y'));
    }

    if(request('alertFilter')){
        $bilanData->where('date_depot' , null);
        if (Auth::user()->role == 'Admin') {    

            if ($request->input('namecollab')) {
                $userId = $request->input('namecollab');
                $bilanData->whereHas('clients', function ($query) use ($userId) {
                    $query->where('users_id', '=', $userId);
                });
    
            }
    
        } 
    }

    // Finally, get the filtered data (only call `get()` once)
    $bilanData = $bilanData->get();

    // Return view with filtered data
    return view('bilan', compact('clients' , 'bilanData') + ['users' => $users ?? null]);
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


        Bilan::create([
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
    public function show(Bilan $Bilan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bilan $Bilan)
    {
        $activeData = $Bilan;
        $page = 'bilan';
        return view('edit' , compact('activeData' , 'page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bilan $Bilan)
    {
        $Bilan->update([
            'date_depot' => $request->input('date_depot'),
            'num_depot' => $request->input('num_depot'),
            'motif' => $request->input('motif'),
        ]);

        return back()->with('mod' , "Modification reussite!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bilan $Bilan)
    {
        $Bilan->delete();

        return back()->with('success' ,  'Supprission réussite!');
    }

}
