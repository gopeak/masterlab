!
function(t) {
    function i(n) {
        if (e[n]) return e[n].exports;
        var o = e[n] = {
            exports: {},
            id: n,
            loaded: !1
        };
        return t[n].call(o.exports, o, o.exports, i),
        o.loaded = !0,
        o.exports
    }
    var e = {};
    return i.m = t,
    i.c = e,
    i.p = "",
    i(0)
} ([function(t, i) {
    var e = {
        init: function() {
            var t = this;
            this.getVersionInfo(),
            this.adjustSec1(),
            $("#iweixi").on("mouseover",
            function() {
                var t = $("#tpl_weixinma").html(),
                i = $(this).offset(),
                e = 190,
                n = i.left,
                o = i.top - e - 10;
                t = t.replace(/\{left\}/g, n).replace(/\{top\}/g, o),
                $("#weixinma").remove(),
                $("body").append(t)
            }),
            $("#iweixi").on("mouseout",
            function() {
                $("#weixinma").fadeOut(800)
            }),
            $("#btn_nextsec").on("click",
            function(t) {
                t.preventDefault();
                var i = $("#sec_jx").offset(),
                e = i.top;
                $("html,body").animate({
                    scrollTop: e
                })
            });
            var i = null,
            e = !1;
            $("#more_version").on("mouseover",
            function() {
                window.clearTimeout(i);
                var n = t.MOREHTML || $("#tpl_mv").html(),
                o = $(this).offset(),
                a = o.left,
                s = o.top,
                c = ($(window).width(), a - 110),
                r = s + 30;
                n = n.replace(/\{left\}/g, c).replace(/\{top\}/g, r),
                $("#mv_info").remove(),
                $("body").append(n),
                e = !1,
                $("#mv_info").mouseenter(function() {
                    e = !0
                }),
                $("#mv_info").mouseleave(function() {
                    $("#mv_info").fadeOut(function() {
                        $("#mv_info").remove()
                    })
                })
            }),
            $("#more_version").on("mouseout",
            function() {
                window.setTimeout(function() {
                    e || $("#mv_info").fadeOut(function() {
                        $("#mv_info").remove()
                    })
                },
                100)
            }),
            $("#more_version").on("click",
            function(t) {
                t.preventDefault()
            });
            var n = null,
            o = !1;
            t.onScreen($("#switch_imgs"),
            function() {
                t.showSec2()
            }),
            t.onScreen($("#circlebar"),
            function() {
                t.showSec3()
            }),
            t.onScreen($("#winbar"),
            function() {
                t.showWinbar()
            }),
            t.lazyLoadBg(),
            $(window).on("scroll",
            function() {
                t.onScreen($("#switch_imgs"),
                function() {
                    t.showSec2()
                }),
                t.onScreen($("#circlebar"),
                function() {
                    t.showSec3()
                }),
                t.onScreen($("#winbar"),
                function() {
                    t.showWinbar()
                });
                var i = ($(document).height() - $(window).height(), $(document).scrollTop());
                i > 0 ? o || ($("#brbar a.to-top").addClass("rot-to-top").removeClass("frot-to-top"), $("#brbar").animate({
                    right: "10px"
                }), o = !0) : o && ($("#brbar a.to-top").removeClass("rot-to-top").addClass("frot-to-top"), $("#brbar").animate({
                    right: "-48px"
                }), o = !1),
                $(".downloadbar label.animate").removeClass("animate"),
                window.clearTimeout(n),
                n = window.setTimeout(function() {
                    $(".downloadbar label:eq(0)").addClass("animate")
                },
                500),
                t.lazyLoadBg()
            }),
            $("#brbar .to-top").on("click",
            function(t) {
                t.preventDefault(),
                $("html,body").animate({
                    scrollTop: 0
                },
                1e3)
            }),
            $(window).on("resize",
            function() {
                t.adjustSec1();
                var i = $("#switch_imgs").attr("data-done");
                if ("done" == i) {
                    for (var e = 0,
                    n = t.sec2_timer.length; n > e; e++) {
                        var o = t.sec2_timer[e];
                        window.clearTimeout(o)
                    }
                    $("#switch_imgs").html(""),
                    t.showSec2()
                }
                var i = $("#circlebar").attr("data-done");
                "done" == i && t.showSec3();
                var i = $("#winbar").attr("data-done");
                "done" == i && ($("#winbar").html(""), t.showWinbar())
            });
            var a = this.getQueryString("channel");
            a = parseInt(a, 10),
            a > 0 && this.showChannelInfo(a)
        },
        showChannelInfo: function(t) {
            $(".summary span").html(""),
            $(".nav").css({
                width: "480px"
            }),
            $(".nav ul").css({
                width: "500px"
            }),
            $(".nav li").eq(0).find("a").html("官网首页").attr("href", "/shadu/"),
            $(".app-info").hide(),
            $(".app-more").hide();
            var i = "";
            switch (t) {
            case 10185:
                i = "http://w.x.baidu.com/go/mini/2/10185";
                break;
            case 10186:
                i = "http://w.x.baidu.com/go/mini/2/10186";
                break;
            case 10187:
                i = "http://w.x.baidu.com/go/mini/2/10187"
            }
            i && $(".download-url").attr("href", i)
        },
        getQueryString: function(t) {
            var i = new RegExp("(^|&)" + t + "=([^&]*)(&|$)", "i"),
            e = window.location.search.substr(1).match(i);
            return null != e ? unescape(e[2]) : null
        },
        getVersionInfo: function() {
            /*
            var t = this.getQueryString("channel");
            if (t = parseInt(t, 10), !(t > 0)) {
                var i = this;
                $.get(domain + "/api/index/json_get_ad_info?recache",
                function(t) {
                    i.showDownloadInfo(t)
                },
                "jsonp")
            }
            */
        },
        showDownloadInfo: function(t) {
            var i = t.msg && t.msg.shadu ? t.msg.shadu: null;
            if (t.msg.shadu) {
                var e = i.page_info,
                n = e.version,
                o = n.memo,
                a = n.value;
                $("#version_txt").html(o),
                $("#version_val").html(a);
                var s = e.update_time,
                c = s.memo,
                r = s.value;
                $("#update_time_txt").html(c),
                $("#update_time_val").html(r);
                var h = e.os_list,
                d = h.memo,
                p = h.value;
                $("#os_list_txt").html(d),
                $("#os_list_val").html(p);
                var w = i.down_info,
                m = w.freedownload,
                l = m.memo,
                f = m.value;
                m.key;
                $(".download-txt").html(l),
                $(".download-url").attr("href", f);
                for (var g = w.other,
                u = "<a href=\"{value}\" onclick=\"_hmt.push(['_trackPageview', '/anquan_shadu/{key}']);\">{memo}</a>",
                v = "",
                x = 0,
                _ = g.length; _ > x; x++) {
                    var b = g[x];
                    v += u.replace(/\{value\}/g, b.value).replace(/\{key\}/g, b.key).replace(/\{memo\}/g, b.memo)
                }
                var y = '<div class="mv-info" id="mv_info" style="left:{left}px;top:{top}px"><div class="mv-info-cnt">{info}</div><div class="mv-infobg"></div></div>';
                v = y.replace(/\{info\}/g, v),
                this.MOREHTML = v
            }
        },
        lazyLoadBg: function() {
            var t = this;
            $(".load-bg").each(function(i) {
                var e = $(this);
                t.onScreen(e,
                function() {
                    t.loadedBg(e)
                })
            })
        },
        loadedBg: function(t) {
            var i = t.attr("data-cname");
            t.addClass(i)
        },
        onScreen: function(t, i) {
            var e = (t.outerWidth(), t.outerHeight(), t.offset()),
            n = e.top,
            o = (e.left, $(window).width(), $(window).height()),
            a = $(window).scrollTop(),
            s = a + o;
            if (n > a && s > n) {
                var c = t.attr("data-done");
                "done" == c || (i(), t.attr("data-done", "done"))
            }
        },
        showWinbar: function() {
            for (var t = ["winb", "winm", "winm", "winm", "wins", "wins"], t = [{
                name: "winb",
                width: 399,
                top: 35,
                xleft: 242
            },
            {
                name: "winm",
                width: 259,
                top: 199,
                xleft: -54
            },
            {
                name: "winm",
                width: 259,
                top: 113,
                xleft: 410
            },
            {
                name: "winm",
                width: 259,
                top: 133,
                xleft: -152
            },
            {
                name: "wins",
                width: 209,
                top: 187,
                xleft: 275
            },
            {
                name: "wins",
                width: 209,
                top: 0,
                xleft: 105
            }], i = "<div class='{win}' style='left:{left}px;top:{top}px;z-index:{zindex}'></div>", e = $(window).width(), n = e / 2, o = 0, a = t.length; a > o; o++) !
            function(e) {
                window.setTimeout(function() {
                    var o = t[e],
                    a = n - o.xleft,
                    s = o.top,
                    c = i.replace(/\{win\}/g, o.name).replace(/\{left\}/g, a).replace(/\{top\}/g, s).replace(/\{zindex\}/g, e);
                    $("#winbar").append(c),
                    $("." + o.name).fadeIn(700)
                },
                150 * o + 300)
            } (o);
            var s = -630,
            c = 0,
            r = i.replace(/\{win\}/g, "winl").replace(/\{left\}/g, s).replace(/\{top\}/g, c).replace(/\{zindex\}/g, 10);
            $("#winbar").append(r),
            window.setTimeout(function() {
                var t = n - 315;
                $(".winl").animate({
                    left: t + "px"
                },
                300);
                window.setTimeout(function() {
                    $(".winb,.wins,.winm").animate({
                        left: 3 * e + "px"
                    })
                },
                150)
            },
            1800)
        },
        adjustSec1: function() {
            var t = $(window).height();
            t = Math.max(t, 650);
            var i = $(".sec1").outerHeight(),
            e = t / i;
            $(".sec1").height(i * e);
            var n = $(".summary").css("padding-top");
            n = parseInt(n, 10),
            $(".summary").animate({
                "padding-top": n * e + "px"
            });
            var o = $(".downloadbar").css("margin-top");
            o = parseInt(o, 10),
            $(".downloadbar").css("margin-top", o * e + "px");
            var a = $(".more-tips").css("bottom");
            a = parseInt(a, 10),
            $(".more-tips").animate({
                bottom: a * e + "px"
            }),
            $(".download-url").on("click",
            function() {
                var t = ($(this).attr("href"), window.navigator.userAgent.toLowerCase());
                /(msie)|(trident)/g.test(t)
            })
        },
        showSec3: function() {
            var t = window.navigator.userAgent.toLowerCase();
            /msie 8.0/g.test(t) ? $(".circle_icon").show() : $(".circle_icon").fadeIn(1200,
            function() {}),
            $("#circlebar").addClass("animate");
            var i = $(window).width(),
            e = $(".circle_icon").outerWidth(),
            n = (i - e) / 2;
            $(".circle_icon").css({
                left: n + "px"
            });
            var e = $(".circle_wolf").outerWidth(),
            n = (i - e) / 2;
            $(".circle_wolf").css({
                left: n + "px"
            })
        },
        sec2_timer: [],
        showSec2: function() {
            var t = [{
                width: 648,
                height: 433,
                top: 0,
                opacity: 0,
                zindex: 10,
                    src:  "./Images/banner/1.png"
            },
            {
                width: 609,
                height: 407,
                top: 18,
                opacity: .9,
                zindex: 9,
                src:  "./Images/banner/4.png"
            },
            {
                width: 609,
                height: 407,
                top: 18,
                opacity: .9,
                zindex: 9,
                src: "./Images/banner/2.png"
            },
            {
                width: 573,
                height: 383,
                top: 37,
                opacity: .9,
                zindex: 7,
                src: "./Images/banner/3.png"
            },
            {
                width: 573,
                height: 383,
                top: 37,
                opacity: .9,
                zindex: 7,
                src: "./Images/banner/4.png"
            },
            {
                width: 536,
                height: 358,
                top: 55,
                opacity: .9,
                zindex: 5,
                src: "./Images/banner/5.png"
            },
            {
                width: 536,
                height: 358,
                top: 55,
                opacity: .9,
                zindex: 5,
                src: "./Images/banner/1.png"
            },
            {
                width: 491,
                height: 328,
                top: 74,
                opacity: .9,
                zindex: 3,
                src: "./Images/banner/2.png"
            },
            {
                width: 491,
                height: 328,
                top: 74,
                opacity: .9,
                zindex: 3,
                src: "./Images/banner/3.png"
            }],
            i = $(window).width(),
            e = i / 2,
            n = 1e3,
            o = t[0],
            a = e - o.width / 2,
            s = e - o.width / 2,
            c = a + o.width,
            r = this.getTplForSwitch({
                imgw: o.width,
                imgh: o.height,
                left: a,
                top: o.top,
                opacity: o.opacity,
                zindex: o.zindex,
                src: o.src
            });
            $("#switch_imgs").append(r),
            $("#switch_imgs").find("a").last().animate({
                opacity: 1
            },
            n),
            n = 500;
            var h = this,
            d = window.setTimeout(function() {
                var i = t[1],
                n = -e - i.width,
                o = h.getTplForSwitch({
                    imgw: i.width,
                    imgh: i.height,
                    left: n,
                    top: i.top,
                    opacity: i.opacity,
                    zindex: i.zindex,
                    src: i.src
                });
                $("#switch_imgs").prepend(o);
                var a = s - 89;
                $("#switch_imgs").find("a").first().animate({
                    left: a + "px"
                },
                300)
            },
            n + 200);
            this.sec2_timer.push(d);
            var p = window.setTimeout(function() {
                var i = t[2],
                n = e + i.width,
                o = h.getTplForSwitch({
                    imgw: i.width,
                    imgh: i.height,
                    left: n,
                    top: i.top,
                    opacity: i.opacity,
                    zindex: i.zindex,
                    src: i.src
                });
                $("#switch_imgs").append(o);
                var a = c - (i.width - 89);
                $("#switch_imgs").find("a").last().animate({
                    left: a + "px"
                },
                300)
            },
            n + 200);
            this.sec2_timer.push(p);
            var w = window.setTimeout(function() {
                var i = t[3],
                n = -e - i.width,
                o = h.getTplForSwitch({
                    imgw: i.width,
                    imgh: i.height,
                    left: n,
                    top: i.top,
                    opacity: i.opacity,
                    zindex: i.zindex,
                    src: i.src
                });
                $("#switch_imgs").prepend(o);
                var a = s - 164;
                $("#switch_imgs").find("a").first().animate({
                    left: a + "px"
                },
                300)
            },
            n + 300);
            this.sec2_timer.push(w);
            var m = window.setTimeout(function() {
                var i = t[4],
                n = e + i.width,
                o = h.getTplForSwitch({
                    imgw: i.width,
                    imgh: i.height,
                    left: n,
                    top: i.top,
                    opacity: i.opacity,
                    zindex: i.zindex,
                    src: i.src
                });
                $("#switch_imgs").append(o);
                var a = c - (i.width - 164);
                $("#switch_imgs").find("a").last().animate({
                    left: a + "px"
                },
                300)
            },
            n + 300);
            this.sec2_timer.push(m);
            var l = window.setTimeout(function() {
                var i = t[5],
                n = -e - i.width,
                o = h.getTplForSwitch({
                    imgw: i.width,
                    imgh: i.height,
                    left: n,
                    top: i.top,
                    opacity: i.opacity,
                    zindex: i.zindex,
                    src: i.src
                });
                $("#switch_imgs").prepend(o);
                var a = s - 219;
                $("#switch_imgs").find("a").first().animate({
                    left: a + "px"
                },
                300)
            },
            n + 500);
            this.sec2_timer.push(l);
            var f = window.setTimeout(function() {
                var i = t[6],
                n = e + i.width,
                o = h.getTplForSwitch({
                    imgw: i.width,
                    imgh: i.height,
                    left: n,
                    top: i.top,
                    opacity: i.opacity,
                    zindex: i.zindex,
                    src: i.src
                });
                $("#switch_imgs").append(o);
                var a = c - (i.width - 219);
                $("#switch_imgs").find("a").last().animate({
                    left: a + "px"
                },
                300)
            },
            n + 500);
            this.sec2_timer.push(f);
            var g = window.setTimeout(function() {
                var i = t[7],
                n = -e - i.width,
                o = h.getTplForSwitch({
                    imgw: i.width,
                    imgh: i.height,
                    left: n,
                    top: i.top,
                    opacity: i.opacity,
                    zindex: i.zindex,
                    src: i.src
                });
                $("#switch_imgs").prepend(o);
                var a = s - 264;
                $("#switch_imgs").find("a").first().animate({
                    left: a + "px"
                },
                300)
            },
            n + 600);
            this.sec2_timer.push(g);
            var u = window.setTimeout(function() {
                var i = t[8],
                n = e + i.width,
                o = h.getTplForSwitch({
                    imgw: i.width,
                    imgh: i.height,
                    left: n,
                    top: i.top,
                    opacity: i.opacity,
                    zindex: i.zindex,
                    src: i.src
                });
                $("#switch_imgs").append(o);
                var a = c - (i.width - 264);
                $("#switch_imgs").find("a").last().animate({
                    left: a + "px"
                },
                300)
            },
            n + 600);
            this.sec2_timer.push(u);
            window.setTimeout(function() {
                $("#switch_imgs a").on("click",
                function(t) {
                    t.preventDefault()
                })
            },
            1500);
            return
        },
        getCountVal: function(t) {
            for (var i = t.split("|"), e = 0, n = 0, o = i.length; o > n; n++) e += parseInt(i[n], 10);
            return e
        },
        stimer: null,
        autoSwitch: function(t) {
            var i = this,
            e = t[5];
            $("#switch_imgs a").each(function(t) {
                i.getSwitchInfo($(this)) == e && $(this).click()
            }),
            window.clearTimeout(this.stimer),
            this.stimer = window.setTimeout(function() {
                i.autoSwitch(t)
            },
            4e3)
        },
        getSwitchInfo: function(t) {
            var i = t.css("left"),
            e = t.css("top"),
            n = t.css("opacity"),
            o = t.css("z-index"),
            a = t.find("img").height(),
            s = t.find("img").width(),
            c = i + "|" + e + "|" + n + "|" + o + "|" + s + "|" + a;
            return c
        },
        getTplForSwitch: function(t) {
            var i = t.imgw,
            e = t.imgh,
            n = t.left,
            o = t.top,
            a = t.opacity,
            s = t.zindex,
            c = t.src,
            r = '<a href="#" style="left:{left}px;top:{top}px;opacity:{opacity};z-index:{zindex}"><img src="{src}" width="{width}" height="{height}"></a>',
            h = r.replace(/\{left\}/g, n).replace(/\{top\}/g, o).replace(/\{opacity\}/g, a).replace(/\{zindex\}/g, s).replace(/\{width\}/g, i).replace(/\{height\}/g, e).replace(/\{src\}/g, c);
            return h
        }
    };
    e.init();
}]);