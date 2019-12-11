<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $user = new User;
      $userTasks = $user->find($request->id)->tasks;
      $userName = $user->find($request->id)->name;

      return view('user.index', compact('userTasks', 'userName'));
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
      //Update the current user
      $request->validate([
        "name" => "required"
      ]);

      //Update user name in DB
      User::where('id', $id)->update(['name' => $request->name]);
      return response('You are successfully edited the user!', 200)->header('Content-Type', 'application/json'); //Send response
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = new User();

      //Delete all users tasks before deleting the user
      $user->find($id)->tasks()->delete();

      //Delete the user
      $user->where('id', $id)->delete();

      //Send response
      return response('You are successfully deleted the user and all related user tasks!', 200)->header('Content-Type', 'application/json');
    }
}
