"undefined" == typeof pdoPage && (pdoPage = {
    callbacks: {},
    keys: {},
    configs: {}
}),
    pdoPage.Reached = !1,
    pdoPage.initialize = function(a) {
        if (void 0 == pdoPage.keys[a.pageVarKey]) {
            var b = a.pageVarKey
                , c = pdoPage.Hash.get()
                , d = void 0 == c[b] ? 1 : c[b];
            pdoPage.keys[b] = Number(d),
                pdoPage.configs[b] = a
        }
        var e = this;
        switch (a.mode) {
            case "default":
                $(document).on("click", a.link, function(b) {
                    b.preventDefault();
                    var c = $(this).prop("href")
                        , d = a.pageVarKey
                        , f = c.match(new RegExp(d + "=(\\d+)"))
                        , g = f ? f[1] : 1;
                    pdoPage.keys[d] != g && (a.history && pdoPage.Hash.add(d, g),
                        e.loadPage(c, a))
                }),
                a.history && ($(window).on("popstate", function(b) {
                    b.originalEvent.state && b.originalEvent.state.pdoPage && e.loadPage(b.originalEvent.state.pdoPage, a)
                }),
                    history.replaceState({
                        pdoPage: window.location.href
                    }, ""));
                break;
            case "scroll":
            case "button":
                if (a.history) {
                    if ("undefined" == typeof jQuery().sticky)
                        return void $.getScript(a.assetsUrl + "js/lib/jquery.sticky.min.js", function() {
                            pdoPage.initialize(a)
                        });
                    pdoPage.stickyPagination(a)
                } else
                    $(a.pagination).hide();
                var f = a.pageVarKey;
                if ("button" == a.mode) {
                    $(a.rows).after(a.moreTpl);
                    var g = !1;
                    $(a.link).each(function() {
                        var a = $(this).prop("href")
                            , b = a.match(new RegExp(f + "=(\\d+)"))
                            , c = b ? b[1] : 1;
                        if (c > pdoPage.keys[f])
                            return g = !0,
                                !1
                    }),
                    g || $(a.more).hide(),
                        $(document).on("click", a.more, function(b) {
                            b.preventDefault(),
                                pdoPage.addPage(a)
                        })
                } else {
                    var h = $(a.wrapper)
                        , i = $(window);
                    i.on("scroll", function() {
                        !pdoPage.Reached && i.scrollTop() > h.height() - i.height() && (pdoPage.Reached = !0,
                            pdoPage.addPage(a))
                    })
                }
        }

        if (document.location.hash != "") {
            var hash = document.location.hash;
            hash = hash.replace(/\s/g, "_");
            hash = hash.replace(/&/g, "");
            hash = hash.replace(/%20/g, "_");
            hash = hash.replace("#", "");
            if ($('[data=' + hash + ']').length > 0) {
                // return false;
                //console.log(" СЃСѓС‰РµСЃС‚РІСѓРµС‚");
            } else {
                //console.log(" РЅРµ СЃСѓС‰РµСЃС‚РІСѓРµС‚");
                isset_product(hash);
            }
            $("div[data=" + hash + "]").css("box-shadow", "2px 2px 6px #FF4770, -2px -2px 6px #FF4770, -2px 2px 6px #FF4770, 2px -2px 6px #FF4770");
            $("div[data=" + hash + "]").attr('id', hash);
            $.scrollTo('#' + hash, 800, {
                offset: -80
            });
            // $('body').animate({scrollTop: $("div[data="+hash+"]").offset().top-100}, 800);
            // return false;
        }

        function isset_product(hash, a) {
            if ($('[data=' + hash + ']').length == 0) {
                pdoPage.addPage(a);
            }
        }
    }
    ,
    pdoPage.addPage = function(a) {
        var b = a.pageVarKey
            , c = pdoPage.keys[b] || 1;
        $(a.link).each(function() {
            var d = $(this).prop("href")
                , e = d.match(new RegExp(b + "=(\\d+)"))
                , f = e ? Number(e[1]) : 1;
            if (f > c)
                return a.history && pdoPage.Hash.add(b, f),
                    pdoPage.loadPage(d, a, "append"),
                    !1
        })
    }
    ,
    pdoPage.loadPage = function(a, b, c) {
        var d = $(b.wrapper)
            , e = $(b.rows)
            , f = $(b.pagination)
            , g = b.pageVarKey
            , h = a.match(new RegExp(g + "=(\\d+)"))
            , i = h ? Number(h[1]) : 1;
        if (c || (c = "replace"),
            pdoPage.keys[g] != i) {
            pdoPage.callbacks.before && "function" == typeof pdoPage.callbacks.before ? pdoPage.callbacks.before.apply(this, [b]) : ("scroll" != b.mode && d.css({
                opacity: .3
            }),
                d.addClass("loading"));
            var j = pdoPage.Hash.get();
            for (var k in j)
                j.hasOwnProperty(k) && pdoPage.keys[k] && k != g && delete j[k];
            j[g] = pdoPage.keys[g] = i,
                j.pageId = b.pageId,
                j.hash = b.hash,
                $.post(b.connectorUrl, j, function(a) {
                    a && a.total && (d.find(f).html(a.pagination),
                        "append" == c ? (d.find(e).append(a.output),
                            "button" == b.mode ? a.pages == a.page ? $(b.more).hide() : $(b.more).show() : "scroll" == b.mode && (pdoPage.Reached = !1)) : d.find(e).html(a.output),
                        pdoPage.callbacks.after && "function" == typeof pdoPage.callbacks.after ? pdoPage.callbacks.after.apply(this, [b, a]) : (d.removeClass("loading"),
                        "scroll" != b.mode && (d.css({
                            opacity: 1
                        }),
                        "default" == b.mode && $("html, body").animate({
                            scrollTop: d.position().top - 50 || 0
                        }, 0))),
                        pdoPage.updateTitle(b, a),
                        $(document).trigger("pdopage_load", [b, a]))
                }, "json")
        }
    }
    ,
    pdoPage.stickyPagination = function(a) {
        var b = $(a.pagination);
        b.is(":visible") && (b.sticky({
            wrapperClassName: "sticky-pagination",
            getWidthFrom: a.wrapper,
            responsiveWidth: !0,
            topSpacing: 2
        }),
            $(a.wrapper).trigger("scroll"))
    }
    ,
    pdoPage.updateTitle = function(a, b) {
        if ("undefined" != typeof pdoTitle) {
            for (var c = $("title"), d = pdoTitle.separator || " / ", e = pdoTitle.tpl, f = [], g = c.text().split(d), h = new RegExp("^" + e.split(" ")[0] + " "), i = 0; i < g.length; i++)
                1 === i && b.page && b.page > 1 && f.push(e.replace("{page}", b.page).replace("{pageCount}", b.pages)),
                g[i].match(h) || f.push(g[i]);
            c.text(f.join(d))
        }
    }
    ,
    pdoPage.Hash = {
        get: function() {
            var a, b, c, d = {};
            if (this.oldbrowser())
                c = decodeURIComponent(window.location.hash.substr(1)).replace("+", " "),
                    b = "/";
            else {
                var e = window.location.href.indexOf("?");
                c = e != -1 ? decodeURIComponent(window.location.href.substr(e + 1)).replace("+", " ") : "",
                    b = "&"
            }
            if (0 == c.length)
                return d;
            c = c.split(b);
            var f, g;
            for (var h in c)
                c.hasOwnProperty(h) && (a = c[h].split("="),
                    "undefined" == typeof a[1] ? d.anchor = a[0] : (f = a[0].match(/\[(.*?|)\]$/),
                        f ? (g = a[0].replace(f[0], ""),
                        d.hasOwnProperty(g) || ("" == f[1] ? d[g] = [] : d[g] = {}),
                            d[g]instanceof Array ? d[g].push(a[1]) : d[g][f[1]] = a[1]) : d[a[0]] = a[1]));
            return d
        },
        set: function(a) {
            var b = "";
            for (var c in a)
                if (a.hasOwnProperty(c))
                    if ("object" == typeof a[c])
                        for (var d in a[c])
                            a[c].hasOwnProperty(d) && (b += a[c]instanceof Array ? "&" + c + "[]=" + a[c][d] : "&" + c + "[" + d + "]=" + a[c][d]);
                    else
                        b += "&" + c + "=" + a[c];
            this.oldbrowser() ? window.location.hash = b.substr(1) : (0 != b.length && (b = "?" + b.substr(1)),
                window.history.pushState({
                    pdoPage: document.location.pathname + b
                }, "", document.location.pathname + b))
        },
        add: function(a, b) {
            var c = this.get();
            c[a] = b,
                this.set(c)
        },
        remove: function(a) {
            var b = this.get();
            delete b[a],
                this.set(b)
        },
        clear: function() {
            this.set({})
        },
        oldbrowser: function() {
            return !(window.history && history.pushState)
        }
    },
"undefined" == typeof jQuery && console.log("You must load jQuery for using ajax mode in pdoPage.");


