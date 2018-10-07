
//define(["jquery"],function($){
var layerCustom=function(){

    return {
        confirm : function(msg,title,callback){
            var index = layer.confirm(
                msg,
                {
                    icon: 3,
                    title:title?title:"",
                    btn:["确认","取消"],
                    skin:"define-layer",
                    area: ['600px'],
                    yes:function(){
                        if($.isFunction(callback)){
                            callback();
                        }
                    }
                }
            );

            // var msg = ops.msg,
            //     title = ops.title,
            //     btn = ops.btn ? ops.btn : ["确认","取消"],
            //     callback = ops.yes;
            // var index = layer.confirm(
            //     msg,
            //     {
            //         icon: 3,
            //         title:title?title:"",
            //         btn:btn,
            //         skin:"define-layer",
            //         area: ['600px'],
            //         yes:function(){
            //             if($.isFunction(callback)){
            //                 callback();
            //             }
            //             layer.close(index);
            //         }
            //     }
            // );
        },
        alert : function(msg,title,callback){
            var index = layer.alert(msg,{icon: 7, title:title?title:"", skin:"define-layer", area: ['600px']}, function(){
                if(typeof callback == "function"){
                    callback();
                }
                layer.close(index);
            });
        },
        success : function(msg){
            layer.alert(msg,{icon: 1, title:"",btn:false,time:3000, skin:"define-layer", area: ['400px']});
        },
        error : function(msg){
            layer.alert(msg,{icon: 2, title:"",btn:false,time:3000, skin:"define-layer", area: ['400px']});
        },
        box : function(title,msg,btn,yes){
            var index = layer.confirm(
                msg,
                {
                    icon: 3,
                    title:title?title:"",
                    btn:btn,
                    skin:"define-layer",
                    area: ['600px'],
                    yes:function(){
                        if($.isFunction(yes)){
                            yes();
                        }
                        layer.close(index);
                    }
                }
            );

        },
        tips : function(msg,me,ops){
            var self = me;
            if(typeof ops === "object"){
                layer.tips(msg,self,ops);
                return;
            }
            layer.tips(msg,self);
        }
    }
//});
	
}();