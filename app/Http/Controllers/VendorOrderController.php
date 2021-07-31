<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorOrderController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Order::class, 'order');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Vendor $vendor)
    {
        return inertia('VendorOrder/Index', [
            'vendor' => $vendor,
            'orders' => Auth::user()->currentTeam->orders()->where('vendor_id', $vendor->id)->all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Vendor $vendor)
    {
        return inertia('VendorOrder/Create', compact('vendor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Vendor $vendor)
    {
        if (Order::create(array_merge($request->all(), ['vendor_id' => $vendor->id]))) {
            return redirect()->route('vendor.order.index', $vendor->id)->with('success', 'Order created successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor, Order $order)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor, Order $order)
    {
        return inertia('VendorOrder/Edit', compact('vendor', 'order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor, Order $order)
    {
        if ($order->update(array_merge($request->all(), ['vendor_id' => $vendor->id]))) {
            return redirect()->route('vendor.order.index', $vendor->id)->with('success', 'Order updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor, Order $order)
    {
        if ($order->delete()) {
            return redirect()->route('vendor.order.index', compact('vendor'))->with('success', 'Order deleted successfully');
        }

        return redirect()->route('vendor.order.index', compact('vendor'))->with('error', 'Order not deleted');
    }
}
