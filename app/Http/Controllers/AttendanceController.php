<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttendanceLogResource;
use App\Mail\AdviserNotificationMail;
use App\Mail\AttendanceLogMail;
use App\Mail\ParentNotificationMail;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use function Laravel\Prompts\error;

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

        $attendanceLogResource = new AttendanceLogResource($attendance);
        $transformedAttendanceLog = $attendanceLogResource->toArray($request);

        $studentMail = new AttendanceLogMail($attendance);
        $parentMail = new ParentNotificationMail($attendance);
        $adviserMail = new AdviserNotificationMail($attendance);

        $mailSend = Mail::to('velascojeremiahd@gmail.com', null)->queue($studentMail);
        $parentNotification = Mail::to('velascojeremiahd@gmail.com', null)->queue($parentMail);
        $adviserNotification = Mail::to('velascojeremiahd@gmail.com', null)->queue($adviserMail);

        if (!$attendanceLogResource || !$transformedAttendanceLog || !$mailSend || !$parentNotification || !$adviserNotification) {
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
