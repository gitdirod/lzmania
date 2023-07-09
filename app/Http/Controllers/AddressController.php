<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Models\Address;
use App\Models\Phone;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddressRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();

        $envoice_address = Address::where('envoice', $data['envoice'])->first();
        if (isset($envoice_address)) {
            $envoice_update = Address::find($envoice_address->id);

            $envoice_update->user_id = $user->id;
            $envoice_update->envoice = $data["envoice"];
            $envoice_update->people = $data["people"];
            $envoice_update->ccruc = $data["ccruc"];
            $envoice_update->city = $data["city"];
            $envoice_update->address = $data["address"];

            $phone_update = Phone::find($envoice_update->phone_id);
            $phone_update->number = $data["phone"];

            $phone_update->save();
            $envoice_update->save();

            return [
                'message' => 'Datos actualizados',
                'state' => true,
                'data' => $envoice_update
            ];
        }

        $phone = Phone::create([
            "user_id" => $user->id,
            "main" => false,
            "number" => $data["phone"],
        ]);

        $address = Address::create([
            "user_id" => $user->id,
            "envoice" => $data["envoice"],
            "people" => $data["people"],
            "ccruc" => $data["ccruc"],
            "city" => $data["city"],
            "address" => $data["address"],
            "phone_id" => $phone->id,
        ]);
        return [
            'message' => 'Dirección creada',
            'state' => true,
            'data' => $address
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        //
    }
}
