<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\Category;
use App\Models\Accessibility;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

use Redirect;

class EventController extends Controller
{

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Event::class);

        return Inertia::render('Events/Index', [
            'events' => \Auth::user()->currentTeam->events()->with('subteam:id,name')->get()
        ]);;

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Event::class);

        return Inertia::render('Events/Form', [
            'categories' => Category::where('type', 'event')->orWhere('type', null)->select('id','title')->get(),
            'accessibilities' => Accessibility::select('id','title')->get(),
            'subteams' => \Auth::user()->currentTeam->subteams()->select('id','name')->get(),
            'team' => \Auth::user()->currentTeam()->select('name','phone','email')->first()
        ]);
    }

    /**
     * @param \App\Http\Requests\EventRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        $this->authorize('create', Event::class);

        $event = Event::create(array_merge($request->validated(), ['created_by' => \Auth::user()->id]));
        $event->categories()->sync($request->categories);
        $event->accessibilities()->sync($request->accessibilities);

        return Redirect::route('event.edit', [
            'event' => $event
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Event $event
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Event $event)
    {
        // return Inertia::render('Events/Form', [
        //     'event' => $event
        // ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Event $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        $event->categories = $event->categories()->allRelatedIds()->toArray();
        $event->accessibilities = $event->accessibilities()->allRelatedIds()->toArray();

        return Inertia::render('Events/Form', [
            'event' => $event,
            'categories' => Category::where('type', 'event')->orWhere('type', null)->select('id','title')->get(),
            'accessibilities' => Accessibility::select('id','title')->get(),
            'subteams' => \Auth::user()->currentTeam->subteams()->select('id','name')->get()
        ]);
    }

    /**
     * @param \App\Http\Requests\EventRequest $request
     * @param \App\Models\Event $event
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, Event $event)
    {
        $this->authorize('update', $event);

        $event->update($request->validated());
        $event->categories()->sync($request->categories);
        $event->accessibilities()->sync($request->accessibilities);
        $event->update(['updated_by' => \Auth::user()->id]);

        return Redirect::route('event.edit', compact('event'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Event $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();
        return Redirect::route('events.show');
    }

    public function destroyAll(Request $request, $event_ids)
    {
        $event_ids_array = explode('-', $event_ids);
        $events_query = Event::whereIn('id', $event_ids_array);

        $events = $events_query->get();

        foreach($events as $event) {
            $this->authorize('delete', $event);
        }

        $events_query->delete();

        return Redirect::route('events.show');
    }
}
