<?php

namespace App\Http\Controllers\Account;

use DB;
use Auth;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manage.profile.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sduid = $request->input('sduid');
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $tel = $request->input('tel', NULL);
        $position = $request->input('position', NULL);

        if(
            $sduid == Auth::user()->sdu_id
            &&
            $firstname == Auth::user()->firstname
            &&
            $lastname == Auth::user()->lastname
        )
        {
            return 'true';
        }

        $ruleSduid = $sduid != Auth::user()->sdu_id ? '|unique:users,sdu_id':'';

        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'sduid' => 'required|integer|digits_between:4,14' . $ruleSduid,
        ]);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $result = DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->update([
                        'sdu_id' => $sduid,
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'tel' => $tel,
                        'position' => $position,
                    ]);

        return $result ? 'true':'false';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getCheckEmail(Request $request)
    {
        $validator = Validator::make(['email' => $request->input('email')], ['email' => 'unique:users,email',]);

        return $validator->fails() ? 'false':'true';
    }

    public function getCheckSduid(Request $request)
    {
        if( (string) $request->input('sduid') == (string) Auth::user()->sdu_id )
        {
            return 'true';
        }

        $validator = Validator::make(['sduid' => $request->input('sduid')], ['sduid' => 'unique:users,sdu_id',]);

        return $validator->fails() ? 'false':'true';
    }
}
