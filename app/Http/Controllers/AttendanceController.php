<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttendanceLogResource;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Attendance::exists()) 
        {
            return view('index', ['attendanceLog' => null]);
        }
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
    
        $type = Attendance::TIME_IN; // Default type is TIME IN
    
        if ($latestLog) {
            $currentTime = Carbon::now();
            $fiveMinutesAgo = $currentTime->subMinutes(1); // Put 1 for Testing and 5 for Prod
    
            if ($latestLog->created_at->lte($fiveMinutesAgo)) {
                $type = Attendance::TIME_OUT; // Set type to TIME OUT if conditions are met
            } elseif ($latestLog->type === Attendance::TIME_OUT) {
                $type = Attendance::TIME_IN;
            }
        }
    
        // Create new Attendance entry
        $attendance = new Attendance();
        $attendance->rfid = $validated['rfid'];
        $attendance->type = $type;
        $attendance->save();

        $incrementAttendance = $this->incrementAttendance($request);
        $attendanceLogResource = new AttendanceLogResource($attendance);
        $transformedAttendanceLog = $attendanceLogResource->toArray($request);

        if (!$attendanceLogResource || !$transformedAttendanceLog) {
            return 'ERROR';
        }

        // Pass the formatted data to the view
        return response()->view('index', ['attendanceLog' => $transformedAttendanceLog]);        
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
    public function update(string $id)
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

    private function incrementAttendance($rfid)
    {
        // Find the user by RFID
        $user = User::where('rfid', $rfid)->first();

        // Check if the user exists
        if (!$user) {
            return 'User not found'; // or handle the case appropriately
        }

        // Increment attendance
        $increment = ++$user->attendance;
        $user->save();

        Log::info("User attendance incremented: {$user->name} (RFID: $rfid)");

        return response()->json($user);
    }
}