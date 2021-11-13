<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return view("client.index", ["clients"=>$clients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("client.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new Client;

        $client->name = $request->clientName;
        $client->surname = $request->clientSurname;
        $client->description = $request->clientDescription;

        $client->save();

        $success = [
            'message' => '[Back-End] Client added successfully',
            'clientID' => $client->id,
            'clientName' => $client->name,
            'clientSurname' => $client->surname,
            'clientDescription' => $client->description
        ];

        //JSON masyvas
        $success_json = response()->json($success);

        return $success_json;

        // return "Clients added successfully";

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return "Deleted";
    }

    public function validationcreate() {
        return view("client.validationcreate");
    }

    public function validationstore(Request $request) {

        // $client = new Client;

        // $request->validate([
        //     'name' => 'required'
        // ]);
        $input = [
            'name' => $request->name,
            'surname' => $request->surname
        ];

        $rules = [
            'name' => 'required|alpha',//privalomas, leidzia irasyti tik raides
            'surname' => 'numeric|max:65'
        ];

        $messages = [
            'required' => "The name field is required",
            'alpha' => "Only letters"
        ];

        $validator = Validator::make($input, $rules, $messages );

        // patikrinti ar elementas egizistuoja ir ar netuscias
        //if($name && $surname) ir name ir surname yra netuscias

        // $validator->passes() kaip ifa, tik jame tikriname daugiau taisykliu


        if($validator->passes()) {
            $success = [
                'success' => "The name validated successfully"
            ];
            $success_json = response()->json($success);
            //sekmes atveju pasibaigia ties cia
            return $success_json ;
        }

        //nesekmes zinute/masyva

        $error = [
            // 'error' => 'The error has occured'
            // 'error' => $validator->errors()->all() // grazina visas klaidas numeruojame masyve
            'error' => $validator->messages()->get("*")
        ];

        $error_json = response()->json($error);

        return $error_json;

        // $client->name = $request->name;

        // $client->save();




    }
}
