
$(function(){

    // 计算用时(天)
    var due_date_laydate = laydate.render({
        elem: '#gantt_due_date'
        ,format: 'yyyy-MM-dd'
        ,mark: {
            '0-11-08': '生日'
            ,'0-12-31': '跨年' //每年12月31日
            ,'0-1-1': '元旦' //每年1月1日
            ,'0-5-1': '劳动节' //每年5月1日
            ,'0-10-1': '国庆日' //每年10月1日
            ,'0-0-10': '工资' //每个月10号
            ,'2017-8-20': '预发' //如果为空字符，则默认显示数字+徽章
            ,'2017-8-21': '发布'
        }
        ,done: function(value, date){
            computeDuration();
        }
    });
    var start_date_laydate = laydate.render({
        elem: '#gantt_start_date'
        ,format: 'yyyy-MM-dd'
        ,mark: {
            '0-11-08': '生日'
            ,'0-12-31': '跨年' //每年12月31日
            ,'0-1-1': '元旦' //每年1月1日
            ,'0-5-1': '劳动节' //每年5月1日
            ,'0-10-1': '国庆日' //每年10月1日
            ,'0-0-10': '工资' //每个月10号
            ,'2017-8-20': '预发' //如果为空字符，则默认显示数字+徽章
            ,'2017-8-21': '发布'
        }
        ,done: function(value, date){
            computeDuration();
        }
    });

    function computeDuration(){
        let project_id = window._cur_project_id;
        let start_date = $('#gantt_start_date').val();
        let due_date = $('#gantt_due_date').val();
        if(start_date!='' && due_date!=''){
            var url = '/issue/main/getDuration/?project'+project_id;
            $.ajax({
                type: 'GET',
                dataType: "json",
                data: {project_id:project_id, start_date:start_date, due_date:due_date },
                url: url,
                success: function (resp) {
                    auth_check(resp);
                    if(resp.ret==="200"){
                        $('#gantt_duration').val(resp.data);
                        $('#edit_duration').html(resp.data);
                    }else{
                        notify_error(resp.msg , resp.data);
                    }
                },
                error: function (res) {
                    notify_error("请求数据错误" + res);
                }
            });
        }
    }


    var holiday_laydate = laydate.render({
        elem: '#holiday_laydate'
        ,format: 'yyyy-MM-dd'
        ,mark: {
            '0-11-08': '生日'
            ,'0-12-31': '跨年' //每年12月31日
            ,'0-1-1': '元旦' //每年1月1日
            ,'0-5-1': '劳动节' //每年5月1日
            ,'0-10-1': '国庆日' //每年10月1日
            ,'0-0-10': '工资' //每个月10号
            ,'2017-8-20': '预发' //如果为空字符，则默认显示数字+徽章
            ,'2017-8-21': '发布'
        }
        ,done: function(value, date){
            let dateArr = JSON.parse($('#holiday_dates').val());
            if(isInArray(dateArr,value)){
                return;
            }
            dateArr.push(value);
            let source = $('#tpl_holiday_a').html();
            let template = Handlebars.compile(source);
            let data  = {holidays:dateArr}
            let result = template(data);
            $('#holidays_list' ).html(result);
            $('#holiday_dates').val(JSON.stringify(dateArr));
            Gantt.prototype.bindRemoveHolidayDate();
        }
    });
    var extra_holiday_laydate = laydate.render({
        elem: '#extra_holiday_laydate'
        ,format: 'yyyy-MM-dd'
        ,mark: {
            '0-11-08': '生日'
            ,'0-12-31': '跨年' //每年12月31日
            ,'0-1-1': '元旦' //每年1月1日
            ,'0-5-1': '劳动节' //每年5月1日
            ,'0-10-1': '国庆日' //每年10月1日
            ,'0-0-10': '工资' //每个月10号
            ,'2017-8-20': '预发' //如果为空字符，则默认显示数字+徽章
            ,'2017-8-21': '发布'
        }
        ,done: function(value, date){
            let dateArr = JSON.parse($('#extra_holiday_dates').val());
            if(isInArray(dateArr,value)){
                return;
            }
            dateArr.push(value);
            let source = $('#tpl_extra_holiday_a').html();
            let template = Handlebars.compile(source);
            let data  = {extra_holidays:dateArr}
            let result = template(data);
            $('#extra_holidays_list' ).html(result);
            $('#extra_holiday_dates').val(JSON.stringify(dateArr));
            Gantt.prototype.bindRemoveExtraHolidayDate();
        }
    });
    $(".laydate_input_date").each(function (i) {
        var id = $(this).attr('id');
        laydate.render({
            elem: '#' + id,
            position: 'fixed'
        });
    })
})