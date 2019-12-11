<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('task.create');
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
      //Validate incoming data
      $request->validate([
        "description" => "required",
        "status" => "required",
      ]);

      //Create task in DB
      Task::create([
        "description" => $request->description,
        "status" => $request->status == 'true' ? true : false,
        "user_id" => (int) $request->user_id,
      ]);

      return response('Task is successfully created.', 200)->header('Content-Type', 'application/json'); //Send response
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
        "description" => "required",
        "status" => "required"
      ]);

      //Convert status to int from 'true' or 'false'
      $status = $request->status == 'true' ? 1 : 0;

      //Update user name in DB
      Task::where('id', $id)->update(['description' => $request->description, 'status' => $status]);
      
      return response('You are successfully edited the task!', 200)->header('Content-Type', 'application/json'); //Send response
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      //Delete the user
      Task::where('id', $id)->delete();

      //Send response
      return response('You are successfully deleted the task!', 200)->header('Content-Type', 'application/json');
    }
}
