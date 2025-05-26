<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::where('user_id', auth()->id())->get();
        return response()->json($schedules);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'type' => 'required|string|max:255',
        ]);

        $schedule = auth()->user()->schedules()->create($validated);
        return response()->json($schedule, 201);
    }

    public function show(Schedule $schedule)
    {
        $this->authorize('view', $schedule);
        return response()->json($schedule);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $this->authorize('update', $schedule);
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|nullable',
            'start_time' => 'sometimes|date',
            'end_time' => 'sometimes|date|after:start_time|nullable',
            'type' => 'sometimes|string|max:255',
        ]);

        $schedule->update($validated);
        return response()->json($schedule);
    }

    public function destroy(Schedule $schedule)
    {
        $this->authorize('delete', $schedule);
        $schedule->delete();
        return response()->json(null, 204);
    }
}