// =====================
// Get the cnt of the row
// =====================
function GetCnt(txt)
{
	limit = 0;
    pos = txt.indexOf("\n");
    cnt = txt.substring(0, pos);
    while ((cnt.length == 0) && (limit < 50))
    {
    	txt = txt.substring(pos + 1);
        pos = txt.indexOf("\n");
        cnt = txt.substring(0, pos);
        limit++;
    }
    if (limit >= 50)
    {
    	alert("did not find cnt");
    	cnt = 0    	
    }
	return cnt;
}
// ======================
// Create Popup.
// ======================
function popUp(options)
{

    $.get(options.content, options, function (data)
    {
        // Popup HTML.
        html = '<div id="popup">\n\
                 <div class="pane"><div class="header"><h1>' + options.title + '</h1><a href="#" title="Close" class="site_btn pop_close_btn" id="popup-close">Close</a></div>\n\
                    <div class="pane_content"><div class="feedback" style="display:none;"></div>';
        html += data;
        html += '</div></div><div class="pane_footer"></div></div><div id="popup_contain"></div>';
        $('body').prepend(html);
        if (typeof options.postLoad == "function")
        {
            options.postLoad();
        }

        if (typeof options.callback == "function") 
        {
        	options.callback();
        }

        // Common Popup Functionality.
        // Center Popup, Block User from rest of site.
        $('#popup_contain').height($('body').height());
        $('#popup_contain').hide().fadeIn('fast');
        $('#popup').center().hide().fadeIn('fast');
        $(window).bind('scroll', function ()
        {
            $('#popup').center();
        });
        // Popup Cancel / Close.
        $('#popup-close').bind('click', function ()
        {
        	doEdit = 0;
        	doDelete = 0;
        	doView = 0;
        	doTask = 0;
            $(window).unbind('scroll');
            $('#popup_contain').fadeOut('fast', function ()
            {
                $(this).remove();
            });
            $('#popup').fadeOut('fast', function ()
            {
                $(this).remove();
            });
        });
    });
}

// ======================
// Create Popup.
// ======================
function popUpWide(options)
{

    $.get(options.content, options, function (data)
    {
        // Popup HTML.
        html = '<div id="popUpWide">\n\
                 <div class="pane"><div class="header"><h1>' + options.title + '</h1><a href="#" title="Close" class="site_btn pop_close_btn" id="popup-close">Close</a></div>\n\
                    <div class="pane_content"><div class="feedback" style="display:none;"></div>';
        html += data;
        html += '</div></div><div class="pane_footer"></div></div><div id="popup_contain"></div>';
        $('body').prepend(html);
        if (typeof options.postLoad == "function")
        {
            options.postLoad();
        }

        if (typeof options.callback == "function") 
        {
        	options.callback();
        }

        // Common Popup Functionality.
        // Center Popup, Block User from rest of site.
        $('#popup_contain').height($('body').height());
        $('#popup_contain').hide().fadeIn('fast');
        $('#popUpWide').center().hide().fadeIn('fast');
        $(window).bind('scroll', function ()
        {
            $('#popUpWide').center();
        });
        // Popup Cancel / Close.
        $('#popup-close').bind('click', function ()
        {
        	doEdit = 0;
        	doDelete = 0;
        	doView = 0;
        	doTask = 0;
            $(window).unbind('scroll');
            $('#popup_contain').fadeOut('fast', function ()
            {
                $(this).remove();
            });
            $('#popUpWide').fadeOut('fast', function ()
            {
                $(this).remove();
            });
        });
    });
}

