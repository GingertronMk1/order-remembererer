<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendorRequest;
use App\Models\Cuisine;
use App\Models\Vendor;

class VendorController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Vendor::class, 'vendor');
    }

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
    public function store(VendorRequest $request)
    {
        $vendor = Vendor::create($request->all());
        if (
            $vendor
            && $vendor->cuisines()->sync(array_map(function ($cuisine) { return $cuisine['id']; }, $request->input('cuisines')))
        ) {
            return redirect()->route('vendor.index')->with('success', 'Vendor created successfully');
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
    public function update(VendorRequest $request, Vendor $vendor)
    {
        if (
            $vendor->update($request->all())
            && $vendor->cuisines()->sync(array_map(function ($cuisine) { return $cuisine['id']; }, $request->input('cuisines')))
        ) {
            return redirect()->route('vendor.index')->with('success', 'Vendor updated successfully');
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
