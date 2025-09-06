<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Yajra\DataTables\DataTables;

class VehicleController extends Controller
{
    public function index()
    {
        return view('vehicles.index');
    }

    public function getData()
    {
        $vehicles = Vehicle::select(['id', 'model', 'brand', 'year', 'created_at']);

        return DataTables::of($vehicles)
            ->addColumn('action', function ($vehicle) {
                return '<a href="' . route('vehicles.edit', $vehicle->id) . '" class="btn btn-warning">Edit</a>';
            })
            ->make(true);
    }

    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('index', compact('vehicle'));
    }
}
