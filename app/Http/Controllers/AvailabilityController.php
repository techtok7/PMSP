<?php

namespace App\Http\Controllers;

use App\Http\Requests\Availability\StoreAvailabilityRequest;
use App\Http\Requests\Availability\UpdateAvailabilityRequest;
use App\Models\Availability;
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
        $availabilities = Availability::query();

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
            if ($request->type == 1) {
                $timestamp = strtotime($request->start_date);

                $request->user()->availabilities()->create([
                    'date' => $request->start_date,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'day' => strtolower(date('l', $timestamp)),
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Availability $availability)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAvailabilityRequest $request, Availability $availability)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Availability $availability)
    {
        //
    }
}
