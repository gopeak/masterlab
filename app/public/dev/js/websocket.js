
const port = '9898';
const WSS_URL = 'wss://127.0.0.1:9898/ws'
let ws = null
let setIntervalWesocketPush = null

function startWS() {
    ws = new WebSocket('ws://'+location.host+':9898/ws');
    ws.onopen = function (event) {
        console.log('WebSocket opened!');
    };
    ws.onmessage = function (event) {
        console.log('receive message: ');
        console.log(event.data);
    };
    ws.onerror = function (error) {
        console.log('Error: ' + error.name + error.number);
    };
    ws.onclose = function () {
        console.log('WebSocket closed!');
    };
}

function sendMessage(type,cmd,text) {

    var obj = {
        "header": {
            "no_resp": false,
            "cmd": cmd,
            "seq_id": 0,
            "sid": "",
            "token": "",
            "version": "1.0",
            "gzip": true
        },
        "type": type,
        "data": {}
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

