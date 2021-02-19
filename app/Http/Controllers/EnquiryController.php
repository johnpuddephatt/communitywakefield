<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnquiryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class EnquiryController extends Controller
{
    /**
     * @param \App\Http\Requests\EnquiryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EnquiryRequest $request)
    {
        Notification::send($enquiry->team, new EnquiryNotification($enquiry));

        $request->session()->flash('Message sent.', $enquiry);

        return redirect()->route('back');
    }
}
