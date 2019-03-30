@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-header">
                    Friends
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($users as $user)
                            <div class="col-md-12">
                                <a href="{{url("home/?user=" . $user->id)}}">
                                    <h5 class="p-3 {{ isset($selectedUser->id) ? $selectedUser->id == $user->id ? 'chat-active' : '' : ''}}">{{$user->name}}</h5>
                                </a>
                                <hr />
                            </div>
                        @endforeach
                        <div class="col-md-12 text-right">
                            <small>{{count($users)}} friends</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Chat Dashboard</div>

                <div class="card-body" id="body">
                    {{-- <h4 id="receiver"></h4>
                    <h6 id="sender"></h6>
                    <i><p id="message"></p></i> --}}
                    <div class="row">
                        <div class="col-md-12">
                            Current chat with: 
                            @isset($selectedUser)
                                <h5>{{$selectedUser->name}}</h5>
                            @endisset
                            <hr>
                        </div>
                    </div>
                    <div class="row m-2" style="background-color: #bbdefb; border-radius: 15px">
                        @isset($chats)
                            @foreach ($chats as $chat)
                                @if ($chat->User->id == Auth::user()->id)
                                    @include('chat.send_chat')
                                @else
                                    @include('chat.receive_chat')
                                @endif
                            @endforeach
                        @endisset
                    </div>

                    @isset($selectedUser)
                        <form action="{{route('chat.store')}}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                            <input type="hidden" name="receiver_id" value="{{$selectedUser->id}}">
                            <div class="row">
                                <hr>
                                <div class="col-md-10">
                                {{-- <input class="form-control" type="text" name="message" placeholder="Type your message here"> --}}
                                <textarea class="form-control" name="message" placeholder="Type your message here"></textarea>
                            </div>
                            <div class="col-md-2 mt-3">
                                <button class="btn btn-primary" type="submit" style="width: 100%; height: 100%">Send</button>
                            </div>
                            </div>
                        </form>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script>
        
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('9ec467eb1488e7fb71b5', {
        cluster: 'ap1',
        forceTLS: true
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('chat-sent.'+{!! Auth::user()->id !!}, function(data) {
            // console.log('Receiver_id '+data.chat.user_id);
            swal('Info', 'You got new message', 'info').then(() => window.location = "/home?user="+data.chat.user_id);
        // document.getElementById("sender").innerHTML = "From : "+data.chat.user.name;
        // document.getElementById("receiver").innerHTML = data.chat.receiver.name;
        // document.getElementById("message").innerHTML = data.chat.message + "<hr />";
        });
    </script>
@endpush