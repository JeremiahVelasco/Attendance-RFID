<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rfid' => 'required',
        ]);
    
        // Check if there is a log in the Attendance table for the current date and at least 5 minutes apart
        $latestLog = Attendance::where('rfid', $validated['rfid'])
            ->latest('created_at')
            ->first();
    
        $type = 1; // Default type is TIME IN
    
        if ($latestLog) {
            $currentTime = Carbon::now();
            $fiveMinutesAgo = $currentTime->subMinutes(1);
    
            if ($latestLog->created_at->lte($fiveMinutesAgo)) {
                $type = 2; // Set type to TIME OUT if conditions are met
            } elseif ($latestLog->type === 2) {
                $type = 1; // Set type to TIME IN if latest log is TIME OUT
            }
        }
    
        // Create new Attendance entry
        $attendance = new Attendance();
        $attendance->rfid = $validated['rfid'];
        $attendance->type = $type;
        $attendance->save();
    
        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
