<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\History;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $code = $request->input('code');
        $annee = $request->input('annee');
        $mois = $request->input('mois');

        $clients = Client::query();

        if(Auth::user()->role == 'Admin'){
            $clients->select('*')->orderBy('created_at' , 'desc');

            $userId = $request->input('name');
            $users = User::all();
            if ($request->input('name')) {
                $clients->where('users_id', '=', $userId);
            }
        }
        else{
            $clients->where('users_id' , Auth::user()->id)->orderBy('created_at' , 'desc')->get();
        }
        
        if($code){
            $clients->where('code' , $code);
        }

        if($annee){
            $clients->whereYear('created_at' , $annee);

            if($mois){
                $clients->whereYear('created_at' , $annee)
                ->whereMonth('created_at' , $mois);
            }
        }

        $clients = $clients->get();
        
        
        return view('clients', compact('clients' )  + ['users' => $users ?? null]);
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

        $valid = $request->validate([
            'code' => 'unique:clients'
        ]);

        if($request->input('users_id')){
            $collab = $request->input('users_id');
        }
        else{
            $collab = Auth::user()->id;
        }

        // Create a client record for each row
        Client::create([
            'code' => $request->input('code'),
            'nom' => $request->input('nom'),
            'status' => $request->input('status'),
            'adresse' => $request->input('adresse'),
            'IF' => $request->input('IF'),
            'TP' => $request->input('TP'),
            'ICE' => $request->input('ICE'),
            'CNSS' => $request->input('CNSS'),
            'RC' => $request->input('RC'),
            'debut_activite' => $request->input('debut_activite'),
            'activite' => $request->input('activite'),
            'ville' => $request->input('ville'),
            'users_id' => $collab
        ]);

        return back()->with('add' , "Nouvel client a été inserer!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $deletedClients = Client::onlyTrashed();

        if($request->input('typeDlt') == 'dech'){
            $deletedClients->where('deletetype' , 'decharge');
        }
        elseif($request->input('typeDlt') == 'liq'){
            $deletedClients->where('deletetype' , 'liquidation');
        }

        $deletedClients = $deletedClients->get();

        $users = User::all();

        return view('deletedClients' , compact('deletedClients')+['users'=>$users]);
    
    
    }

    public function showTable(Request $request)
    {
        $deletedClients = Client::onlyTrashed();

        if($request->input('typeDlt') == 'dech'){
            $deletedClients->where('deletetype' , 'decharge');
        }
        elseif($request->input('typeDlt') == 'liq'){
            $deletedClients->where('deletetype' , 'liquidation');
        }

        $deletedClients = $deletedClients->get();

        return view('deletedClientsTable' , compact('deletedClients'));
    
    }

    public function newClients(Request $request){

        $annee = $request->input('annee');
        $mois = $request->input('mois');

        // Start with an empty collection
        $clients = collect();

        if ($annee) {
            // Build the query only if $annee is provided
            $clients = Client::query()->whereYear('created_at', $annee);

            if ($mois) {
                $clients->whereMonth('created_at', $mois);
            }

            // Execute the query to get results
            $clients = $clients->get();
        }

        return view('newClients', compact('clients'));

    }

    public function restore($id)
    {
        $client = Client::onlyTrashed()->find($id);
        $client->deletetype = null;
        $client->motif = null;
        $client->motifdoc = null;

        $client->restore();

        return redirect()->route('clients.index')->with('restored' , 'Le client a été restorer');
    }

    public function history(Request $request)
    {

        $history = History::select('*')->orderBy('updated_at' , 'desc')->get();

        $clientsInHistory = History::select('clients_id', DB::raw('MIN(users_id) as min_users_id'))
        ->groupBy('clients_id')
        ->orderBy('min_users_id' , 'desc');

        if($request->input('clients_id')){
            $clientsInHistory->where('clients_id' , $request->input('clients_id'));
        }

        $clientsInHistory = $clientsInHistory->get();

        $users = User::all();

        return view('history' , compact('history' , 'clientsInHistory')+['users'=>$users]);
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $users = User::all();
        $activeData = $client;
        $page = 'clients';
        return view('edit' , compact('activeData' , 'page' , 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {

        $codeClient = Client::where('code' , $client->code)->value('code');
        
        if($request->input('code') != $codeClient){
            $valid = $request->validate([
                'code' => 'unique:clients'
            ]);
        }

        if($request->input('users_id')){
            $collab = $request->input('users_id');
        }
        else{
            $collab = Auth::user()->id;
        }
        
        $client->update([
            'code' => $request->input('code'),
            'nom' => $request->input('nom'),
            'status' => $request->input('status'),
            'adresse' => $request->input('adresse'),
            'IF' => $request->input('IF'),
            'TP' => $request->input('TP'),
            'ICE' => $request->input('ICE'),
            'CNSS' => $request->input('CNSS'),
            'RC' => $request->input('RC'),
            'debut_activite' => $request->input('debut_activite'),
            'activite' => $request->input('activite'),
            'ville' => $request->input('ville'),
            'users_id' => $collab,
        ]);

        return back()->with('mod' , "Modification reussite!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client , $deletetype)
    {

        $client->deletetype = $deletetype;
        $client->save();

        $client->delete();

        return back()->with('success' ,  "Le client est en ".$deletetype."!");
    }

    public function storeMotif(Request $request , $id)
    {

        $trachedClient = Client::onlyTrashed()->findOrFail($id);

        $request->validate([
            'motifdoc' => 'file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('motifdoc')) {
            $motifDocPath = $request->file('motifdoc')->store('documents' , 'public');
        }
        else{
            $motifDocPath = null;
        }

        $trachedClient->update([
            'motif' => $request->input('motif'),
            'motifdoc' => $motifDocPath
        ]);
        
        return back()->with('success' ,  "Le motif a été sauvegarder !");
    }

    public function storeNewCltMotif(Request $request , $id)
    {

        $newClient = Client::find($id);

        $newClient->update([
            'newCltMotif' => $request->input('newCltMotif'),
        ]);
        
        return back();
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

        // Loop through each row of the CSV
        while (($row = fgetcsv($handle, 1000, ',')) !== false) {

            if (!empty($row[9])) {
                try {
                    // Convert the date (adjust the format according to your CSV)
                    $dateActivite = Carbon::createFromFormat('d/m/Y', $row[9])->format('Y-m-d');
                } catch (\Exception $e) {
                    // Handle invalid date format
                    $dateActivite = null; // Set it to null or handle the error as needed
                }
            } else {
                $dateActivite = null; // If the date field is empty, set it to null
            }

            $collabId = User::where('name' , $row[12])->value('id');

            // Create a client record for each row
            Client::create([
                'code' => $row[0],
                'nom' => $row[1],
                'status' => $row[2],
                'adresse' => $row[3],
                'IF' => $row[4],
                'TP' => $row[5],
                'ICE' => $row[6],
                'CNSS' => $row[7],
                'RC' => $row[8],
                'debut_activite' => $dateActivite,
                'activite' => $row[10],
                'ville' => $row[11],
                'users_id' => $collabId,
            ]);
        }

        // Close the file handler
        fclose($handle);

        return back()->with('success', 'Clients data importées avec succée!');
    }
}
