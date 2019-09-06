
const port = '9898';
const WSS_URL = 'wss://127.0.0.1:9898/ws'
let ws = null
let setIntervalWesocketPush = null
let sid = '';
let seq_id = 0;

function startWS() {
    ws = new WebSocket('ws://'+location.host+':9898/ws');
    ws.onopen = function (event) {
        console.log('WebSocket opened!');
        Auth();
    };
    ws.onmessage = function (event) {
        console.log('receive message: ');
        console.log(event.data);
        let resp = JSON.parse(event.data);
        if(resp.type=='2'){
            if(resp.header.cmd=='Auth'){
                var resp_data = JSON.parse(resp.data)
                //alert(resp_data);
                if(resp_data.sid){
                    sid = resp_data.sid;
                }
                JoinArea("area-global");
            }
            if(resp.header.cmd=='JoinArea'){
                //alert(resp.data);
            }

        }

        if(resp.type=='4'){
            var  resp_data = resp.data
            console.log(resp_data.data);
            if(resp_data.data.action=="create"){
                $("#btn-create-issue").click();
            }
        }

    };
    ws.onerror = function (error) {
        console.log('Error: ' + error.name + error.number);
    };
    ws.onclose = function () {
        console.log('WebSocket closed!');
    };
}
function Auth(text) {
    sendMessage("1", "Auth",text);
}

function JoinArea(data) {
    sendMessage("1", "JoinArea",data);
}
function sendMessage(type,cmd,text) {

    seq_id++
    var obj = {
        "header": {
            "no_resp": false,
            "cmd": cmd,
            "seq_id": seq_id,
            "sid": sid,
            "token": "",
            "version": "1.0",
            "gzip": true
        },
        "type": type,
        "data": text
    }
    console.log(obj);
    ws.send(obj);
    if (ws !== null && ws.readyState === 3) {
        ws.close()
        startWS() //重连
    } else if (ws.readyState === 1) {
        ws.send(JSON.stringify(obj))
    } else if (ws.readyState === 0) {
        setTimeout(() => {
            ws.send(JSON.stringify(obj))
        }, 3000)
    }
}

window.onbeforeunload = function () {
    ws.onclose = function () {
    };  // 首先关闭 WebSocket
    ws.close()
};

