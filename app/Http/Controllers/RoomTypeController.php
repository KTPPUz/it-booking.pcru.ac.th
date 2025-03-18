<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storeroom_typeRequest;
use App\Http\Requests\Updateroom_typeRequest;
use App\Models\room_type;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Storeroom_typeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(room_type $room_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(room_type $room_type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateroom_typeRequest $request, room_type $room_type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(room_type $room_type)
    {
        //
    }
}
