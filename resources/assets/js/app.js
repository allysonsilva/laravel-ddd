var App = function () {
    "use strict";
    var e, t, i, o, r, l, s, c, d, u, p, h, f, g, m, b, v = {
            leftSidebarSlideSpeed: 200,
            leftSidebarToggleSpeed: 300,
            enableLeftSidebar: !0,
            enableSwipe: !0,
            swipeTreshold: 100,
            scrollTop: !0,
            openLeftSidebarClass: "open-left-sidebar",
            disabledLeftSidebarClass: "app-left-sidebar-disabled",
            offCanvasLeftSidebarClass: "app-offcanvas-menu",
            offCanvasLeftSidebarMobileClass: "app-offcanvas-menu-sm",
            topHeaderMenuClass: "app-top-menu",
            closeRsOnClickOutside: !0,
            removeLeftSidebarClass: "app-nosidebar-left",
            collapsibleSidebarClass: "app-collapsible-sidebar",
            collapsibleSidebarCollapsedClass: "app-collapsible-sidebar-collapsed",
            openLeftSidebarOnClick: !0,
            transitionClass: "app-animate",
            openSidebarDelay: 400
        },
        w = {},
        k = {};

    function y(e) {
        var t = $("<div>", {
                class: e
            }).appendTo("body"),
            i = t.css("background-color");
        return t.remove(), i
    }

    function C(e) {
        void 0 !== e && e.update()
    }

    function S(e) {
        e.destroy()
    }

    function x(e) {
        if (void 0 !== e[0]) return new PerfectScrollbar(e[0], {
            wheelPropagation: !1
        })
    }

    function T() {
        s = !0, setTimeout(function () {
            s = !1
        }, v.openSidebarDelay)
    }

    function M() {
        void 0 !== c && c && c.nodeName || (c = x(r))
    }

    var E, P = (E = {}, function (e, t, i) {
        i || (i = "x1x2x3x4"), E[i] && clearTimeout(E[i]), E[i] = setTimeout(e, t)
    });

    return {
        conf: v,
        color: w,
        scroller: k,
        init: function (E) {
            var B, L;
            (e = $("body"), t = $(".app-wrapper"), i = $(".app-top-header", t), o = $(".app-left-sidebar", t), l = $(".app-toggle-left-sidebar", i), s = !1, $.extend(v, E), FastClick.attach(document.body), v.enableLeftSidebar ? function () {
                var n, a, r = $(".sidebar-elements > li > a", o),
                    c = $(".sidebar-elements li a", o),
                    h = $(".left-sidebar-scroll", o),
                    f = $(".left-sidebar-toggle", o),
                    g = !!v.openLeftSidebarOnClick;

                function m() {
                    return t.hasClass(v.collapsibleSidebarCollapsedClass)
                }

                function b(e, i) {
                    var n = $(i.currentTarget),
                        a = $(e).parent(),
                        r = $("li.open", a),
                        l = !n.closest(o).length,
                        s = v.leftSidebarSlideSpeed,
                        c = n.parents().eq(1).hasClass("sidebar-elements");
                    !$.isSm() && m() && (c || l) ? (a.removeClass("open"), e.removeClass("visible"), r.removeClass("open").removeAttr("style")) : e.slideUp({
                        duration: s,
                        complete: function () {
                            a.removeClass("open"), $(this).removeAttr("style"), r.removeClass("open").removeAttr("style"), t.hasClass("app-fixed-sidebar") && !$.isSm() && C(d)
                        }
                    })
                }

                function w(e, i) {
                    var o = $(e),
                        n = $(o).parent(),
                        a = $(o).next(),
                        r = v.leftSidebarSlideSpeed,
                        l = $(i.currentTarget).parents().eq(1).hasClass("sidebar-elements"),
                        s = n.siblings(".open");
                    s && b($("> ul", s), i), !$.isSm() && m() && l ? (n.addClass("open"), a.addClass("visible"), void 0 !== p && S(p), void 0 !== p && p && p.nodeName || (p = x(n.find(".app-scroller"))), $(window).resize(function () {
                        P(function () {
                            $.isXs() || void 0 !== p && C(p)
                        }, 500, "am_check_phone_classes")
                    })) : a.slideDown({
                        duration: r,
                        complete: function () {
                            n.addClass("open"), $(this).removeAttr("style"), t.hasClass("app-fixed-sidebar") && !$.isSm() && C(d)
                        }
                    })
                }
                t.hasClass(v.collapsibleSidebarClass) && (a = void 0 !== n ? n : $(".sidebar-elements > li", o), $.each(a, function () {
                    var e = $(this).find("> a span").html(),
                        t = $(this).find("> ul"),
                        i = $("> li", t);
                    e = $('<li class="title">' + e + "</li>");
                    var o = $('<li class="nav-items"><div class="app-scroller"><div class="content"><ul></ul></div></div></li>');
                    t.find("> li.title").length || (t.prepend(e), i.appendTo(o.find(".content ul")), o.appendTo(t))
                }), $(".app-toggle-left-sidebar").on("click", function () {
                    t.hasClass(v.collapsibleSidebarCollapsedClass) ? (t.removeClass(v.collapsibleSidebarCollapsedClass), $("li.open", o).removeClass("open"), $("li.active", o).parents(".parent").addClass("active open"), o.trigger("shown.left-sidebar.collapse"), void 0 !== u && u && u.nodeName || (u = x($(".app-scroller", o))), S(u), void 0 !== p && S(p)) : (t.addClass(v.collapsibleSidebarCollapsedClass), $("li.active", o).parents(".parent").removeClass("open"), $("li.open", o).removeClass("open"), o.trigger("hidden.left-sidebar.collapse"))
                }), function () {
                    for (var e = $(".sidebar-elements > li > a", o), i = 0; i <= e.length; i++) {
                        var n = e[i],
                            a = $("> span", n).text();
                        $(n).attr({
                            "data-toggle": "tooltip",
                            "data-placement": "right",
                            title: a
                        }), $(n).tooltip({
                            trigger: "manual"
                        })
                    }
                    e.on("mouseenter", function () {
                        !$.isSm() && t.hasClass(v.collapsibleSidebarCollapsedClass) && $(this).tooltip("show")
                    }), e.on("mouseleave", function () {
                        $(this).tooltip("hide")
                    })
                }(), g || (r.on("mouseover", function (e) {
                    m() && w(this, e)
                }), r.on("touchstart", function (e) {
                    var t = $(this),
                        i = t.parent(),
                        o = t.next();
                    m() && !$.isSm() && (i.hasClass("open") ? b(o, e) : w(this, e), $(this).next().is("ul") && e.preventDefault())
                }), r.on("mouseleave", function (e) {
                    var t = $(this),
                        i = t.parent(),
                        o = i.find("> ul");
                    !$.isSm() && m() && (o.length > 0 ? setTimeout(function () {
                        o.is(":hover") ? o.on("mouseleave", function () {
                            setTimeout(function () {
                                t.is(":hover") || (b(o, e), o.off("mouseleave"))
                            }, 300)
                        }) : b(o, e)
                    }, 300) : i.removeClass("open"))
                })), $(document).on("mousedown touchstart", function (e) {
                    $(e.target).closest(o).length || $.isSm() || b($("ul.visible", o), e)
                })), c.on("click", function (e) {
                    var t = $(this),
                        i = t.parent(),
                        o = t.next();
                    t.parents().eq(1).hasClass("sidebar-elements"), i.siblings(".open"), i.hasClass("open") ? b(o, e) : w(this, e), t.next().is("ul") && e.preventDefault()
                }), t.hasClass(v.collapsibleSidebarCollapsedClass) ? $("li.active", o).parents(".parent").addClass("active") : $("li.active", o).parents(".parent").addClass("active open"), i.find(".container-fluid > .navbar-collapse").length && o.length && (t.addClass(v.offCanvasLeftSidebarClass).addClass(v.offCanvasLeftSidebarMobileClass), t.addClass(v.topHeaderMenuClass), l = $('<a class="nav-link app-toggle-left-sidebar" href="#"><span class="icon mdi mdi-menu"></span></a>'), $(".app-navbar-header", i).prepend(l)), t.hasClass("app-fixed-sidebar") && ($.isSm() && !t.hasClass(v.offCanvasLeftSidebarClass) || void 0 !== d && d && d.nodeName || (d = x(h)), $(window).resize(function () {
                    P(function () {
                        $.isSm() && !t.hasClass(v.offCanvasLeftSidebarClass) ? S(d) : h.hasClass("ps") ? C(d) : void 0 !== d && d && d.nodeName || (d = x(h))
                    }, 500, "app_update_scroller")
                })), f.on("click", function (e) {
                    var t = $(this).next(".left-sidebar-spacer");
                    $(this).toggleClass("open"), t.slideToggle(v.leftSidebarToggleSpeed, function () {
                        $(this).removeAttr("style").toggleClass("open")
                    }), e.preventDefault()
                }), t.hasClass(v.offCanvasLeftSidebarClass) && (l.on("click", function (t) {
                    s && e.hasClass(v.openLeftSidebarClass) ? (e.removeClass(v.openLeftSidebarClass), T()) : (e.addClass(v.openLeftSidebarClass + " " + v.transitionClass), s = !0), t.preventDefault()
                }), $(document).on("mousedown touchstart", function (t) {
                    $(t.target).closest(o).length || $(t.target).closest(l).length || !e.hasClass(v.openLeftSidebarClass) || (e.removeClass(v.openLeftSidebarClass), T())
                }))
            }() : null, v.scrollTop && ((B = $('<div class="app-scroll-top"></div>')).appendTo("body"), $(window).on("scroll", function () {
                $(this).scrollTop() > 220 ? B.fadeIn(500) : B.fadeOut(500)
            }), B.on("touchstart mouseup", function (e) {
                $("html, body").animate({
                    scrollTop: 0
                }, 500), e.preventDefault()
            })), w.primary = y("clr-primary"), w.success = y("clr-success"), w.warning = y("clr-warning"), w.danger = y("clr-danger"), w.grey = y("clr-grey"), k.app_scroller_notifications = c, k.left_sidebar_scroll = d, k.app_left_sidebar_scroll = u, k.sub_menu_scroll = p, k.chat_scroll = h, k.todo_scroll = f, k.settings_scroll = g, k.messages_scroll = m, k.aside_scroll = b, k.updateScroller = C, k.destroyScroller = S, k.initScroller = x, $(".app-icons-nav .dropdown").on("shown.bs.dropdown", function () {
                C(c)
            }), $(".modal").on("show.bs.modal", function () {
                $("html").addClass("app-modal-open")
            }), $(".modal").on("hidden.bs.modal", function () {
                $("html").removeClass("app-modal-open")
            }), "function" == typeof Swal && t.hasClass("app-boxed-layout")) && new MutationObserver(function (e, t) {
                e.forEach(function (e) {
                    "attributes" == e.type && "style" == e.attributeName && (document.body.className.indexOf("swal2-shown") > 0 ? i.css({
                        marginLeft: "calc(-" + document.body.style.paddingRight + " / 2)"
                    }) : i.css({
                        marginLeft: "0"
                    }))
                })
            }).observe(document.body, {
                attributes: !0
            })
        },
        activeItemLeftSidebar: function (e) {
            var t = $(e).parent(),
                i = $(t).parents("li");
            t.hasClass("active") || ($("li.active", o).removeClass("active"), $(i).addClass("active"), $(t).addClass("active"))
        }
    }
}();

App = function () {
    "use strict";
    return App.formElements = function () {
        $(".inputfile").each(function () {
            var e = $(this),
                t = e.next("label"),
                i = t.html();
            e.on("change", function (e) {
                var o = "";
                this.files && this.files.length > 1 ? o = (this.getAttribute("data-multiple-caption") || "").replace("{count}", this.files.length) : e.target.value && (o = e.target.value.split("\\").pop()), o ? t.find("span").html(o) : t.html(i)
            })
        }), bsCustomFileInput.init()
    }, App
}();

window.App = App;
