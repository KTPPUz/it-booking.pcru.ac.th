<?php

namespace App\Http\Controllers;

use App\Models\AssetType;
use Illuminate\Http\Request;

class AssetTypeController extends Controller
{
    public function index()
    {
        $assetTypes = AssetType::all();
        return view('assettype.index', compact('assetTypes'));
    }

    public function create()
    {
        return view('assettype.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required|string|max:50',
            'description' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        AssetType::create($request->all());
        return redirect()->route('assettype.index')->with('success', 'Asset Type created successfully.');
    }

    public function edit($id)
    {
        $assetType = AssetType::findOrFail($id);
        return view('assettype.edit', compact('assetType'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type_name' => 'required|string|max:50',
            'description' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        $assetType = AssetType::findOrFail($id);
        $assetType->update($request->all());
        return redirect()->route('assettype.index')->with('success', 'Asset Type updated successfully.');
    }

    public function destroy($id)
    {
        $assetType = AssetType::findOrFail($id);
        $assetType->delete();
        return redirect()->route('assettype.index')->with('success', 'Asset Type deleted successfully.');
    }
}