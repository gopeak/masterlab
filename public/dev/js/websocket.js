
const port = '9891';
const WSS_URL = 'ws://www.masterlab.vip:9891/ws'
let ws = null
let setIntervalWesocketPush = null
let sid = '';
let seq_id = 0;

var _is_ai_cmd_create = false;
var _ws_summary = '';

function startWS() {
    // 测试代码
    ws = new WebSocket(WSS_URL);
    ws.onopen = function (event) {
        console.log('WebSocket opened!');
        Auth();
    };
    ws.onmessage = function (event) {
        console.log('receive message: ');
        console.log(event.data);
        let resp = JSON.parse(event.data);

        // 是 req->response的
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
        // 是 server->push的
        if(resp.type=='4'){
            var  resp_data = resp.data
            var  title = resp_data.title;

            if(title.indexOf("创建事项")!=-1){
                _is_ai_cmd_create = true;
                var arr = title.split("创建事项")
                var summary = arr[1];
                if(summary.indexOf("优先级")!=-1){
                    var tmpArr = summary.split("优先级")
                    summary = tmpArr[0];
                }

                $('#master_issue_id').val('');
                if (_cur_project_id != '') {
                    var issue_types = [];
                    _cur_form_project_id = _cur_project_id;
                    for (key in _project_issue_types) {
                        issue_types.push(_project_issue_types[key]);
                    }
                    IssueMain.prototype.initCreateIssueType(_project_issue_types, true);
                } else {
                    _cur_form_project_id = "";
                }
                _ws_summary = summary
                //$('.assign-to-me-link ').click();
                $('#modal-create-issue').modal('show');

            }

            if(title.indexOf("关闭页面")!=-1){
                $('#modal-create-issue').modal('hide');
            }

            if(title.indexOf("保存提交")!=-1){
                $('#modal-create-issue').modal('hide');
                IssueMain.prototype.add();
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

