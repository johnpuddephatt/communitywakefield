<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationEmailController extends Controller
{
    public function update(Request $request)
    {
        \Auth::user()->update([
            "notification_emails" => $request->notification_emails,
        ]);
        return redirect()->back();
    }
}
