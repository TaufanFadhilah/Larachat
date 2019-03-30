<div class="col-md-8 offset-md-4 my-3 text-right">
    <h5>{{$chat->User->name}}</h5>
    <small>{{$chat->created_at->format('D, d M y')}}</small>
    <br>
    <i>{{$chat->message}}</i>
</div>