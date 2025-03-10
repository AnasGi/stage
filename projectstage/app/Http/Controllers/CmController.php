<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Cm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class CmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Start building the query
    $cmData = Cm::query(); // Initialize a query builder instance

    // For the Admin role
    if (Auth::user()->role == 'Admin') {
        $users = User::all();

        // Filter by selected user if provided
        if ($request->input('name')) {
            $userId = $request->input('name');
            $cmData->whereHas('clients', function ($query) use ($userId) {
                $query->where('users_id', '=', $userId);
            });
        }
        //for the addform component
        $clients = Client::all();

        
    } else {
        // For non-Admin users, restrict the query by logged-in user's ID
        $cmData->whereHas('clients', function ($query) {
            $query->where('users_id', '=', Auth::user()->id);
        });

        //for the addform component
        $clients = Client::where('users_id' , Auth::user()->id)->get();
    }

    // Filter by client code (if provided)
    if ($request->input('code')) {
        $clientId = Client::where('code', $request->input('code'))->value('id');
        if ($clientId) {
            $cmData->where('clients_id', $clientId);
        }
    }

    // Filter by date (if provided)
    if ($request->input('date')) {
        $cmData->where('date_depot', $request->input('date'));
    }

    // Filter by year (if provided)
    if ($request->input('annee')) {
        $cmData->where('annee', $request->input('annee'));
    } else {
        // If no year is provided, default to the current year
        $cmData->where('annee', Date('Y'));
    }

    if(request('alertFilter')){
        $cmData->where('date_depot' , null);

        if (Auth::user()->role == 'Admin') {    

            if ($request->input('namecollab')) {
                $userId = $request->input('namecollab');
                $cmData->whereHas('clients', function ($query) use ($userId) {
                    $query->where('users_id', '=', $userId);
                });
    
            }
    
        } 
    }

    // Finally, get the filtered data (only call `get()` once)
    $cmData = $cmData->get();

    // Return the view with filtered data
    return view('cm', compact('clients' , 'cmData') + ['users' => $users ?? null]);
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

        Cm::create([
            "clients_id"=> $clientId,
            'date_depot' => $request->input('date_depot'),
            'num_depot' => $request->input('num_depot'),
            'montant' => $request->input('montant'),
            'annee' => $request->input('annee') ?? Date('Y'),
        ]);

        return back()->with('add' , "Nouvelles données a été inserser!");
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cm $Cm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cm $Cm)
    {
        $activeData = $Cm;
        $page = 'cm';
        return view('edit' , compact('activeData' , 'page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cm $Cm)
    {
        $Cm->update([
            'date_depot' => $request->input('date_depot'),
            'num_depot' => $request->input('num_depot'),
            'montant' => $request->input('montant'),
            'motif' => $request->input('motif'),
            
        ]);

        return back()->with('mod' , "Modification reussite!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cm $Cm)
    {
        $Cm->delete();

        return back()->with('success' ,  'Supprission réussite!');
    }

}
