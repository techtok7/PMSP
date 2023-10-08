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
        $userIds = $request->user_ids;

        $minimumDuration = User::query()->whereIn('id', $userIds)->max('minimum_minutes');
        $maximumDuration = User::query()->whereIn('id', $userIds)->min('maximum_minutes');

        return response()->json([
            'minimum_duration' => $minimumDuration,
            'maximum_duration' => $maximumDuration,
        ]);
    }

    public function dates(Request $request)
    {
        $userIds = $request->user_ids;

        $minutes = $request->minutes;

        $dates = Availability::whereIn('user_id', $userIds)->where('slots', 'LIKE', "%-$minutes-%")->get()->groupBy('date')->keys();

        return response()->json([
            'dates' => $dates,
        ]);
    }

    public function times(Request $request)
    {
        $userIds = $request->user_ids;

        $duration = $request->duration;

        $date = $request->date;

        $times = Availability::where('date', $date)->where('slots', 'LIKE', "%-$duration-%");

        foreach ($userIds as $userId) {
            $times->where('user_id', $userId);
        }

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
