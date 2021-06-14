<?php

namespace App\Traits;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

trait PublishedTrait
{
    public function scopePublished($query)
    {
        return $query->where('status', 'Published');
    }
}
