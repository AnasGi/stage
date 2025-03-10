<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Irprof;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class IrprofController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Initialize the query builder
    $irprofData = Irprof::query(); // Start with a query builder instance

    // For the Admin role
    if (Auth::user()->role == 'Admin') {
        $users = User::all();

        // Filter by selected user if provided
        if ($request->input('name')) {
            $userId = $request->input('name');
            $irprofData->whereHas('clients', function ($query) use ($userId) {
                $query->where('users_id', '=', $userId);
            });
        }
        //for the addform component
        $clients = Client::all();

        
    } else {
        // For non-Admin users, restrict the query by logged-in user's ID
        $irprofData->whereHas('clients', function ($query) {
            $query->where('users_id', '=', Auth::user()->id);
        });

        //for the addform component
        $clients = Client::where('users_id' , Auth::user()->id)->get();
    }

    // Filter by client code (if provided)
    if ($request->input('code')) {
        $clientId = Client::where('code', $request->input('code'))->value('id');
        if ($clientId) {
            $irprofData->where('clients_id', $clientId);
        }
    }

    // Filter by date (if provided)
    if ($request->input('date')) {
        $irprofData->where('date_depot', $request->input('date'));
    }

    // Filter by year (if provided)
    if ($request->input('annee')) {
        $irprofData->where('annee', $request->input('annee'));
    } else {
        // If no year is provided, default to the current year
        $irprofData->where('annee', Date('Y'));
    }

    if(request('alertFilter')){
        $irprofData->where('date_depot' , null);

        if (Auth::user()->role == 'Admin') {    

            if ($request->input('namecollab')) {
                $userId = $request->input('namecollab');
                $irprofData->whereHas('clients', function ($query) use ($userId) {
                    $query->where('users_id', '=', $userId);
                });
    
            }
    
        } 
    }

    // Finally, get the filtered data (only call `get()` once)
    $irprofData = $irprofData->get();

    // Return the view with filtered data
    return view('irprof', compact('clients' , 'irprofData') + ['users' => $users ?? null]);
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


        Irprof::create([
            "clients_id"=> $clientId,
            'date_depot' => $request->input('date_depot'),
            'num_depot' => $request->input('num_depot'),
            'annee' => $request->input('annee') ?? Date('Y'),
        ]);

        return back()->with('add' , "Nouvelles données a été inserser!");
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Irprof $Irprof)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Irprof $Irprof)
    {
        $activeData = $Irprof;
        $page = 'irprof';
        return view('edit' , compact('activeData' , 'page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Irprof $Irprof)
    {
        $Irprof->update([
            'date_depot' => $request->input('date_depot'),
            'num_depot' => $request->input('num_depot'),
            'motif' => $request->input('motif'),
            'annee' => $request->input('annee')
        ]);

        return back()->with('mod' , "Modification reussite!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Irprof $Irprof)
    {
        $Irprof->delete();

        return back()->with('success' ,  'Supprission réussite!');
    }

}
