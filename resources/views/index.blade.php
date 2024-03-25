@extends('layouts.app')

@section('content')
    <section class="main grid grid-cols-2 min-h-screen">
        <div class="left flex flex-col justify-center items-center">
            <img src="storage/sample_logo.png" alt="school logo">
            <div class="dateTime text-center divide-y divide-solid divide-slate-200">
                <div id="currentTime" class="text-3xl font-semibold"></div>
                <div id="currentDate" class="text-l font-light"></div>
                <form action="{{ route('log.attendance') }}" method="POST">
                    @csrf
                    <input class="text-center mt-5" name="rfid" type="text" placeholder="RFID">
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
        <div class="right flex flex-col py-4 px-6 text-center justify-center">
            @if ($attendanceLog)
                <p>RFID: {{ $attendanceLog->rfid }}</p>
                <p>Type: {{ $attendanceLog->type }}</p>
                <p>Created At: {{ $attendanceLog->created_at }}</p>
                {{-- <p>User Name: {{ $attendanceLog->user->name }}</p> --}}
                {{-- <p>User Role: {{ $attendanceLog['user']['role'] }}</p> --}}
            @else
                {{-- Put Waiting Animation Here --}}
                <p>No attendance log found.</p>
            @endif

        </div>
    </section>

    <script>
        function updateDateTime() {
            const currentDateElement = document.getElementById('currentDate');
            const currentTimeElement = document.getElementById('currentTime');
            const currentDate = new Date();
            const options = {
                month: 'long',
                day: 'numeric',
                year: 'numeric'
            };
            const formattedDate = currentDate.toLocaleDateString('en-US', options);
            const formattedTime = currentDate.toLocaleTimeString();
            currentDateElement.textContent = `${formattedDate}`;
            currentTimeElement.textContent = `${formattedTime}`;
        }

        // Update date and time every second
        setInterval(updateDateTime, 1000);

        // Initial call to update date and time when the page loads
        updateDateTime();
    </script>
@endsection
