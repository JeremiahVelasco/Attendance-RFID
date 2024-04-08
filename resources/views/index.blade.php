@extends('layouts.app')

@section('content')
    <section class="main flex justify-around min-h-screen">
        <div class="left flex flex-col justify-center items-center w-3/5">
            <img src="storage/sample_logo.png" alt="school logo">
            <div class="dateTime text-center divide-y divide-solid divide-slate-200">
                <div id="currentTime" class="text-3xl font-semibold"></div>
                <div id="currentDate" class="text-l font-light"></div>
                <form id="attendanceForm" action="{{ route('log.attendance') }}" method="POST" autocomplete="off">
                    @csrf
                    <input id="rfidInput" class="text-center mt-5" name="rfid" type="text" placeholder="RFID">
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
        <div class="right flex flex-col py-4 px-6 text-center justify-center w-2/5">
            @if ($attendanceLog)
                <p>RFID: {{ $attendanceLog['rfid'] }}</p>
                <p>Type: {{ $attendanceLog['type'] }}</p>
                <p>Created At: {{ $attendanceLog['created_at'] }}</p>
                <p>Name: {{ $attendanceLog['user']['name'] }}</p>
                <p>Role: {{ $attendanceLog['user']['role'] }}</p>
            @else
                {{-- Put Waiting Animation Here --}}
                <iframe src="https://giphy.com/embed/lP4jmO461gq9uLzzYc" width="480" height="312" frameBorder="0"
                    class="giphy-embed" allowFullScreen></iframe>
                <p><a href="https://giphy.com/gifs/moodman-still-waiting-lP4jmO461gq9uLzzYc"></a></p>
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


        // FOR Hidding
        document.addEventListener("DOMContentLoaded", function() {
            var form = document.getElementById("attendanceForm");
            var input = document.getElementById("rfidInput");

            // Show the form initially hidden
            form.style.opacity = 0;

            // Focus on the input field when the page loads
            input.focus();
        });
    </script>
@endsection
