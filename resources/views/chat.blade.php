@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Chat</div>
                <div class="card-body">
                    <h6 id="sender"></h6>
                    <i><p id="message"></p></i>
                    <hr>
                    <form action="{{route('chat.store')}}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <div class="form-group">
                            <label for="">To</label>
                            <select class="form-control" name="receiver_id" required>
                                <option value="" disabled selected>Choose friend</option>
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Message</label>
                            <textarea name="message" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" style="width: 100%">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = false;

        var pusher = new Pusher('9ec467eb1488e7fb71b5', {
        cluster: 'ap1',
        forceTLS: true
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('chat-sent.'+{!! Auth::user()->id !!}, function(data) {
        // alert('You got message');
        swal('You got message');
        document.getElementById("sender").innerHTML = "From : "+data.chat.user.name;
        document.getElementById("message").innerHTML = data.chat.message;
        });
    </script>
@endpush