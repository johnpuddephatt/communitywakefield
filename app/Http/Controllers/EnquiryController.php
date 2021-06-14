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
    public static function store($entry, $data)
    {
        $entry->enquiries()->create($data);
        return redirect()
            ->back()
            ->with("message", "Your enquiry has been sent!");
    }
}
