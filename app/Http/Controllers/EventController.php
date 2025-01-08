<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all(); // Fetch all events
        return view('admin.events.index', compact('events')); // Pass events to the view
    }

    public function create()
    {
        $event = new Event(); // Create a new event instance
        $events = Event::all(); // Get all events for the view, if needed
        return view('admin.events.create', compact('event', 'events')); // Return the create event view
    }

    public function store(Request $request)
    {
        // Validate and store the event
        $request->validate([
            'semester_name' => 'required|string|max:255',
            'event_type' => 'required|string|max:255',
            'event_title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Event::create($request->all()); // Create the event

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function edit($id)
    {
        $event = Event::find($id); // Get the specific event
        $events = Event::all(); // Get all events for the view, if needed
        return view('admin.events.edit', compact('event', 'events')); // Return the edit view
    }

    public function update(Request $request, Event $event)
    {
        // Validate and update the event
        $request->validate([
            'semester_name' => 'required|string|max:255',
            'event_type' => 'required|string|max:255',
            'event_title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $event->update($request->all()); // Update the event

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete(); // Delete the event
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}