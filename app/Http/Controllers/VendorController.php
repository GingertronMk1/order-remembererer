<?php

namespace App\Http\Controllers;

use App\Models\Cuisine;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('Vendor/Index', [
            'vendors' => Vendor::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Vendor/Create', [
            'cuisines' => Cuisine::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Vendor::create($request->all())) {
            return redirect()->route('vendor.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        return inertia('Vendor/Edit', [
            'vendor' => $vendor->load('cuisines'),
            'cuisines' => Cuisine::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        if (
            $vendor->update($request->all())
            && $vendor->cuisines()->sync(array_map(function ($cuisine) { return $cuisine['id']; }, $request->input('cuisines')))) {
            return redirect()->back()->with('success', 'Vendor updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        if ($vendor->delete()) {
            return redirect()->back();
        }
    }
}
