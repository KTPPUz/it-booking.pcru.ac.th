<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid" style="margin-left:3.1%">
        @if (Auth::guard('staff')->check())
                <a class="navbar-brand" href="{{ route('staff.homestaff') }}">
                    IT-BOOKING 
                </a>
                @elseif (Auth::guard('web')->check())
                <a class="navbar-brand" href="{{ url('/') }}">
                    IT-BOOKING
                </a>
                @else
                <a class="navbar-brand" href="{{ url('/') }}">
                    IT-BOOKING 
                </a>
        @endif
        {{-- <a class="navbar-brand" href="{{ route('bookings') }}" style="color:white;font-size:30px;" >IT-Booking</a> --}}
<hr>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
  
            <ul class="navbar-nav">
               
            </ul>
        </div>
    </div>
</nav>
