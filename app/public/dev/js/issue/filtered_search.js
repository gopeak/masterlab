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

    function FilteredSearch(urlParams, issueConfig, project_id) {
        _cur_project_id = project_id;
        _issueListConfig = JSON.parse(JSON.stringify(issueConfig));
        // IssueMain.prototype.getCurrentSearches();
        // IssueMain.prototype.setRecentStorage();
        // IssueMain.prototype.setCurrentSearch(_currentSearchesArr);
        // IssueMain.prototype.setRecentSearch();
        // _urlParams = urlParams;
        //
        // $("#filtered-search-issues").attr("data-dropdown-trigger", "#js-dropdown-hint");
        //
        // _searches.forEach(function (item) {
        //     var str = "#js-dropdown-" + item.name + " .filter-dropdown";
        //     _dropdownHtml[item.key] = $.trim($(str).html());
        //     _searchesObject[item.key] = str;
        // });
        //
        // _dropdownHtml["hint"] = $.trim($("#js-dropdown-hint .filter-dropdown").html());
        // _searchesObject["hint"] = "#js-dropdown-hint .filter-dropdown";
        //
        // $(".tokens-container").on("click.close", ".selectable-close", function () {
        //     $(this).parents(".js-visual-token").remove();
        // });
        //
        // $(".tokens-container").on("click.clear", ".clear-search", function () {
        //     $(".tokens-container .filtered-search-token").remove();
        // });
        //
        // $(".filtered-search-history-dropdown").on("click", ".filtered-search-history-dropdown-item", function (e) {
        //     var $item = $(this).find(".filtered-search-history-dropdown-token");
        //     var temp = [];
        //
        //     $item.each(function (e) {
        //         var $this = $(this);
        //         var name = $this.find(".name").text();
        //         var value = $this.find(".value").text();
        //         temp.push({
        //             name,
        //             value
        //         });
        //     });
        //
        //     // IssueMain.prototype.setCurrentSearch(temp);
        // });
        //
        // $(".filtered-search-history-dropdown").on("click", ".filtered-search-history-clear-button", function (e) {
        //     sessionStorage.setItem("issue-recent-searches", "");
        // });
        //
        // $("#btn-go_search").on("click", function () {
        //     IssueMain.prototype.search(_urlParams);
        //     return false;
        // });
        //
        // $("#filtered-search-issues").on("focus", function (e) {
        //     var dropdownTrigger = $(this).data("dropdown-trigger");
        //     var hint = $(dropdownTrigger).data("hint") || "";
        //     if (dropdownTrigger === "#js-dropdown-hint") {
        //         $(dropdownTrigger + " ul.filter-dropdown").html(IssueMain.prototype.getHintData());
        //     } else if (hint) {
        //         IssueMain.prototype.getDropdownData(hint);
        //     }
        //     $(dropdownTrigger).css("left", IssueMain.prototype.getSearchLeft()).slideDown(300);
        // });
        //
        // $("#js-dropdown-hint").on("click", ".filter-dropdown-item", function () {
        //     var name = $(this).find(".js-filter-hint").text();
        //     var obj = mapping[name];
        //     IssueMain.prototype.setCurrentSearchName(name);
        //     IssueMain.prototype.getDropdownData(name);
        //     $("#js-dropdown-hint").slideUp();
        //     $(obj).css("left", IssueMain.prototype.getSearchLeft()).slideDown(300);
        // });
        //
        // $(".filtered-search-input-dropdown-menu:not(.hint-dropdown)").on("click", ".filter-dropdown-item", function () {
        //     var value = $(this).find(".js-data-value").text();
        //     var $parent = $(this).parents(".filtered-search-input-dropdown-menu");
        //     IssueMain.prototype.setCurrentSearchValue(value);
        //     $parent.slideUp();
        // });
        //
        // $(document).on("click", function (e) {
        //     var $dropdown = $(".filtered-search-input-dropdown-menu");
        //     var $input = $(".input-token .filtered-search");
        //     var $search = $(".tokens-container .filtered-search-token").last();
        //     if ((!$dropdown.is(e.target) && $dropdown.has(e.target).length === 0) && (!$input.is(e.target) && $input.has(e.target).length === 0)) {
        //         $(".filtered-search-input-dropdown-menu:visible").hide();
        //         if ($search.find(".value").length === 0) {
        //             $search.remove();
        //         }
        //     }
        // });
    };

    IssueMain.prototype.getSearchObjectValue = function (data) {
        var temp = null;
        _searches.forEach(function (n) {
            var name = decodeURIComponent(data[0]);
            if (n.key == name) {
                temp = n.symbol + decodeURIComponent(data[1]);
            }
        });

        return temp;
    };

    IssueMain.prototype.getCurrentSearches = function () {
        var searchKeys = window.location.search.slice(1).split("&");
        var searchKeysArr = [];
        var searchParams = [];
        var tempData = "";
        searchKeys.forEach(function (n) {
            var tempArr = n.split("=");
            var name = decodeURIComponent(tempArr[0]);
            var value = IssueMain.prototype.getSearchObjectValue(tempArr);
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

    IssueMain.prototype.getRecentStorage = function () {
        var tempSearches = [];
        var recentSearches = sessionStorage.getItem("issue-recent-searches");
        if (recentSearches) {
            tempSearches = JSON.parse(recentSearches);
        }

        return tempSearches;
    };

    IssueMain.prototype.setRecentStorage = function () {
        var tempSearches = IssueMain.prototype.getRecentStorage();

        var index = null;
        tempSearches.forEach(function (n, i) {
            if (n === _currentSearchesStr) {
                index = i;
            }
        });
        if (index === null) {
            tempSearches.push(_currentSearchesStr);
        } else if (index > 0) {
            var tempArr = tempSearches[index];
            tempSearches.splice(index, 1);
            tempSearches.unshift(tempArr);
        }

        var data = JSON.stringify(tempSearches);
        sessionStorage.setItem("issue-recent-searches", data);
    };

    IssueMain.prototype.setCurrentSearch = function (data) {
        var html = "";
        data.forEach(function (n) {
            html += '<li class="js-visual-token filtered-search-token">';
            html += '<div class="name">' + n.name + '</div>';
            html += '<div class="value">' + n.value + '</div>';
            html += '<div class="selectable-close"><i class="fa fa-times"></i></div></li>';
        });

        // $(".tokens-container .input-token").before(html);
    };

    IssueMain.prototype.setCurrentSearchName = function (name) {
        var html = '<li class="js-visual-token filtered-search-token">';
        html += '<div class="name">' + name + '</div>';
        html += '</li>';

        $(".tokens-container .input-token").before(html);
    };

    IssueMain.prototype.setCurrentSearchValue = function (value) {
        var html = '<div class="value">' + value + '</div><div class="selectable-close"><i class="fa fa-times"></i></div>';

        $(".tokens-container .filtered-search-token").last().append(html);
    };

    IssueMain.prototype.setRecentSearch = function () {
        var tempSearches = IssueMain.prototype.getRecentStorage();
        var html = "";
        tempSearches.forEach(function (n) {
            html += '<li class="filtered-search-history-dropdown-item">';
            var tempArr = n.split(" ");
            tempArr.forEach(function (val) {
                var valArr = val.split(":");
                html += '<span class="filtered-search-history-dropdown-token">';
                html += '<span class="name">' + valArr[0] + '</span>';
                html += '<span class="value">' + valArr[1] + '</span>';
                html += '</span>';
            });
            html += '</li>';
        });
        if (!html) {
            html = '<div class="dropdown-info-note">您没有历史搜索记录</div>';
        } else {
            html += '<li class="divider"></li>';
            html += '<li><button type="button" class="filtered-search-history-clear-button">清除搜索记录</button></li>';
        }

        $(".filtered-search-history-dropdown .filtered-search-history-dropdown-content ul").html(html);
    };

    IssueMain.prototype.search = function (urlParams) {
        var $searches = $(".tokens-container .filtered-search-token");
        var searches = urlParams;
        $searches.each(function (e) {
            var name = $(this).find(".name").text();
            var value = $(this).find(".value").text();

            _searches.forEach(function (n) {
                if (n.key === name) {
                    value = value.replace(n.symbol, "");
                }
            });
            searches[encodeURIComponent(name)] = value;
        });

        console.log(searches);
    };

    IssueMain.prototype.getSearchLeft = function () {
        var left1 = $(".filtered-search-box-input-container").offset().left;
        var left2 = $('.tokens-container .input-token').offset().left;

        var left = left2 - left1;
        return left;
    };

    IssueMain.prototype.getHintData = function () {
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

    IssueMain.prototype.getDropdownData = function (name) {
        var html = "";
        var apiUrl = "";
        var tempJson = "";

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
                    IssueMain.prototype.setDropdownData(resp, name);
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

            IssueMain.prototype.setDropdownData(tempData, name);
        }
    };

    IssueMain.prototype.setDropdownData = function (data, name) {
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