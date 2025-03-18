<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetLocation;
use App\Models\Room;
use App\Models\Department;
use App\Models\Sect;
use App\Models\Asset;

class AssetLocationController extends Controller
{
    public function index()
    {
        $assetLocations = AssetLocation::all();
        $rooms = Room::all();
        $assets = Asset::all();
        $departments = Department::all();
        $sects = Sect::all();
        
        // $bookings = Booking::with(['user', 'department', 'sect'])
        //     ->where('user_id', auth()->user()->id)
        //     ->get();
            
        return view('assetlocation.index', compact('assetLocations' , 'rooms', 'assets' , 'departments' , 'sects' ));
    }

    public function store(Request $request)
    {
        //  dd($request->all());
        $request->validate([
            'asset_id' => 'required|integer|exists:asset,asset_id',
            'room_id' => 'nullable|integer|exists:room,room_id',
            'department_id' => 'nullable|integer|exists:department,department_id',
            'sect_id' => 'nullable|integer|exists:sect,sect_id',
            'location_type' => 'required|string',
            'is_current' => 'required|integer',
            // 'moved_at' => 'required|datetime',
        ]);

        // AssetLocation::create($request->all());
        AssetLocation::create([
            'asset_id' => $request->asset_id,
            'room_id' => $request->room_id,
            'department_id' => $request->department_id,
            'sect_id' => $request->sect_id,
            'location_type' => $request->location_type,
            'is_current' => $request->is_current,
        ]);
        return redirect()->route('assetlocation.index')->with('success', 'Asset Location created successfully.');
    }

    public function update(Request $request, $id)
    {
       $request->validate([
            'asset_id' => 'required|integer|exists:asset,asset_id',
            'room_id' => 'nullable|integer|exists:room,room_id',
            'department_id' => 'nullable|integer|exists:department,department_id',
            'sect_id' => 'nullable|integer|exists:sect,sect_id',
            'location_type' => 'required|string',
            'is_current' => 'required|integer',
            'moved_at' => 'required|datetime',
        ]);

        $assetLocation = AssetLocation::findOrFail($id);
        $assetLocation->update($request->all());
        return redirect()->route('assetlocation.index')->with('success', 'Asset Location updated successfully.');
    }

    public function destroy($id)
    {
        $assetLocation = AssetLocation::findOrFail($id);
        $assetLocation->delete();
        return redirect()->route('assetlocation.index')->with('success', 'Asset Location deleted successfully.');
    }


    public function getSects($department_code)
    {
        $sects = Sect::where('department_code', $department_code)->get();

        return response()->json($sects);
    }
}