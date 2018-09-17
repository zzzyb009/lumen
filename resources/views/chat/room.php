<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <script type="text/javascript">
        if(window.WebSocket){
            var webSocket = new WebSocket("ws://www.lumen.com:9502");
            webSocket.onopen = function (event) {
                //webSocket.send("Hello,WebSocket!");
            };
            webSocket.onmessage = function (event) {
                var content = document.getElementById('content');
                if(event.data instanceof Blob) {
                    var img = document.createElement("img");
                    img.src = window.URL.createObjectURL(event.data);
                    content.appendChild(img);
                }else {
                    content.innerHTML = content.innerHTML.concat('<p style="margin-left:20px;height:20px;line-height:20px;">'+event.data+'</p>');
                }
            };

            var sendMessage = function(){
                var data = document.getElementById('message').value;
                webSocket.send(data);
                document.getElementById('message').value = '';
            }
        }else{
            console.log("您的浏览器不支持WebSocket");
        }
    </script>
</head>
<body>
<div style="width:600px;margin:0 auto;border:1px solid #ccc;">
    <div id="content" style="overflow-y:auto;height:300px;"></div>
    <hr/>
    <div style="height:40px">
        <input type="text" id="message" style="margin-left:10px;height:25px;width:450px;">
        <button onclick="sendMessage()" style="height:28px;width:75px;">发送</button>
    </div>
</div>
</body>
</html>