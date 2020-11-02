var InputSearch = (function () {
    var _currentSearchesArr = [];
    var _currentSearchesParams = [];
    var _currentSearchesStr = "";
    var _urlParams = {};
    var _dropdownHtml = {};
    var _cur_project_id = "";
    var _issueListConfig = "";
    var _isSearch = false;
    var _options = [];
    var _operators = [];
    var _curNameObj = "#js-dropdown-hint";
    var _curName = "hint";
    var _maping = {
        hint: "#js-dropdown-hint",
        operator: "#js-dropdown-operator"
    };

    function InputSearch(options, operators) {
        var self = this;
        _options = options;
        _operators = operators;
        self.getCurrentSearches();
        self.setRecentStorage();
        self.setCurrentSearch(_currentSearchesArr);
        self.setRecentSearch();
        self.getInputTrigger();
        $input = $("#filtered-search-issues");

        _options.forEach(function (item) {
            var js_name = "#js-dropdown-" + item.name;
            var str = js_name + " .filter-dropdown";
            _dropdownHtml[item.key] = $.trim($(str).html());
            _maping[item.key] = js_name;
        });

        _dropdownHtml["hint"] = $.trim($("#js-dropdown-hint .filter-dropdown").html());
        _dropdownHtml["operator"] = $.trim($("#js-dropdown-operator .filter-dropdown").html());

        // 取消按钮提交
        $("#filter-form").on("submit", function () {
            return false;
        });

        // input输入下拉
        $("#filtered-search-issues").on("focus keyup keydown", function (e) {
            _isSearch = true;
            var $this = $(this);
            var value = $this.val();
            var dropdown_name = $this.data("dropdown-trigger");
            var dropdown_js = "#js-dropdown-" + dropdown_name;
            var $search_item = $(".tokens-container .filtered-search-token");

            if (e.keyCode === 8 && !value && $search_item.length > 0) {
                var $last = $search_item.last();
                var $name = $last.find(".name");
                var $operator = $last.find(".operator");
                var $value = $last.find(".value");
                var $close = $last.find(".selectable-close");
                var name = $name.text();
                var option_item = self.getOptionItem(name);
                var js_name = option_item.name || "";

                if ($value.text()) {
                    $this.attr("data-dropdown-trigger", js_name);
                    $this.val($value.text());
                    self.getDropdownData(js_name, $value.text());
                    $close.remove();
                    $value.remove();
                    $(js_name).siblings(".filtered-search-input-dropdown-menu").hide();
                    $(js_name).css("left", self.getSearchLeft()).slideDown(300);
                } else if ($operator.text()) {
                    $this.val($operator.text());
                    $operator.remove();
                    self.getOperatorsData($this.val());
                    $("#js-dropdown-operator").siblings(".filtered-search-input-dropdown-menu").hide();
                    $("#js-dropdown-operator").css("left", self.getSearchLeft()).slideDown(300);
                } else {
                    $this.val($name.text());
                    $name.remove();
                    $("#js-dropdown-hint ul.filter-dropdown").html(self.getHintData());
                    $("#js-dropdown-hint").css("left", self.getSearchLeft()).slideDown(300);
                }
            } else if (e.keyCode !== 13) {
                if (dropdown_name === "hint"){
                    $("#js-dropdown-hint ul.filter-dropdown").html(self.getHintData($this.val()));
                } else if (dropdown_name === "operator") {
                    self.getOperatorsData($this.val());
                } else if (value) {
                    self.getDropdownData(dropdown_name, value);
                }
                $(dropdown_js).siblings(".filtered-search-input-dropdown-menu").hide();
                $(dropdown_js).css("left", self.getSearchLeft()).slideDown(300);
            }
        });

        // 点击名称
        $("#js-dropdown-hint").on("click", ".filter-dropdown-item", function () {
            var name = $(this).find(".js-filter-hint").text();
            _curNameObj = _maping[name];
            _curName = self.getOptionItem(name) ? self.getOptionItem(name).name : "";
            self.setCurrentSearchName(name);
            self.getOperatorsData();
            $("#js-dropdown-hint").slideUp();
            $("#js-dropdown-operator").css("left", self.getSearchLeft()).slideDown(300);
            $input.val("");
            self.getInputTrigger();
        });

        // 点击分隔符
        $("#js-dropdown-operator").on("click", ".filter-dropdown-item", function () {
            var name = $(this).find(".value").text();
            self.setCurrentSearchOperator(name);
            self.getDropdownData(_curName);
            $("#js-dropdown-operator").slideUp();
            $(_curNameObj).css("left", self.getSearchLeft()).slideDown(300);
            $input.val("");
            self.getInputTrigger();
        });

        // 点击选择值
        $(".filtered-search-input-dropdown-menu:not(.hint-dropdown)").on("click", ".filter-dropdown-item", function () {
            var value1 = $(this).find(".value").text();
            var value2 = $(this).find(".name").text();
            var value = value1 || value2;
            var $parent = $(this).parents(".filtered-search-input-dropdown-menu");
            self.setCurrentSearchValue(value);
            $parent.slideUp();
            $input.val("");
            self.getInputTrigger();
        });

        // 删除搜索项
        $(".tokens-container").on("click.close", ".selectable-close", function () {
            $(this).parents(".js-visual-token").remove();
        });

        // 点击空白处下拉全部收起
        $(document).on("click", function (e) {
            var $dropdown = $(".filtered-search-input-dropdown-menu");
            var $input = $(".input-token .filtered-search");
            var $search = $(".tokens-container .filtered-search-token").last();
            if ((!$dropdown.is(e.target) && $dropdown.has(e.target).length === 0) && (!$input.is(e.target) && $input.has(e.target).length === 0)) {
                $(".filtered-search-input-dropdown-menu:visible").hide();
                _isSearch = false;
                if ($search.find(".value").length === 0) {
                    $search.remove();
                }
            }
        });

        // 回车搜索
        $(document).on("keydown", function (e) {
            if (e.keyCode === 13 && _isSearch) {
                self.search();
            }
        });

        // 点击历史搜索
        $(".filtered-search-history-dropdown").on("click", ".filtered-search-history-dropdown-item", function (e) {
            var $item = $(this).find(".filtered-search-history-dropdown-token");
            var temp = [];
            $(".tokens-container .filtered-search-token").remove();

            $item.each(function (e) {
                var $this = $(this);
                var name = $this.find(".name").text();
                var value = $this.find(".value").text();
                var operator = $this.find(".operator").text();
                temp.push({
                    name,
                    operator,
                    value
                });
            });

            self.setCurrentSearch(temp);
        });

        // 清除历史记录
        $(".filtered-search-history-dropdown").on("click", ".filtered-search-history-clear-button", function (e) {
            sessionStorage.setItem("issue-recent-searches", "");
            self.setRecentSearch();
        });
    };
    
    // 匹配options
    InputSearch.prototype.getOptionItem = function (name) {
        var temp = _options.filter(function (n) {
              return n.key === name;
          });
        return temp.length ? temp[0] : null;
    };
    
    // 获取下拉框
    InputSearch.prototype.getInputTrigger = function () {
        var triggerEl = "hint";
        var $lastLi = $(".js-visual-token").last();
        if ($lastLi.length && $lastLi.find(".name").length > 0 && $lastLi.find(".operator").length === 0) {
            triggerEl = "operator";
        } else if ($lastLi.length && $lastLi.find(".operator").length > 0 && $lastLi.find(".value").length === 0) {
            var name = $lastLi.find(".name").text();
            var tempArr =  _options.filter(function (n) {
                return n.key === name;
            });
            var elName = tempArr[0].name;

            triggerEl = elName;
        }
        $(".tokens-container .filtered-search").attr("data-dropdown-trigger", triggerEl);
    };

    // 获取对象值
    InputSearch.prototype.getSearchObjectValue = function (data) {
        var temp = null;
        _options.forEach(function (n) {
            var name = decodeURIComponent(data[0]);
            if (n.key == name) {
                temp = n.symbol + decodeURIComponent(data[1]);
            }
        });

        return temp;
    };

    InputSearch.prototype.getCurrentSearchesStr = function () {
        var searchKeys = window.location.search.slice(1).split("&");
        var searchKeysArr = [];
        var searchParams = [];
        var tempData = "";
        var self = this;
        searchKeys.forEach(function (n) {
            var tempArr = n.split("=");
            var name = decodeURIComponent(tempArr[0]);
            var value = self.getSearchObjectValue(tempArr);
            var regex = /[^\[\]]+(?=\])/g;
            var operator = "=";
            if (value && value.indexOf("not@") !== -1) {
                var temp = value.split('not@');
                //value = temp[1];
                operator = '!='
            }

            var temp = {
                name,
                operator,
                value
            };

            var temp1 = {
                name,
                operator,
                value: decodeURIComponent(tempArr[1])
            };

            if (value) {
                searchKeysArr.push(temp);
                searchParams.push(temp1);
                tempData += name + '=' + value + "&";
            }
        });
        if(tempData.substr(tempData.length-1,1)=='&'){
            tempData = tempData.substr(0,tempData.length-1);
        }
        _currentSearchesArr = searchKeysArr;
        _currentSearchesParams = searchParams;
        _currentSearchesStr = $.trim(tempData);

        return _currentSearchesStr;
    };

    //获取当前搜索内容
    InputSearch.prototype.getCurrentSearches = function () {
        var searchKeys = window.location.search.slice(1).split("&");
        var searchKeysArr = [];
        var searchParams = [];
        var tempData = "";
        var self = this;
        searchKeys.forEach(function (n) {
            var tempArr = n.split("=");
            var name = decodeURIComponent(tempArr[0]);
            var value = self.getSearchObjectValue(tempArr);
            var regex = /[^\[\]]+(?=\])/g;
            var operator = "=";

            if (value && value.indexOf("not@") !== -1) {
                var temp = value.split('not@');
                value = temp[1];
                operator = "!=";
            }

            var temp = {
                name,
                operator,
                value
            };

            var temp1 = {
                name,
                operator,
                value: decodeURIComponent(tempArr[1])
            };

            if (value) {
                searchKeysArr.push(temp);
                searchParams.push(temp1);
                tempData += name + ":" + operator + value + " ";
            }
        });
        _currentSearchesArr = searchKeysArr;
        _currentSearchesParams = searchParams;
        _currentSearchesStr = $.trim(tempData);

        return _currentSearchesStr;
    };

    // 设置当前搜索
    InputSearch.prototype.setCurrentSearch = function (data) {
        var html = "";
        data.forEach(function (n) {
            html += '<li class="js-visual-token filtered-search-token">';
            html += '<div class="name">' + n.name + '</div>';
            if (n.operator) {
                html += '<div class="operator">' + n.operator + '</div>';
            }

            if(n.value) {
                html += '<div class="value">' + n.value + '</div>';
                html += '<div class="selectable-close"><i class="fa fa-times"></i></div>';
            }
            html += '</li>';
        });

        $(".tokens-container .input-token").before(html);
    };

    // 获取历史搜索
    InputSearch.prototype.getRecentStorage = function () {
        var tempSearches = [];
        var recentSearches = sessionStorage.getItem("issue-recent-searches");
        if (recentSearches) {
            tempSearches = JSON.parse(recentSearches);
        }

        return tempSearches;
    };

    // 设置历史搜索
    InputSearch.prototype.setRecentStorage = function () {
        var tempSearches = this.getRecentStorage();
        var index = null;
        tempSearches.forEach(function (n, i) {
            if (n === _currentSearchesStr) {
                index = i;
            }
        });
        if (index === null && _currentSearchesStr) {
            tempSearches.push(_currentSearchesStr);
        } else if (index > 0) {
            var tempArr = tempSearches[index];
            tempSearches.splice(index, 1);
            tempSearches.unshift(tempArr);
        }

        var data = JSON.stringify(tempSearches);
        sessionStorage.setItem("issue-recent-searches", data);
    };

    // hint选择
    InputSearch.prototype.setCurrentSearchName = function (name) {
        var html = '<li class="js-visual-token filtered-search-token">';
        html += '<div class="name">' + name + '</div>';
        html += '</li>';

        $(".tokens-container .input-token").before(html);
    };

    //设置分隔符
    InputSearch.prototype.setCurrentSearchOperator = function (value) {
        var html = '<div class="operator">' + value + '</div>';

        $(".tokens-container .filtered-search-token").last().append(html);
    };

    //设置值
    InputSearch.prototype.setCurrentSearchValue = function (value) {
        var html = '<div class="value">' + value + '</div><div class="selectable-close"><i class="fa fa-times"></i></div>';

        $(".tokens-container .filtered-search-token").last().append(html);
    };

    //设置历史搜索
    InputSearch.prototype.setRecentSearch = function () {
        var tempSearches = this.getRecentStorage();
        var html = "";
        tempSearches.forEach(function (n) {
            var tempArr = n.split(" ");
            if (tempArr[0]) {
                html += '<li class="filtered-search-history-dropdown-item">';
                tempArr.forEach(function (val) {
                    var valArr = val.split(":");
                    var name = val.substring(0, val.indexOf(":"));
                    var operator = val.substring(val.indexOf(":") + 1, val.indexOf("=") + 1);
                    var value = val.substring(val.indexOf("=") + 1, val.length);
                    html += '<span class="filtered-search-history-dropdown-token">';
                    html += '<span class="name">' + name + '</span>';
                    html += '<span class="operator">' + operator + '</span>';
                    html += '<span class="value">' + value + '</span>';
                    html += '</span>';
                });
                html += '</li>';
            }
        });
        if (!html) {
            html = '<div class="dropdown-info-note">您没有历史搜索记录</div>';
        } else {
            html += '<li class="divider"></li>';
            html += '<li><button type="button" class="filtered-search-history-clear-button">清除搜索记录</button></li>';
        }

        $(".filtered-search-history-dropdown .filtered-search-history-dropdown-content ul").html(html);
    };

    // 搜索
    InputSearch.prototype.search = function () {
        var $searches = $(".tokens-container .filtered-search-token");
        var searches = {};
        searches["state"] = _urlParams["state"] || "opened";
        $searches.each(function (e) {
            var name = $(this).find(".name").text();
            var value = $(this).find(".value").text();
            var operator = $(this).find(".operator").text();

            _options.forEach(function (n) {
                if (n.key === name) {
                    value = value.replace(n.symbol, "");
                }
            });
            if (operator.indexOf("!") != -1) {
                searches[name] = "not@" +value;
            } else {
                searches[name] = value;
            }
        });
        var url = "?";
        var count = 0;

        for (var [key, val] of Object.entries(searches)) {
            if (count > 0) {
                url += "&";
            }
            url += key + "=" + val;
            count ++;
        }
        // var url = '?' + parseParam(searches);
        window.location.href = url;
    };

    // 获取名称列表
    InputSearch.prototype.getHintData = function (keyword) {
        var html = "";
        var hintArr = [];
        var $searches = $(".tokens-container .filtered-search-token");
        var self = this;
        _options.forEach(function (item) {
            var isExit = false;
            $searches.each(function (n) {
                var name = $(this).find(".name").text();
                if (name === item.key) {
                    isExit = true;
                }
            });

            if (!isExit) {
                hintArr.push(item);
            }
        });

        hintArr.forEach(function (val) {
            if (keyword && (val.key).indexOf(keyword) == -1) return false;
            var tempHtml = _dropdownHtml.hint || "";
            tempHtml = tempHtml.replace("{{icon}}", "fa-" + val.icon);
            tempHtml = tempHtml.replace("{{hint}}", val.key);
            tempHtml = tempHtml.replace("{{tag}}", "&lt;" + val.symbol + val.name + "&gt;");

            html += tempHtml;
        });

        return html;
    };

    // 获取分隔符数据
    InputSearch.prototype.getOperatorsData = function (keyword) {
        var html = "";
        var tempData = [];
        var self = this;
        var tempKeyword = keyword || "";

        _operators.forEach(function (n) {
            if ((n.value).indexOf(tempKeyword) >= 0) {
                tempData.push(n);
            }
        });

        self.setDropdownData(tempData, "operator");
    };

    // 获取下拉数据
    InputSearch.prototype.getDropdownData = function (name, keyword) {
        var html = "";
        var apiUrl = "";
        var dataArr = [];
        var self = this;
        var key = "";
        var tempKeyword = keyword || "";

        _options.forEach(function (n) {
            if (n.name === name) {
                let tempData = JSON.parse(JSON.stringify(_issueListConfig));
                apiUrl = n.api || "";
                key = n.key;
                // apiUrl = apiUrl.replace("{{project_id}}", _cur_project_id);
                dataArr = n.jsonData || [];
            }
        });

        if (apiUrl) {
            $.ajax({
                type: 'get',
                dataType: "json",
                async: true,
                url: apiUrl,
                success: function (resp) {
                    self.setDropdownData(resp, key);
                },
                error: function (res) {
                    notify_error("请求数据错误" + res);
                }
            });
        } else {
            var tempData = [];
            console.log(dataArr);
            dataArr.forEach(function (item) {
                if ((item.name).indexOf(tempKeyword) >= 0) {
                    tempData.push(item);
                }
            });

            self.setDropdownData(tempData, key);
        }
    };

    // 设置下拉数据
    InputSearch.prototype.setDropdownData = function (data, name) {
        var html = "";
        data.forEach(function (n) {
            var tempHtml = _dropdownHtml[name];
            // var reg = new RegExp("{{name}}", "g");
            var regex = /[^{{}}]+(?=\}})/g;
            var tempArr = tempHtml.match(regex);

            tempArr.forEach(function (str) {
                tempHtml = tempHtml.replace("{{" + str + "}}", n[str] || "");
            });
            html += tempHtml;
        });
        $(_maping[name]).html(html);
    };

    // 获取距离左侧位置
    InputSearch.prototype.getSearchLeft = function () {
        var left1 = $(".filtered-search-box-input-container").offset().left;
        var left2 = $('.tokens-container .input-token').offset().left;

        var left = left2 - left1;
        return left;
    };

    return InputSearch;
})();