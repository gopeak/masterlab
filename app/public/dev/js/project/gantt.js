var Gantt = (function () {

    var _options = {};

    // constructor
    function Gantt(options) {
        _options = options;

    };

    Gantt.prototype.getOptions = function () {
        return _options;
    };

    Gantt.prototype.setOptions = function (options) {
        for (i in  options) {
            // if( typeof( _options[options[i]] )=='undefined' ){
            _options[i] = options[i];
            // }
        }
    };

     Gantt.prototype.initIssueType = function (issue_types) {
        //console.log(issue_types)
        var issue_types_select = document.getElementById('create_issue_types_select');
        $('#create_issue_types_select').empty();

        for (var _key in  issue_types) {

            issue_types_select.options.add(new Option(issue_types[_key].name, issue_types[_key].id));
        }
        console.log(issue_types_select);
        $('.selectpicker').selectpicker('refresh');
    }

    Gantt.prototype.initPriority = function (prioritys) {
        //console.log(prioritys)
        var issue_types_select = document.getElementById('priority');
        $('#priority').empty();

        for (var _key in  prioritys) {
            var row = prioritys[_key];
            var id = row.id;
            var title = row.name;
            var color = row.status_color;
            var opt = "<option data-content=\"<span style='color:" + color + "'>" + title + "</span>\" value='"+id+"'>"+title+"</option>";
            $('#priority').append(opt);
        }
        //data-content="<span style='color:red'>紧 急</span>"
        $('.selectpicker').selectpicker('refresh');
    }

    Gantt.prototype.initStatus = function (status) {
        //console.log(status)
        var issue_types_select = document.getElementById('gantt_status');
        $('#gantt_status').empty();

        for (var _key in  status) {
            var row = status[_key];
            var id = row.id;
            var title = row.name;
            var color = row.color;
            var opt = "<option data-content=\"<span class='label label-" + color + "'>" + title + "</span>\" value='"+id+"'>"+title+"</option>";
            console.log(opt)
            $('#gantt_status').append(opt);
        }
        $('.selectpicker').selectpicker('refresh');
    }


    return Gantt;
})();


