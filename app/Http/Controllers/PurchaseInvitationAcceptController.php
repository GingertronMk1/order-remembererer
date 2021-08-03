<?php

namespace App\Http\Controllers;

use App\Models\PurchaseInvitation;
use Illuminate\Http\Request;

class PurchaseInvitationAcceptController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseInvitation $purchase_invitation)
    {
        $message = null;
        if (null !== $purchase_invitation->viewed_at) {
            $message = 'This invitation has already been viewed.';
        } elseif ($purchase_invitation->purchase->expired || $purchase_invitation->purchase->expires_at < now()) {
            $message = 'This invitation has expired.';
        }

        if (null !== $message) {
            return response(['message' => $message], 403);
        }
        $purchase_invitation->viewed_at = now();
        if ($purchase_invitation->save()) {
            return inertia('PurchaseInvitation/Accept', compact('purchase_invitation'));
        }
    }

    public function update(Request $request, PurchaseInvitation $purchase_invitation)
    {
        $purchase_invitation->accepted = $request->all();
        if ($purchase_invitation->save()) {
            return redirect()->route('dashboard');
        }
    }
}
