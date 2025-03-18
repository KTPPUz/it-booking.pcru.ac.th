<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoresectsRequest;
use App\Http\Requests\UpdatesectsRequest;
use App\Models\Sect;

class SectsController extends Controller
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
    public function store(StoresectsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sect $sects)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sect $sects)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatesectsRequest $request, Sect $sects)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sect $sects)
    {
        //
    }

    public function getSects($department_code)
    {
        $sects = Sect::where('department_code', $department_code)->get();

        return response()->json($sects);
    }
}
