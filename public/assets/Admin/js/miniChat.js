if(window.WebSocket){
    var swoole_host = $('#swoole_host').val();
    var swoole_port = $('#swoole_port').val();
    var token = $('#token').val();
    var webSocket = new WebSocket("ws://"+swoole_host+":"+swoole_port);
    //var token = document.getElementById('token').value;
    var user_id = 0;
    webSocket.onopen = function (event,$req) {
        var data = {'type':'connect','token':token,'user_id':user_id,'room_id':1188};
        webSocket.send(JSON.stringify(data));
    };
    webSocket.onmessage = function (event) {
        var content = document.getElementById('miniChat_content');
        var data = JSON.parse(event.data);
        var html;
        switch (data.type)
        {
            case 'message':
                html = '<div class="left"><div class="author-name">'+data.user.nickname+'<small class="chat-date">'+data.time+'</small></div><div class="chat-message active">'+data.message+'</div></div></p>'
                break;
            case 'join':
                html = '<div class="center">'+data.user.nickname+'加入了房间</div>';
                break;
            case 'leave':
                html = '<div class="center">'+data.user.nickname+'离开了房间</div>';
                break;
        }
        content.innerHTML = content.innerHTML.concat(html);
    }

    var sendMessage = function(){
        var message = document.getElementById('minichat_message').value;
        var data = {'type':'message','message':message,'token':token,'user_id':user_id,'room_id':1188};
        webSocket.send(JSON.stringify(data));
        $('.minichat_message').val('');
    }
}else{
    console.log("您的浏览器不支持WebSocket");
}