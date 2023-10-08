<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMeetingRequest;
use App\Http\Requests\UpdateMeetingRequest;
use App\Models\Availability;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()->where('id', '!=', auth()->id())->get();

        return view('modules.meetings.index', compact('users'));
    }

    public function duration(Request $request)
    {
        $userId = $request->user_id;

        $user = User::find($userId);

        $minimumDuration = $user->minimum_minutes;
        $maximumDuration = $user->maximum_minutes;

        return response()->json([
            'minimum_duration' => $minimumDuration,
            'maximum_duration' => $maximumDuration,
        ]);
    }

    public function dates(Request $request)
    {
        $userId = $request->user_id;

        $minutes = $request->minutes;

        $dates = Availability::where('user_id', $userId)->where('slots', 'LIKE', "%-$minutes-%")->get()->groupBy('date')->keys();

        return response()->json([
            'dates' => $dates,
        ]);
    }

    public function times(Request $request)
    {
        $userId = $request->user_id;

        $duration = $request->duration;

        $date = $request->date;

        $times = Availability::where('user_id', $userId)->where('date', $date)->where('slots', 'LIKE', "%-$duration-%");

        return response()->json([
            'times' => $times,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMeetingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Meeting $meeting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meeting $meeting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMeetingRequest $request, Meeting $meeting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meeting $meeting)
    {
        //
    }
}
