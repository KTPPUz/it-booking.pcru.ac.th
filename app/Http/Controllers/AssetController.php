<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\AssetGroup;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::all();
        $assetgroups = AssetGroup::all();
        return view('asset.index', compact('assets' , 'assetgroups'));
    }

    public function create()
    {
        return view('asset.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_id' => 'required|integer',
            'asset_ac_id' => 'required|string|max:50',
            'asset_status' => 'required|boolean',
            'asset_note' => 'nullable|string|max:255',
        ]);

        Asset::create($request->all());
        return redirect()->route('assets.index')->with('success', 'Asset created successfully.');
    }

    public function edit($id)
    {
        $asset = Asset::findOrFail($id);
        return view('asset.edit', compact('asset'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'group_id' => 'required|integer',
            'asset_ac_id' => 'required|string|max:50',
            'asset_status' => 'required|boolean',
            'asset_note' => 'nullable|string|max:255',
        ]);

        $asset = Asset::findOrFail($id);
        $asset->update($request->all());
        return redirect()->route('assets.index')->with('success', 'Asset updated successfully.');
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Asset deleted successfully.');
    }
}