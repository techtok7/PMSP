<?php

namespace App\Http\Controllers;

use App\Http\Requests\Availability\StoreAvailabilityRequest;
use App\Http\Requests\Availability\UpdateAvailabilityRequest;
use App\Models\Availability;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('modules.availabilities.index');
    }

    public function datatable()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $availabilities = Availability::where('user_id', $user->id);

        $availabilities->with('availabilityBatch');

        $availabilities->orderBy('date', 'asc')->orderBy('start_time', 'asc');

        return DataTables::of($availabilities)->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAvailabilityRequest $request)
    {
        try {
            if ($request->end_time == '00:00') {
                return redirect()->route('availabilities.index')->with('error', 'Your ending time must be minimum 00:30');
            }
            if($request->start_time == $request->end_time) {
                return redirect()->route('availabilities.index')->with('error', 'You can not select same start time and end time');
            }
            if ($request->type == 1) {
                $timestamp = strtotime($request->start_date);

                $request->user()->availabilities()->create([
                    'date' => $request->start_date,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'day' => strtolower(date('l', $timestamp)),
                    'slots' => Availability::getAvailableSlots($request),
                ]);

                return redirect()->route('availabilities.index')->with('success', 'Availability created successfully.');
            } else {
                $days = [];

                foreach ($request->days as $value) {
                    $days[$value] = true;
                }

                $availabilityBatche = $request->user()->availabilityBatches()->create([
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'days' => json_encode($days),
                ]);

                $start = strtotime($request->start_date);
                $end = strtotime($request->end_date);

                while ($start <= $end) {

                    $day = strtolower(date('l', $start));
                    if (!isset($days[$day])) {
                        $start = strtotime("+1 day", $start);
                        continue;
                    }

                    $availabilityBatche->availabilities()->create([
                        'user_id' => $request->user()->id,
                        'date' => date('Y-m-d', $start),
                        'start_time' => $request->start_time,
                        'end_time' => $request->end_time,
                        'day' => strtolower(date('l', $start)),
                        'slots' => Availability::getAvailableSlots($request),
                    ]);

                    $start = strtotime("+1 day", $start);
                }

                return redirect()->route('availabilities.index')->with('success', 'Availability batch created successfully.');
            }
        } catch (\Throwable $th) {
            Log::error('AvailabilityController - store: ' . $th->getMessage());
            return redirect()->route('availabilities.index')->with('error', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Availability $availability)
    {
        return view('modules.availabilities.show', compact('availability'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Availability $availability)
    {
        return view('modules.availabilities.index', compact('availability'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAvailabilityRequest $request, Availability $availability)
    {
        try {
            if ($request->end_time == '00:00') {
                return redirect()->back()->with('error', 'Your ending time must be minimum 00:30');
            }
            if($request->start_time == $request->end_time) {
                return redirect()->back()->with('error', 'You can not select same start time and end time');
            }
            $availability->update($request->validated());

            if ($availability->availabilityBatch != null) {
                $availability->availabilityBatch->update([
                    'is_dirty' => true,
                ]);
            }

            return redirect()->route('availabilities.index')->with('success', 'Availability updated successfully.');
        } catch (\Throwable $th) {
            Log::error('AvailabilityController - update: ' . $th->getMessage());
            return redirect()->route('availabilities.index')->with('error', 'Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Availability $availability)
    {
        $availability->delete();

        return redirect()->route('availabilities.index')->with('success', 'Availability deleted successfully.');
    }
}
