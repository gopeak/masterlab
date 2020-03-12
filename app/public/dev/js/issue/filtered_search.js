var FilteredSearch = (function () {
    var _searches =  [
        {
            key: "优先级",
            type: "string",
            symbol: ""
        },
        {
            key: "状态",
            type: "string",
            symbol: ""
        },
        {
            key: "迭代",
            type: "string",
            symbol: ""
        },
        {
            key: "类型",
            type: "string",
            symbol: ""
        },
        {
            key: "模块",
            type: "string",
            symbol: ""
        },
        {
            key: "解决结果",
            type: "string",
            symbol: ""
        },
        {
            key: "报告人",
            type: "string",
            symbol: "@"
        },
        {
            key: "经办人",
            type: "string",
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
    function FilteredSearch(urlParams) {
        IssueMain.prototype.getCurrentSearches();
        IssueMain.prototype.setRecentStorage();
        IssueMain.prototype.setCurrentSearch(_currentSearchesArr);
        IssueMain.prototype.setRecentSearch();
        _urlParams = urlParams;

        $(".tokens-container").on("click.close", ".selectable-close", function () {
            $(this).parents(".js-visual-token").remove();
        });

        $(".tokens-container").on("click.clear", ".clear-search", function () {
            $(".tokens-container .filtered-search-token").remove();
        });

        $("#filter-form").submit(function () {
            IssueMain.prototype.search(_urlParams);
            return false;
        });
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

    IssueMain.prototype.setRecentSearch = function () {
        var tempSearches = IssueMain.prototype.getRecentStorage();
        var html = "";
        tempSearches.forEach(function (n) {
            html += '<li>';
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
    };

    return FilteredSearch;
})();