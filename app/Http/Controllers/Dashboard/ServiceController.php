<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use App\Models\Category;
use App\Models\Accessibility;
use App\Models\Suitability;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

use Redirect;

class ServiceController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize("viewAny", Service::class);

        return Inertia::render("Services/Index", [
            "services" => \Auth::user()
                ->currentTeam->services()
                ->with("subteam:id,name")
                ->get(),
            "permissions" => [
                "canDeleteTeamEntries" => Gate::check(
                    "delete",
                    \Auth::user()->currentTeam
                ),
            ],
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize("create", Service::class);

        return Inertia::render("Services/Form", [
            "service" => isset($request->existing_data) ? $request->existing_data : null,
            "categories" => Category::where("type", "service")
                ->orWhere("type", null)
                ->orderBy("title")
                ->select("id", "title")
                ->get(),
            "accessibilities" => Accessibility::orderBy("title")
                ->select("id", "title")
                ->get(),
            "suitabilities" => Suitability::where("type", "service")
                ->orWhere("type", null)
                ->orderBy("title")
                ->select("id", "title")
                ->get(),
            "subteams" => \Auth::user()
                ->currentTeam->subteams()
                ->select("id", "name")
                ->get(),
            "team" => \Auth::user()
                ->currentTeam()
                ->select("name", "phone", "email")
                ->first(),
        ]);
    }

    /**
     * @param \App\Http\Requests\ServiceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        $this->authorize("create", Service::class);

        $service = Service::create(
            array_merge($request->validated(), ["created_by" => \Auth::user()->id])
        );
        $service->categories()->sync($request->categories);
        $service->accessibilities()->sync($request->accessibilities);
        $service->suitabilities()->sync($request->suitabilities);

        return Redirect::route("service.edit", [
            "service" => $service,
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Service $service)
    {
        // return Inertia::render('Services/Form', [
        //     'service' => $service
        // ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function clone(Service $service)
    {
        $this->authorize("create", $service);

        $service->id = null;
        $service->created_by = null;
        $service->updated_by = null;
        $service->display_until = null;
        $service->created_at = null;
        $service->updated_at = null;

        $service->categories = $service
            ->categories()
            ->allRelatedIds()
            ->toArray();
        $service->accessibilities = $service
            ->accessibilities()
            ->allRelatedIds()
            ->toArray();
        $service->suitabilities = $service
            ->suitabilities()
            ->allRelatedIds()
            ->toArray();

        return Inertia::render("Services/Form", [
            "service" => $service,
            "categories" => Category::where("type", "service")
                ->orWhere("type", null)
                ->orderBy("title")
                ->select("id", "title")
                ->get(),
            "accessibilities" => Accessibility::orderBy("title")
                ->select("id", "title")
                ->get(),
            "suitabilities" => Suitability::where("type", "service")
                ->orWhere("type", null)
                ->orderBy("title")
                ->select("id", "title")
                ->get(),
            "subteams" => \Auth::user()
                ->currentTeam->subteams()
                ->select("id", "name")
                ->get(),
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $this->authorize("update", $service);

        $service->categories = $service
            ->categories()
            ->allRelatedIds()
            ->toArray();
        $service->accessibilities = $service
            ->accessibilities()
            ->allRelatedIds()
            ->toArray();
        $service->suitabilities = $service
            ->suitabilities()
            ->allRelatedIds()
            ->toArray();

        return Inertia::render("Services/Form", [
            "service" => $service,
            "categories" => Category::where("type", "service")
                ->orWhere("type", null)
                ->orderBy("title")
                ->select("id", "title")
                ->get(),
            "accessibilities" => Accessibility::orderBy("title")
                ->select("id", "title")
                ->get(),
            "suitabilities" => Suitability::where("type", "service")
                ->orWhere("type", null)
                ->orderBy("title")
                ->select("id", "title")
                ->get(),
            "subteams" => \Auth::user()
                ->currentTeam->subteams()
                ->select("id", "name")
                ->get(),
        ]);
    }

    /**
     * @param \App\Http\Requests\ServiceRequest $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, Service $service)
    {
        $this->authorize("update", $service);

        $service->update($request->validated());
        $service->categories()->sync($request->categories);
        $service->accessibilities()->sync($request->accessibilities);
        $service->suitabilities()->sync($request->suitabilities);
        $service->update(["updated_by" => \Auth::user()->id]);

        return Redirect::route("service.edit", compact("service"));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Service $service)
    {
        $this->authorize("delete", $service);

        $service->delete();
        return Redirect::route("services.show");
    }

    public function destroyAll(Request $request, $service_ids)
    {
        $service_ids_array = explode("-", $service_ids);
        $services_query = Service::whereIn("id", $service_ids_array);

        $services = $services_query->get();

        foreach ($services as $service) {
            $this->authorize("delete", $service);
        }

        $services_query->delete();

        return Redirect::route("services.show");
    }
}
