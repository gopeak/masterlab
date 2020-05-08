var FilteredSearch = (function () {
    var _searches =  [
        {
            key: "优先级",
            name: "priority",
            api: "/config/priority",
            symbol: ""
        },
        {
            key: "状态",
            name: "status",
            api: "/config/status",
            symbol: ""
        },
        {
            key: "迭代",
            name: "sprint",
            api: "/config/sprint?project_id={{project_id}}",
            symbol: ""
        },
        {
            key: "类型",
            name: "issue_type",
            api: "/config/issueType?project_id={{project_id}}",
            symbol: ""
        },
        {
            key: "模块",
            name: "module",
            api: "/config/module?project_id={{project_id}}",
            symbol: ""
        },
        {
            key: "解决结果",
            name: "resolve",
            api: "/config/resolve",
            symbol: ""
        },
        {
            key: "报告人",
            name: "author",
            jsonData: "users",
            symbol: "@"
        },
        {
            key: "经办人",
            name: "assignee",
            jsonData: "users",
            symbol: "@"
        }];

    var mapping = {
        '优先级': "#js-dropdown-priority",
        '状态': "#js-dropdown-status",
        '迭代': "#js-dropdown-sprint",
        '类型': "#js-dropdown-issue_type",
        '模块': "#js-dropdown-module",
        '解决结果': "#js-dropdown-resolve",
        '报告人': "#js-dropdown-author",
        '经办人': "#js-dropdown-assignee",
        hint: "#js-dropdown-hint"
    }

    var _currentSearchesArr = [];
    var _currentSearchesParams = [];
    var _currentSearchesStr = "";
    var _urlParams = {};
    var _dropdownHtml = {};
    var _cur_project_id = "";
    var _issueListConfig = "";
    var _searchesObject = {};
    var _isSearch = false;

    function FilteredSearch(urlParams, issueConfig, project_id) {
        _cur_project_id = project_id;
        _issueListConfig = JSON.parse(JSON.stringify(issueConfig));
        var self = this;
        self.getCurrentSearches();
        self.setRecentStorage();
        self.setCurrentSearch(_currentSearchesArr);
        self.setRecentSearch();
        _urlParams = urlParams;

        $("#filtered-search-issues").attr("data-dropdown-trigger", "#js-dropdown-hint");

        _searches.forEach(function (item) {
            var str = "#js-dropdown-" + item.name + " .filter-dropdown";
            _dropdownHtml[item.key] = $.trim($(str).html());
            _searchesObject[item.key] = str;
        });

        _dropdownHtml["hint"] = $.trim($("#js-dropdown-hint .filter-dropdown").html());
        _searchesObject["hint"] = "#js-dropdown-hint .filter-dropdown";

        $(".tokens-container").on("click.close", ".selectable-close", function () {
            $(this).parents(".js-visual-token").remove();
        });

        $(".tokens-container").on("click.clear", ".clear-search", function () {
            $(".tokens-container .filtered-search-token").remove();
        });

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
                    value
                });
            });

            self.setCurrentSearch(temp);
        });

        $(".filtered-search-history-dropdown").on("click", ".filtered-search-history-clear-button", function (e) {
            sessionStorage.setItem("issue-recent-searches", "");
        });

        $("#btn-go_search").on("click", function () {
            self.search(_urlParams);
            return false;
        });

        $("#filter-form").on("submit", function () {
           return false;
        });

        $("#filtered-search-issues").on("focus", function (e) {
            _isSearch = true;
            var dropdownTrigger = $(this).data("dropdown-trigger");
            var hint = $(dropdownTrigger).data("hint") || "";
            if (dropdownTrigger === "#js-dropdown-hint") {
                $(dropdownTrigger + " ul.filter-dropdown").html(self.getHintData());
            } else if (hint) {
                self.getDropdownData(hint);
            }
            $(dropdownTrigger).css("left", self.getSearchLeft()).slideDown(300);
        });

        $("#js-dropdown-hint").on("click", ".filter-dropdown-item", function () {
            var name = $(this).find(".js-filter-hint").text();
            var obj = mapping[name];
            self.setCurrentSearchName(name);
            self.getDropdownData(name);
            $("#js-dropdown-hint").slideUp();
            $(obj).css("left", self.getSearchLeft()).slideDown(300);
        });

        $(".filtered-search-input-dropdown-menu:not(.hint-dropdown)").on("click", ".filter-dropdown-item", function () {
            var value1 = $(this).find(".js-data-value").text();
            var value2 = $(this).find(".dropdown-light-content").text();
            var value = value1 || value2;
            var $parent = $(this).parents(".filtered-search-input-dropdown-menu");
            self.setCurrentSearchValue(value);
            $parent.slideUp();
        });

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

        $(document).on("keydown", function (e) {
            if (e.keyCode === 13 && _isSearch) {
                self.search();
            }
        });
    };

    FilteredSearch.prototype.getSearchObjectValue = function (data) {
        var temp = null;
        _searches.forEach(function (n) {
            var name = decodeURIComponent(data[0]);
            if (n.key == name) {
                temp = n.symbol + decodeURIComponent(data[1]);
            }
        });

        return temp;
    };

    FilteredSearch.prototype.getCurrentSearches = function () {
        var searchKeys = window.location.search.slice(1).split("&");
        var searchKeysArr = [];
        var searchParams = [];
        var tempData = "";
        var self = this;
        searchKeys.forEach(function (n) {
            var tempArr = n.split("=");
            var name = decodeURIComponent(tempArr[0]);
            var value = self.getSearchObjectValue(tempArr);
            var temp = {
                name,
                value
            };

            var temp1 = {
                name,
                value: decodeURIComponent(tempArr[1])
            };

            if (value) {
                searchKeysArr.push(temp);
                searchParams.push(temp1);
                tempData += name + ":" + value + " ";
            }
        });
        _currentSearchesArr = searchKeysArr;
        _currentSearchesParams = searchParams;
        _currentSearchesStr = $.trim(tempData);
    };

    FilteredSearch.prototype.getRecentStorage = function () {
        var tempSearches = [];
        var recentSearches = sessionStorage.getItem("issue-recent-searches");
        if (recentSearches) {
            tempSearches = JSON.parse(recentSearches);
        }

        return tempSearches;
    };

    FilteredSearch.prototype.setRecentStorage = function () {
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

    FilteredSearch.prototype.setCurrentSearch = function (data) {
        var html = "";
        data.forEach(function (n) {
            html += '<li class="js-visual-token filtered-search-token">';
            html += '<div class="name">' + n.name + '</div>';
            if(data.value) {
                html += '<div class="value">' + n.value + '</div>';
                html += '<div class="selectable-close"><i class="fa fa-times"></i></div>';
            }
            html += '</li>';
        });

        $(".tokens-container .input-token").before(html);
    };

    FilteredSearch.prototype.setCurrentSearchName = function (name) {
        var html = '<li class="js-visual-token filtered-search-token">';
        html += '<div class="name">' + name + '</div>';
        html += '</li>';

        $(".tokens-container .input-token").before(html);
    };

    FilteredSearch.prototype.setCurrentSearchValue = function (value) {
        var html = '<div class="value">' + value + '</div><div class="selectable-close"><i class="fa fa-times"></i></div>';

        $(".tokens-container .filtered-search-token").last().append(html);
    };

    FilteredSearch.prototype.setRecentSearch = function () {
        var tempSearches = this.getRecentStorage();
        var html = "";
        tempSearches.forEach(function (n) {
            var tempArr = n.split(" ");
            if (tempArr[0]) {
                html += '<li class="filtered-search-history-dropdown-item">';
                tempArr.forEach(function (val) {
                    var valArr = val.split(":");
                    html += '<span class="filtered-search-history-dropdown-token">';
                    html += '<span class="name">' + valArr[0] + '</span>';
                    html += '<span class="value">' + valArr[1] + '</span>';
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

    FilteredSearch.prototype.search = function () {
        var $searches = $(".tokens-container .filtered-search-token");
        var searches = {};
        searches["state"] = _urlParams["state"] || "opened";
        $searches.each(function (e) {
            var name = $(this).find(".name").text();
            var value = $(this).find(".value").text();

            _searches.forEach(function (n) {
                if (n.key === name) {
                    value = value.replace(n.symbol, "");
                }
            });
            searches[name] = value;
        });
        var url = '?' + parseParam(searches);
        window.location.href = url;
    };

    FilteredSearch.prototype.getSearchLeft = function () {
        var left1 = $(".filtered-search-box-input-container").offset().left;
        var left2 = $('.tokens-container .input-token').offset().left;

        var left = left2 - left1;
        return left;
    };

    FilteredSearch.prototype.getHintData = function () {
        var hintArr = [];
        var $search = $(".tokens-container .filtered-search-token");
        $(".filtered-search-input-dropdown-menu:not(.hint-dropdown)").each(function (e) {
            var $this = $(this);
            var isSearched = false;

            $search.each(function (e) {
                var name = $(this).find(".name").text();
                if(name === $this.data("hint")) {
                    isSearched = true;
                }
            });

            if (!isSearched) {
                hintArr.push({
                    icon: $this.data("icon"),
                    name: $this.data("hint"),
                    tag: $this.data("tag")
                });
            }
        });

        var html = "";
        hintArr.forEach(function (n) {
            var tempHtml = _dropdownHtml.hint || "";
            tempHtml = tempHtml.replace("{{icon}}", "fa-" + n.icon);
            tempHtml = tempHtml.replace("{{hint}}", n.name);
            tempHtml = tempHtml.replace("{{tag}}", "<" + n.tag + ">");

            html += tempHtml;
        });

        return html;
    };

    FilteredSearch.prototype.getDropdownData = function (name) {
        var html = "";
        var apiUrl = "";
        var tempJson = "";
        var self = this;

        _searches.forEach(function (n) {
            if (n.key === name) {
                let tempData = JSON.parse(JSON.stringify(_issueListConfig));
                apiUrl = n.api || "";
                apiUrl = apiUrl.replace("{{project_id}}", _cur_project_id);
                tempJson = n.jsonData ? tempData[n.jsonData] : "";
            }
        });

        if (apiUrl) {
            $.ajax({
                type: 'get',
                dataType: "json",
                async: true,
                url: apiUrl,
                success: function (resp) {
                    console.log(resp);
                    self.setDropdownData(resp, name);
                },
                error: function (res) {
                    notify_error("请求数据错误" + res);
                }
            });
        } else if (tempJson){
            var tempData = [];
            for (var [key, value] of Object.entries(tempJson)) {
                tempData.push(value);
            }

            self.setDropdownData(tempData, name);
        }
    };

    FilteredSearch.prototype.setDropdownData = function (data, name) {
        var html = ""
        data.forEach(function (n) {
            var tempHtml = _dropdownHtml[name];
            var reg = new RegExp("{{name}}", "g");
            tempHtml = tempHtml.replace(reg, n.name || n.display_name || "");
            tempHtml = tempHtml.replace("{{avatar_url}}", n.avatar || "");
            tempHtml = tempHtml.replace("{{username}}", n.username || "");
            tempHtml = tempHtml.replace("{{color}}", n.color || "");
            html += tempHtml;
        });

        $(_searchesObject[name]).html(html);
    };

    return FilteredSearch;
})();