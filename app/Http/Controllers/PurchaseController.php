<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Purchase;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('Purchase/Index', [
            'purchases' => Auth::user()->currentTeam->purchases()->map(function ($purchase) {
                return $purchase->load('invitations');
            }),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Purchase/Create', [
            'vendors' => Vendor::all(),
            'team' => Auth::user()->currentTeam->load('users'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseRequest $request)
    {
        $purchase = Purchase::create($request->all());
        if ($purchase) {
            foreach ($request->input('user_ids') as $user_id) {
                $purchase->invitations()->create([
                    'user_id' => $user_id,
                ]);
            }

            return redirect()->route('purchase.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
    }
}
