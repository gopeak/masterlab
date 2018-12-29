jsPlumb.ready(function () {

    // setup some defaults for jsPlumb.
    var instance = jsPlumb.getInstance({
        Endpoint: ["Dot", {radius: 2}],
        Connector:"StateMachine",
        HoverPaintStyle: {stroke: "#1e8151", strokeWidth: 2 },
        ConnectionOverlays: [
            [ "Arrow", {
                location: 1,
                id: "arrow",
                length: 14,
                foldback: 0.8
            } ],
            [ "Label", { label: "FOO", id: "label", cssClass: "aLabel" }]
        ],
        Container: "canvas"
    });

    instance.registerConnectionType("basic", { anchor:"Continuous", connector:"StateMachine" });

    window.jsp = instance;

    var canvas = document.getElementById("canvas");
    var windows = jsPlumb.getSelector(".statemachine-demo .w");

    // bind a click listener to each connection; the connection is deleted. you could of course
    // just do this: instance.bind("click", instance.deleteConnection), but I wanted to make it clear what was
    // happening.
    instance.bind("dblclick", function (c) {
        instance.deleteConnection(c);
    });

    // bind a connection listener. note that the parameter passed to this function contains more than
    // just the new connection - see the documentation for a full list of what is included in 'info'.
    // this listener sets the connection's internal
    // id as the label overlay's text.
    instance.bind("connection", function (info) {
        info.connection.getOverlay("label").setLabel(info.connection.id);
    });

    // bind a double click listener to "canvas"; add new node when this occurs.
    jsPlumb.on(canvas, "dblclick", function(e) {

        var connections = [];
        $.each(instance.getConnections(), function (idx, connection) {
            connections.push(
                {
                    id:connection.id,
                    sourceId: connection.sourceId,
                    targetId: connection.targetId
                }
            );
        });

        var _blocks = []
        $("#canvas .w").each(function (idx, elem) {
            var $elem = $(elem);
            _blocks.push({
                id: $elem.attr('id'),
                positionX: parseInt($elem.css("left"), 10),
                positionY: parseInt($elem.css("top"), 10),
                innerHTML:$elem.html(),
                innerText:$elem.text(),

            });
        });
        var canvas_data = {
            blocks:_blocks,
            connections:connections
        };
        var serializedData = JSON.stringify(canvas_data);
        $('#text').text(serializedData);
        console.log( canvas_data );
    });

    //
    // initialise element as connection targets and source.
    //
    var initNode = function(el) {

        // initialise draggable elements.
        instance.draggable(el);

        instance.makeSource(el, {
            filter: ".ep",
            anchor: "Continuous",
            connectorStyle: { stroke: "#5c96bc", strokeWidth: 2, outlineStroke: "transparent", outlineWidth: 4 },
            connectionType:"basic",
            extract:{
                "action":"the-action"
            },
            maxConnections: 2,
            onMaxConnections: function (info, e) {
                alert("Maximum connections (" + info.maxConnections + ") reached");
            }
        });

        instance.makeTarget(el, {
            dropOptions: { hoverClass: "dragHover" },
            anchor: "Continuous",
            allowLoopback: true
        });

        // this is not part of the core demo functionality; it is a means for the Toolkit edition's wrapped
        // version of this demo to find out about new nodes being added.
        //
        instance.fire("jsPlumbDemoNodeAdded", el);
    };

    var createWorkflowNode = function(blcok) {
        var d = document.createElement("div");
        var id = blcok.id;
        d.className = "w";
        d.id = id;
        d.innerHTML = blcok.innerHTML;
        d.style.left = blcok.positionX + "px";
        d.style.top = blcok.positionY + "px";
        instance.getContainer().appendChild(d);
        initNode(d);
        return d;
    };

    // suspend drawing and initialise.
    instance.batch(function () {

        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: './init.json',
            data: {format:'json'} ,
            success: function (resp) {

                for (var i = 0; i < resp.blocks.length; i++) {
                    createWorkflowNode(resp.blocks[i]);
                }
                for (var i = 0; i < resp.connections.length; i++) {
                    var cc = resp.connections[i];
                    instance.connect({ source: cc.sourceId, target: cc.targetId, type:"basic" });

                }
                jsPlumb.fire("jsPlumbDemoLoaded", instance);

            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    });




});

