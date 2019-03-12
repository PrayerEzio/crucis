<!--mini聊天窗口开始-->
<div class="small-chat-box fadeInRight animated">
    <div class="heading" draggable="true">
        <small class="chat-date pull-right">
        </small>
        Crucis聊天频道
    </div>
    <div class="content" id="miniChat_content">
        <input type="hidden" id="swoole_host" value="{{ env('SWOOLE_HTTP_HOST') }}">
        <input type="hidden" id="swoole_port" value="{{ env('SWOOLE_HTTP_PORT') }}">
        <input type="hidden" id="token" value="{{ csrf_token() }}">
        {{--@foreach($message_list as $message)
            @if($message['admin_id'] == session('admin_info.id'))
                <div class="right">
            @else
                <div class="left">
            @endif
            <div class="author-name">{{ $message['nickname'] }}<small class="chat-date"></small></div><div class="chat-message active">{{ $message['content'] }}</div> </div>
        @endforeach--}}
    </div>
    <div class="form-chat">
        <div class="input-group input-group-sm">
            <textarea id="minichat_message" class="form-control"></textarea>
            <span class="input-group-btn">
                <button class="btn btn-primary" onclick="sendMessage()" type="button">发送</button>
            </span>
        </div>
    </div>
</div>
    <div id="small-chat">
    <span class="badge badge-warning pull-right" id="no_read_minichat_message_num">5</span>
    <a class="open-small-chat">
        <i class="fa fa-comments"></i>
    </a>
</div>
</div>
<script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/jquery.min.js"></script>
<script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/miniChat.js"></script>