/*
function popUpWide(options)
{
    alert("popUpWide");
    $.get(options.content, options, function (data)
    {
    	alert("done get");
        // Popup HTML.
    	html = '<div id="popUpWide">\n\
                 <div class="pane"><div class="header"><h1>' + options.title + '</h1><a href="#" title="Close" class="site_btn pop_close_btn" id="popup-close">Close</a></div>\n\
                    <div class="pane_content"><div class="feedback" style="display:none;"></div>';
        html += data;
        html += '</div></div><div class="pane_footer"></div></div><div id="popup_contain"></div>';
    	$('body').prepend(html);
        if (typeof options.postLoad == "function")
        {
            options.postLoad();
        }

        if (typeof options.callback == "function") options.callback();

        // Common Popup Functionality.
        // Center Popup, Block User from rest of site.
        $('#popup_contain').height($('body').height());
        $('#popup_contain').hide().fadeIn('fast');
        $('#popUpWide').center().hide().fadeIn('fast');
        $(window).bind('scroll', function ()
        {
            $('#popup').center();
        });
        // Popup Cancel / Close.
        $('#popup-close').bind('click', function ()
        {
        	doEdit = 0;
        	doDelete = 0;
        	doView = 0;
        	doTask = 0;

            $(window).unbind('scroll');
            $('#popup_contain').fadeOut('fast', function ()
            {
                $(this).remove();
            });
            $('#popUpWide').fadeOut('fast', function ()
            {
                $(this).remove();
            });
        });
    },'json');
    alert("popupWide done");
}
*/
function reorderMain($list)
{
    // Reorder.
    var cnt = 0;
    $('.list_num', $list).each(function ()
    {
        cnt++;
        $(this).text(cnt+".");
    });
}

function urldecode(data)
{
    return unescape(String(data).replace(/\+/g, " "));
}
jQuery.fn.center = function ()
{
    this.css("position", "absolute");
    this.css("top", '50px'); //( $(window).height() - this.height() ) / 2+$(window).scrollTop() + "px");
    this.css("left", ($(window).width() - this.width()) / 2 + $(window).scrollLeft() + "px");
    return this;
}
$(document).ready(function ()
{

    // Real Popup Window.  Simply add class 'to_popup' on a link.
    $('.to_popup').on('click', function ()
    {
        if (!$(this).is('disable_click'))
        {
            var title = $(this).attr('title');
            var url = $(this).attr('href');
            //thepopup = window.open( url, title, "toolbar=0,location=0,directories=0,menubar=0,resizable=1,width=800,height=800,scrollbars=1",false );
            thepopup = window.open(url, "_blank", "toolbar=0,location=0,directories=0,menubar=0,resizable=1,width=800,height=800,scrollbars=1");
            thepopup.focus();
        }
        return false;
    });

    $('.to_popup_embed').on('click', function ()
    {
        //$(this).unbind('click');
        link = $(this).attr('href'); //teacherPath+"/ajax/assessments/newAssessment.php";

        options = {};
        options.content = link;
        options.title = $(this).attr('title');

        // Popup HTML.
        html = '<div id="popup" class="lrg_popup">\n\
                 <div class="pane"><div class="header"><h1>' + options.title + '</h1><a href="#" title="Close" class="site_btn pop_close_btn" id="popup-close">Close</a></div>\n\
                    <div class="pane_content"><div class="feedback" style="display:none;"></div>';
        html += '<iframe src="' + link + '" width="100%" frameborder="0" scrolling="no" class="iframe"></iframe>';
        html += '</div></div><div class="pane_footer"></div></div><div id="popup_contain"></div>';
        $('body').prepend(html);
        if (typeof options.postLoad == "function")
        {
            options.postLoad();
        }

        if (typeof options.callback == "function") options.callback();

        // Common Popup Functionality.
        // Center Popup, Block User from rest of site.
        $('#popup_contain').height($('body').height());
        $('#popup_contain').hide().fadeIn('fast');
        $('#popup').center().hide().fadeIn('fast');
        $(window).bind('scroll', function ()
        {
            $('#popup').center();
        });
        // Popup Cancel / Close.
        $('#popup-close').bind('click', function ()
        {
            $(window).unbind('scroll');
            $('#popup_contain').fadeOut('fast', function ()
            {
                $(this).remove();
            });
            $('#popup').fadeOut('fast', function ()
            {
                $(this).remove();
            });
        });
        var iFrames = $('iframe');

        function iResize()
        {

            for (var i = 0, j = iFrames.length; i < j; i++)
            {
                iFrames[i].style.height = iFrames[i].contentWindow.document.body.offsetHeight + 'px';
            }
        }

        if ($.browser.safari || $.browser.opera)
        {
            iFrames.load(function ()
            {
                setTimeout(iResize, 0);
            });

            for (var i = 0, j = iFrames.length; i < j; i++)
            {
                var iSource = iFrames[i].src;
                iFrames[i].src = '';
                iFrames[i].src = iSource;
            }
        }
        else
        {
            iFrames.load(function ()
            {
                this.style.height = this.contentWindow.document.body.offsetHeight + 'px';
            });
        }

        return false;
    });

    function printIframe(id)
    {
        var iframe = document.frames ? document.frames[id] : document.getElementById(id);
        var ifWin = iframe.contentWindow || iframe;
        flipOff = false;
        if ($('#' + id).hasClass('hidden'))
        {
            flipOff = true;
            $('#' + id).removeClass('hidden');
        }

        iframe.focus();
        ifWin.print();
        if (flipOff) $('#' + id).addClass('hidden');
        return false;
    }

    $('.print_resource').bind('click', function ()
    {
        if ($('#embed_pdf').length != 0)
        {

            printIframe('embed_pdf');
        }
        else
        {
            window.print();
        }
        return false;
    });

});

