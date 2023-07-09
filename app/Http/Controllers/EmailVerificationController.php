<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\EmailVerification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{

    public function sendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return [
                'message' => 'Cuenta ya verificada',
                'status' => true
            ];
        }
        $request->user()->sendEmailVerificationNotification();
        return [
            'message' => 'Se envio link de verificacion',
            'status' => true
        ];
    }

    public function verify(Request $request)
    {
        $user = User::findOrFail($request->id);

        if ($user->email_verified_at) {
            return redirect(env('APP_URL_REACT'));
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
            return redirect(env('APP_URL_REACT'));
        }
        // Email has benverified
        return redirect(env('APP_URL_REACT'));
    }










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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmailVerification  $emailVerification
     * @return \Illuminate\Http\Response
     */
    public function show(EmailVerification $emailVerification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmailVerification  $emailVerification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmailVerification $emailVerification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmailVerification  $emailVerification
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailVerification $emailVerification)
    {
        //
    }
}
