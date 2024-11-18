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
        $users = User::all();

        // Filter by selected user if provided
        if ($request->input('name')) {
            $userId = $request->input('name');
            $acompteData->whereHas('clients', function ($query) use ($userId) {
                $query->where('users_id', '=', $userId);
            });
        }
        //for the addform component
        $clients = Client::all();

        
    } else {
        // For non-Admin users, restrict the query by logged-in user's ID
        $acompteData->whereHas('clients', function ($query) {
            $query->where('users_id', '=', Auth::user()->id);
        });

        //for the addform component
        $clients = Client::where('users_id' , Auth::user()->id)->get();
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

    if(request('alertFilter')){
        $acompteData->where('date_depot_'.(ceil(Date('n')/3)+1) , null);
        if (Auth::user()->role == 'Admin') {    

            if ($request->input('namecollab')) {
                $userId = $request->input('namecollab');
                $acompteData->whereHas('clients', function ($query) use ($userId) {
                    $query->where('users_id', '=', $userId);
                });
    
            }
    
        } 
    }

    // Finally, get the filtered data (only call `get()` once)
    $acompteData = $acompteData->get();

    // Return the view with filtered data
    return view('acompte', compact('clients' , 'acompteData') + ['users' => $users ?? null]);
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


        Acompte::create([
            "clients_id"=> $clientId,
            'date_depot_1' => $request->input('date_depot_1'),
            'num_depot_1' => $request->input('num_depot_1'),
            'date_depot_2' => $request->input('date_depot_2'),
            'num_depot_2' => $request->input('num_depot_2'),
            'date_depot_3' => $request->input('date_depot_3'),
            'num_depot_3' => $request->input('num_depot_3'),
            'date_depot_4' => $request->input('date_depot_4'),
            'num_depot_4' => $request->input('num_depot_4'), 
            'date_depot_5' => $request->input('date_depot_5'),
            'num_depot_5' => $request->input('num_depot_5'),
            'annee' => Date('Y')
        ]);

        return back()->with('add' , "Nouvelles données a été inserser!");
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
        $activeData = $acompte;
        $page = 'acompte';
        return view('edit' , compact('activeData' , 'page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Acompte $acompte)
    {
        $acompte->update([
            'date_depot_1' => $request->input('date_depot_1'),
            'num_depot_1' => $request->input('num_depot_1'),
            'date_depot_2' => $request->input('date_depot_2'),
            'num_depot_2' => $request->input('num_depot_2'),
            'date_depot_3' => $request->input('date_depot_3'),
            'num_depot_3' => $request->input('num_depot_3'),
            'date_depot_4' => $request->input('date_depot_4'),
            'num_depot_4' => $request->input('num_depot_4'),
            'date_depot_5' => $request->input('date_depot_5'),
            'num_depot_5' => $request->input('num_depot_5'),

            'motif_1' => $request->input('motif_1'),
            'motif_2' => $request->input('motif_2'),
            'motif_3' => $request->input('motif_3'),
            'motif_4' => $request->input('motif_4'),
            'motif_5' => $request->input('motif_5'),
        ]);

        return back()->with('mod' , "Modification reussite!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Acompte $acompte)
    {
        $acompte->delete();

        return back()->with('success' ,  'Supprission réussite!');
    }

}