// Table sort.
function sortUnorderedList(ul, sortDescending)
{
    if (typeof ul == "string") ul = document.getElementById(ul);

    // Idiot-proof, remove if you want
    if (!ul)
    {
        alert("The UL object is null!");
        return;
    }

    // Get the list items and setup an array for sorting
    var lis = ul.getElementsByTagName("LI");
    var vals = [];

    // Populate the array
    for (var i = 0, l = lis.length; i < l; i++)
    vals.push(lis[i].innerHTML);

    // Sort it
    vals.sort();

    // Sometimes you gotta DESC
    if (sortDescending) vals.reverse();

    // Change the list on the page
    for (var i = 0, l = lis.length; i < l; i++)
    lis[i].innerHTML = vals[i];
}

(function (b)
{
    b.tinysort = {
        id: "TinySort",
        version: "1.0.4",
        defaults: {
            order: "asc",
            attr: "",
            place: "start",
            returns: false
        }
    };
    b.fn.extend(
    {
        tinysort: function (h, j)
        {
            if (h && typeof (h) != "string")
            {
                j = h;
                h = null
            }
            var e = b.extend(
            {}, b.tinysort.defaults, j);
            var p = {};
            this.each(function (t)
            {
                var v = (!h || h == "") ? b(this) : b(this).find(h);
                var u = e.order == "rand" ? "" + Math.random() : (e.attr == "" ? v.text() : v.attr(e.attr));
                var s = b(this).parent();
                if (!p[s])
                {
                    p[s] = {
                        s: [],
                        n: []
                    }
                }
                if (v.length > 0)
                {
                    p[s].s.push(
                    {
                        s: u,
                        e: b(this),
                        n: t
                    })
                }
                else
                {
                    p[s].n.push(
                    {
                        e: b(this),
                        n: t
                    })
                }
            });
            for (var g in p)
            {
                var d = p[g];
                d.s.sort(function k(t, s)
                {
                    var i = t.s.toLowerCase ? t.s.toLowerCase() : t.s;
                    var u = s.s.toLowerCase ? s.s.toLowerCase() : s.s;
                    if (c(t.s) && c(s.s))
                    {
                        i = parseFloat(t.s);
                        u = parseFloat(s.s)
                    }
                    return (e.order == "asc" ? 1 : -1) * (i < u ? -1 : (i > u ? 1 : 0))
                })
            }
            var m = [];
            for (var g in p)
            {
                var d = p[g];
                var n = [];
                var f = b(this).length;
                switch (e.place)
                {
                case "first":
                    b.each(d.s, function (s, t)
                    {
                        f = Math.min(f, t.n)
                    });
                    break;
                case "org":
                    b.each(d.s, function (s, t)
                    {
                        n.push(t.n)
                    });
                    break;
                case "end":
                    f = d.n.length;
                    break;
                default:
                    f = 0
                }
                var q = [0, 0];
                for (var l = 0; l < b(this).length; l++)
                {
                    var o = l >= f && l < f + d.s.length;
                    if (a(n, l))
                    {
                        o = true
                    }
                    var r = (o ? d.s : d.n)[q[o ? 0 : 1]].e;
                    r.parent().append(r);
                    if (o || !e.returns)
                    {
                        m.push(r.get(0))
                    }
                    q[o ? 0 : 1]++
                }
            }
            return this.pushStack(m)
        }
    });

    function c(e)
    {
        var d = /^\s*?[\+-]?(\d*\.?\d*?)\s*?$/.exec(e);
        return d && d.length > 0 ? d[1] : false
    }

    function a(e, f)
    {
        var d = false;
        b.each(e, function (h, g)
        {
            if (!d)
            {
                d = g == f
            }
        });
        return d
    }
    b.fn.TinySort = b.fn.Tinysort = b.fn.tsort = b.fn.tinysort
})(jQuery);