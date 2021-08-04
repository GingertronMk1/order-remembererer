<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\DatabaseNotification $notification
     *
     * @return \Illuminate\Http\Response
     */
    public function show(DatabaseNotification $notification)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\DatabaseNotification $notification
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(DatabaseNotification $notification)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\DatabaseNotification $notification
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DatabaseNotification $notification)
    {
        return $notification->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\DatabaseNotification $notification
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(DatabaseNotification $notification)
    {
    }
}
