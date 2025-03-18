<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetGroup;
use App\Models\AssetType;

class AssetGroupController extends Controller
{
    public function index()
    {
        $assetGroups = AssetGroup::all();
        $assettypes = AssetType::all();  
        return view('assetgroup.index', compact('assetGroups' , 'assettypes'));
    }

    public function create()
    {
        return view('assetgroup.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_name' => 'required|string|max:255',
            'asset_type_id' => 'required|integer',
            'group_status' => 'required|boolean',
            'specifications' => 'nullable|string',
        ]);

        AssetGroup::create($request->all());
        return redirect()->route('assetgroup.index')->with('success', 'Asset Group created successfully.');
    }

    public function edit($id)
    {
        $assetGroup = AssetGroup::findOrFail($id);
        return view('assetgroup.edit', compact('assetGroup'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'group_name' => 'required|string|max:255',
            'asset_type_id' => 'required|integer',
            'group_status' => 'required|boolean',
            'specifications' => 'nullable|string',
        ]);

        $assetGroup = AssetGroup::findOrFail($id);
        $assetGroup->update($request->all());
        return redirect()->route('assetgroup.index')->with('success', 'Asset Group updated successfully.');
    }

    public function destroy($id)
    {
        $assetGroup = AssetGroup::findOrFail($id);
        $assetGroup->delete();
        return redirect()->route('assetgroup.index')->with('success', 'Asset Group deleted successfully.');
    }
}