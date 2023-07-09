<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmEmail;

class ConfirmCount extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'name' => "required",
            'email' => "required|email",
        ]);




        $correo = new ConfirmEmail($request->all());
        Mail::to($request->email)->send($correo);
        return view("confirm", [
            'contact' => $request,
        ]);
        return "mensaje no enviado";
    }
}
