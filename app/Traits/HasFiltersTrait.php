<?php

namespace App\Traits;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use App\Models\Category;
use App\Models\Suitability;
use App\Models\Team;
use Illuminate\Support\Str;

trait HasFiltersTrait
{
    public static function filters($filter_values)
    {
        $filters = new \stdClass();
        $filters->summary = self::filterSummary($filter_values);
        $filters->options = self::filterOptions($filter_values);

        return $filters;
    }

    private static function filterSummary($filters)
    {
        $filter_summary = new \stdClass();

        foreach ($filters as $filter) {
            if (Request()->input($filter)) {
                $filter_summary->$filter = [
                    "label" =>
                        $filter == "postcode"
                            ? "Near to " . strtoupper(Request()->input($filter, false))
                            : ucwords(
                                str_replace("-", " ", Request()->input($filter, false))
                            ),
                    "reset_url" =>
                        "?" . http_build_query(Request()->except($filter, "page")),
                ];
            }
        }
        return $filter_summary == new \stdClass() ? null : $filter_summary;
    }

    private static function filterOptions($filters)
    {
        $filtersValues = new \stdClass();
        $new_model_class = get_class();
        $new_model = new $new_model_class();

        if ($pos = strrpos($new_model_class, "\\")) {
            $model_name = Str::plural(strtolower(substr($new_model_class, $pos + 1)));
        }

        foreach ($filters as $filter) {
            // $filter_plural = Str::plural($filter);
            if (method_exists($new_model, $filter)) {
                $related_model = get_class($new_model->$filter()->getRelated());
                $filtersValues->$filter = Cache::remember(
                    get_class() . "_index_" . $filter,
                    300,
                    function () use ($model_name, $related_model) {
                        return $related_model
                            ::has($model_name)
                            ->withCount($model_name)
                            ->get();
                    }
                );
            }
        }

        return $filtersValues;
    }

    public function scopePostcodeFilter($query, $postcode)
    {
        if (!$postcode) {
            return $query;
        }

        $client = new Client(["http_errors" => false]);
        $response = $client->request(
            "GET",
            "https://api.postcodes.io/postcodes/" . $postcode
        );

        if ($response->getStatusCode() != 200) {
            redirect("/")
                ->with("postcode_error", "Please enter a full, valid postcode")
                ->send();
        }

        $result = json_decode($response->getBody(), true)["result"];

        return $query
            ->distance($result["latitude"], $result["longitude"])
            ->having("distance", ">", 0)
            ->having("distance", "<", config("system.max_radius"))
            ->orHavingRaw("from_home = 1")
            ->orHavingRaw("address IS NULL")
            ->orderByRaw("-distance DESC");
    }

    public function scopeTeamFilter($query, $organisation)
    {
        if (!$organisation) {
            return $query;
        }

        return $query->whereHas("team", function (Builder $query) use ($organisation) {
            $query->where("slug", $organisation);
        });
    }

    public function scopeCategoryFilter($query, $category)
    {
        if (!$category) {
            return $query;
        }

        return $query->whereHas("categories", function (Builder $query) use ($category) {
            $query->where("slug", $category);
        });
    }

    public function scopeSuitabilityFilter($query, $suitability)
    {
        if (!$suitability) {
            return $query;
        }
        return $query->whereHas("suitabilities", function (Builder $query) use (
            $suitability
        ) {
            $query->where("slug", $suitability);
        });
    }

    public function scopeLocationFilter($query, $location)
    {
        if (!$location) {
            return $query;
        }
        return $query
            ->distance($location->latitude, $location->longitude)
            ->having("distance", ">", 0)
            ->having("distance", "<", $location->radius ?? config("system.max_radius"))
            ->orderBy("distance", "ASC");
    }
}
