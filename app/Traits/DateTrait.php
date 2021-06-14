<?php

namespace App\Traits;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;

trait DateTrait {

    public function is_new() {
      $created_at = new Carbon($this->created_at);
      $days_since_creation = $created_at->diffInDays(Carbon::now());
      return ($days_since_creation < config('system.max_days_for_new')) ? true : false;
    }

    public function expires_in() {
      $validated_at = new Carbon($this->validated_at);
      $remaining = config('system.opportunity_valid_for') - $validated_at->diffInDays($now);
      return ($remaining > 0) ? $remaining : false;
    }

    public function date_range() {
      if($this->start_date && ($this->start_date == $this->end_date)) {
        return date("D jS M Y", strtotime($this->start_date));
      }
      elseif($this->start_date && $this->end_date) {
        return date("D jS M", strtotime($this->start_date)) . ' – ' . date("D jS M", strtotime($this->end_date));
      }
      elseif($this->start_date) {
        return 'From ' . date("D jS M Y", strtotime($this->start_date));
      }
      else {
        return 'Flexible';
      }
    }
}
