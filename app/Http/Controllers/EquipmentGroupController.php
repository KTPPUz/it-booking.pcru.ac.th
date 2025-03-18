<?php

namespace App\Http\Controllers;

use App\Models\AssetType;
use App\Models\EquipmentGroup;
use Illuminate\Http\Request;

class EquipmentGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipmentGroups = EquipmentGroup::all();
        $assetTypes = AssetType::all();
        return view('EquipmentGroup.index', compact('equipmentGroups', 'assetTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('equipment_groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Add other validation rules as needed
        ]);

        EquipmentGroup::create($request->all());

        return redirect()->route('equipment_groups.index')
            ->with('success', 'Equipment Group created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipmentGroup $equipmentGroup)
    {
        return view('equipment_groups.show', compact('equipmentGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EquipmentGroup $equipmentGroup)
    {
        return view('equipment_groups.edit', compact('equipmentGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EquipmentGroup $equipmentGroup)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Add other validation rules as needed
        ]);

        $equipmentGroup->update($request->all());

        return redirect()->route('equipment_groups.index')
            ->with('success', 'Equipment Group updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EquipmentGroup $equipmentGroup)
    {
        $equipmentGroup->delete();

        return redirect()->route('equipment_groups.index')
            ->with('success', 'Equipment Group deleted successfully.');
    }
}
