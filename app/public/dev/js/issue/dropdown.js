var GlDropdown = (function () {
    var apiList = {
        projectsPath: "/auto_complete/projects?simple=true",
        projectsList: "/user/select_filter?format=json",
    };

    var _moduleList = [];

    function GlDropdown() {
        var self = this;
        $("#history-dropdown").on("shown.bs.dropdown", function () {
            if (!$(".js-dropdown-menu-projects #project_search").val()) {
                self.getProjectList(apiList.projectsPath);
            }
        });

        $(".js-dropdown-menu-projects").on("keyup", "#project_search", function () {
            var $self = $(this);
            var value = $self.val();
            self.getProjectList(apiList.projectsPath, value);
        });

        $(document).on("click", ".js-user-search", function () {
            var $self = $(this);
            var field_name = $self.data("field-name");
            var url = api.projectsList;
            var $target = $self.parent().find(".dropdown-content").eq(0);
            IssueMain.prototype.onChangeCreateProjectSelected()
            self.getUsersList(url, $target);
        });

        $(document).on("click", ".js-label-select", function () {
            var $self = $(this);
            var project_id = $self.data("project-id");
            var url = $self.data("labels");
            var field_name = $self.data("field-name");
            var selected = $self.data("selected");
            var $target = $self.parent().find(".dropdown-content").eq(0);
            $self.siblings(".dropdown-select").removeClass("is-page-two");
            self.getLabelsList(url, $target, "");
        });

        $(document).on("click", ".dropdown-toggle-page", function (e) {
            e.preventDefault();
            e.stopPropagation();
            var $select = $(this).parents(".dropdown-select");
            $select.find(".js-label-error").hide();
            $select.toggleClass("is-page-two");
            $select.find('[class^="dropdown-page-"]:visible :text:visible:first').focus();
        });

        $(document).on("keyup", "#search-module-dropdown", function () {
            var value = $(this).val();
            var data = _moduleList.filter(function (n) {
                if ((n.name).indexOf(value) >= 0) {
                    return n;
                }
            });
            var $content = $(this).parent().parent().find(".dropdown-content");
            self.setLabelsList(data, $content);
        });

        $(document).on("click", ".label-item", function () {
            var $dropdown = $(this).parents(".dropdown");
            var $button = $dropdown ? $dropdown.find(".dropdown-menu-toggle") : $(this).parent();
            var field_name = $button.data("field-name");
            var item_id = $(this).data("label-id");
            var item_name = $(this).text();
            if (field_name) {
                $("input[name='" + field_name + "']").val(item_id);
                $button.find(".is-default").text(item_name);
            }
        });

        $(document).on("click", ".js-new-module-btn", function (e) {
            var i = this;
            e.preventDefault();
            e.stopPropagation();
            var data = {
                module_name: $("#new_module_name").val() || "",
                description: $("#new_module_description").val() || ""
            };
            IssueForm.prototype.createModule(data, e);
        });
    };

    GlDropdown.prototype.getProjectList = function (url, keyword) {
        var search = keyword || "";
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url,
            data: {
                search,
                per_page: 20,
                membership: !0
            },
            success: function (data) {
                auth_check(data);
                var html = "<ul>";
                data.forEach(function (n) {
                    html += "<li><a href='" + n.web_url + "'>" + n.name_with_namespace + "</a></li>";
                });
                html += "</ul>";
                $(".js-dropdown-menu-projects .dropdown-content").html(html);
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    GlDropdown.prototype.getLabelsList = function (url, $target) {
        var self = this;
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url,
            success: function (data) {
                _moduleList = data;
                self.setLabelsList(data, $target);
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };
    GlDropdown.prototype.setLabelsList = function (data, $target) {
        var html = "";
        if (data.length === 0) {
            html = "<ul><li class='dropdown-menu-empty-link'><a href='javascript:;' data-label-id=''>没有匹配结果</a></li></ul>";
        } else {
            html = "<ul><li><a href='javascript:;' data-label-id=''>不选择</a></li><li class='divider'></li>";
            data.forEach(function (n) {
                html += "<li><a href='javascript:;' class='label-item' data-label-id='" + n.id + "'>" + n.name + "</a></li>";
            });
            html += "</ul>";
        }
        $target.html(html);
    };

    GlDropdown.prototype.getUsersList = function (url, $target, keyword) {
        var self = this;
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url,
            success: function (data) {
                _moduleList = data;
                self.setLabelsList(data, $target);
            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    };

    GlDropdown.prototype.setUsersList = function (data, $target) {
        var html = "<ul><li><a href='javascript:;' data-label-id=''>不选择</a></li><li class='divider'></li>";
        if (data.length === 0) {
            html = "<ul><li class='dropdown-menu-empty-link'><a href='javascript:;' data-label-id=''>没有匹配结果</a></li></ul>";
        } else {
            data.forEach(function (n) {
                html += "<li><a href='javascript:;' class='label-item' data-label-id='" + n.id + "'>" + n.name + "</a></li>";
            });
            html += "</ul>";
        }
        $target.html(html);
    };

    return GlDropdown;
})();