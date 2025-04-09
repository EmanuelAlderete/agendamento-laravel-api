<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "price" => "required|numeric|min:0",
            "duration_minutes" => "required|integer|min:1",
        ]);

        $service = Service::create([
            "professional_id" => $request->user()->id,
            "name" => $request->name,
            "price" => $request->price,
            "duration_minutes" => $request->duration_minutes,
        ]);

        return response()->json([
            "data" => $service,
            "message" => "Service created successfully",
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        //
    }
}
