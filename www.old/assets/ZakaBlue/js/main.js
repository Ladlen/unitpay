/*
 //http://habrahabr.ru/post/64173/
 setEqualHeight($(".center_main > div"));
 function setEqualHeight(columns) {
 var tallestcolumn = 0;
 columns.each(function() {
 currentHeight = $(this).height();
 if (currentHeight > tallestcolumn)
 tallestcolumn = currentHeight;
 });
 columns.height(tallestcolumn);
 }
 */
/*
 * 	Easy Slider 1.7 - jQuery plugin
 *	written by Alen Grakalic	
 *	http://cssglobe.com/post/4004/easy-slider-15-the-easiest-jquery-plugin-for-sliding
 *
 *	Copyright (c) 2009 Alen Grakalic (http://cssglobe.com)
 *	Dual licensed under the MIT (MIT-LICENSE.txt)
 *	and GPL (GPL-LICENSE.txt) licenses.
 *
 *	Built for jQuery library
 *	http://jquery.com
 *
 */

(function($) {
    $.fn.easySlider = function(options) {

        var defaults = {
            controlsFade: true,
            speed: 700,
            auto: false,
            pause: 8000,
            thumb: false
        };
        var options = $.extend(defaults, options);
        // this.each(function() {
        var obj = $(this);
        var s = $("li", obj).length;
        var w = $("li", obj).width();
        var h = $("li", obj).height();
        var clickable = true;
        obj.width(w);
        obj.height(h);
        //obj.css("overflow", "hidden");
        var ts = s - 1;
        var t = 0;
        //$("ul", obj).css('width', s * w);
        $("ul", obj).prepend($("ul li:last-child", obj).clone().css("margin-left", "-" + w + "px"));
        $("ul", obj).append($("ul li:nth-child(2)", obj).clone());
        $("ul", obj).css('width', (s + 1) * w);
        $("li", obj).css('float', 'left');
        if (options.thumb) {
            var barMove = false;
            var prevPos = 0;
            var pSize = 11;
            var step = Math.round(w / ts);
            var th_w = 143;
            var oStep = 0;
            /* Avoid text and image selection while dragging  */
            document.body.onselectstart = function() {
                if (barMove)
                    return false;
                else
                    return true;
            };
            var alen = $("a", obj).length - 1;
            $("a", obj).each(function(i) {
                if ($(this).attr('class') != 'video' && i > 0 && i < alen) {
                    $(this).attr('data-lightbox', 'screen');
                    $(this).click(function() {
                        clearTimeout(timeout);
                    });
                } else if ($(this).attr('class') == 'video') {
                    $(this).click(function() {
                        clearTimeout(timeout);
                        var html = '<iframe width="562" height="322" src="' + $(this).attr('href') + '" frameborder="0" allowfullscreen></iframe>';
                        $(this).attr('href', 'javascript:void(0);');
                        $(this).html(html);
                    });
                }
            });
            $(obj).after('<div class="bgControls"><div id="controls"></div></div><div class="sliderBar"><div id="line"></div><div id="bar"></div><div id="sliderBar"></div></div>');
            $("#sliderBar").mousedown(function(event) {
                var diff = event.pageX - $('#bar').offset().left;
                if (diff >= -2 && diff <= 13) {
                    clearTimeout(timeout);
                    barMove = true;
                    prevPos = event.pageX;
                    $('#bar').css('background-color', '#f8f8f8');
                }
                else if (diff < -2)
                    animate("prev", true);
                else if (diff > 13)
                    animate("next", true);
            });
            $("#sliderBar").mouseout(function() {
                mouseDrop();
            });
            $("#sliderBar").mouseup(function() {
                mouseDrop();
            });
            $("#sliderBar").mousemove(function(event) {
                if (barMove) {
                    var left = $('#bar').position().left;

                    var shift = (left + event.pageX - prevPos);
                    if (shift < 0)
                        shift = 0;
                    else if (shift >= (w - pSize))
                        shift = w - pSize;
                    $('#bar').css('left', shift);
                    $("ul", obj).css("margin-left", -(shift) * ts);
                    prevPos = event.pageX;

                    var nStep = Math.round(left / step);
                    if (oStep != nStep) {
                        setCurrent(nStep, true);
                        oStep = nStep;
                    }
                }
            });
            $('#controls').css('width', (s + 1) * th_w);
            for (var i = 0; i < s; i++) {
                $(document.createElement("span"))
                        .attr('id', 'controls' + (i + 1))
                        .html('<A rel=' + i + ' href=\"javascript:void(0);\">' + $("ul li:nth-child(" + (i + 2) + ") span", obj).html() + '</A>')
                        .appendTo($("#controls"))
                        .click(function() {
                    animate($("a", $(this)).attr('rel'), true);
                });
            }

        } else {
            $("a", obj).click(function() {
                clearTimeout(timeout);
            });
            var html = '<span id="prevBtn"><a href=\"javascript:void(0);\">&nbsp;</a></span>';
            html += '<span id="nextBtn"><a href=\"javascript:void(0);\">&nbsp;</a></span>';
            $(obj).append(html);
            $("a", "#nextBtn").click(function() {
                animate("next", true);
            });
            $("a", "#prevBtn").click(function() {
                animate("prev", true);
            });
        }

        function mouseDrop() {
            if (barMove) {
                barMove = false;
                $('#bar').css('background-color', '#8e8e8e');
                if (prevPos > 0) {
                    var left = $('#bar').position().left;
                    var newT = Math.round(left / step);
                    animate(newT, true);
                    prevPos = 0;
                }
            }
        }

        function setCurrent(t, nobar) {
            if (t > ts)
                t = 0;
            if (t < 0)
                t = ts;
            if (ts > 3)
                moveControls(t, nobar);
            if (!nobar) {
                var barShift = t * step;
                if (t == ts)
                    barShift = w - pSize;
                $('#bar').animate(
                        {left: barShift},
                {queue: false, duration: options.speed}
                );
            }
            t = parseInt(t) + 1;
            $("span", "#controls").removeClass("current");
            $("span#controls" + t).addClass("current");
        }

        function moveControls(t, notanim) {
            var shift = 0;

            if (t < ts) { //-1
                if (t > 2)
                    shift = -((t - 2) * th_w); //-1

                //$('#helper').html('s:' + shift + ' <br>t:' + t + ' (' + (ot) + ') <br>p:' + page + ' (' + (opage) + ') (' + pages + ') (' + lpes + ')');
                if (!notanim) {
                    $('#controls').animate(
                            {marginLeft: shift},
                    {queue: false, duration: options.speed}
                    );
                } else
                    $('#controls').css("margin-left", shift);
            }
        }

        function adjust() {
            if (t > ts)
                t = 0;
            if (t < 0)
                t = ts;
            $("ul", obj).css("margin-left", (t * w * -1));
            clickable = true;
        }

        function wait() {
            clearTimeout(timeout);
        }

        function animate(dir, clicked) {
            if (clickable) {
                clickable = false;
                var ot = t;
                switch (dir) {
                    case "next":
                        t = parseInt(t) + 1;
                        break;
                    case "prev":
                        t = parseInt(t) - 1;
                        break;
                    default:
                        t = parseInt(dir);
                        break;
                }

                if (options.thumb)
                    setCurrent(t);
                $("ul", obj).animate(
                        {marginLeft: (t * w * -1)},
                {queue: false, duration: options.speed, complete: adjust}
                );
                if (clicked)
                    clearTimeout(timeout);
                if (options.auto && dir == "next" && !clicked) {
                    timeout = setTimeout(function() {
                        animate("next", false);
                    }, options.speed + options.pause);
                }
            }
        }

// init
        var timeout;
        if (options.auto) {
            timeout = setTimeout(function() {
                animate("next", false);
            }, options.pause);
        }

        if (options.thumb)
            setCurrent(0);
        //   });

    };
})(jQuery);

//search
(function($) {
    $.fn.Search = function() {
        var timeout;
        var current = -1;
        var sugs = 0;
        var run = false;

        var cache = {};
        //$(this).append('<div id="helper" style="position:absolute;background-color:#ffffff;top:230px;right:0px;z-index:9999; text-align:left;">---</div>');
        $(this).append('<div id="searchsug"></div>');
        var input = $('#search .text');

        function ajaxSearch(e) {
            if (input.val().length < 2 || input.val().length >= 80) {
                $('#searchsug').hide();
                $('#searchsug').empty();
                //input.removeClass('active');
                return false;
            }
            //8 = backspace
            if (e.keyCode == 38) { //up
                $('#sug' + current).removeClass('selected');
                current--;
                if (current < 0)
                    current = sugs - 1;
                $('#sug' + current).addClass('selected');
                $('helper').html($('#sug' + current).prop('href'));
            } else if (e.keyCode == 40) { //down
                $('#sug' + current).removeClass('selected');
                current++;
                if (current >= sugs)
                    current = 0;
                $('#sug' + current).addClass('selected');
                $('helper').html($('#sug' + current).prop('href'));
            } else {
                input.addClass('active');
                getSug(input.val());
            }
        }

        function getSug(val) {
            $('#searchsug').hide();
            $('#searchsug').empty();

            if (val.length >= 2 && run) {
                current = -1;

                if (typeof cache[val] != 'undefined')
                    drawSug(cache[val]);
                else
                    $.get('/search/ajax/?game=' + val, function(data) {
                        if (data) {
                            cache[val] = data;
                            drawSug(data);
                        }
                    }, 'json');
            }
        }

        function drawSug(data) {
            clearTimeout(timeout);
            $('#searchsug').empty();
            $('#searchsug').show();
            $.each(data, function(i) {
                $('#searchsug').append('<a id="sug' + i + '" rel="' + i + '" href="/game/' + this.url + '">' + this.name + '</a>');
                $('#sug' + i).hover(function() {
                    $('#sug' + current).removeClass('selected');
                    current = $(this).attr('rel');
                    $(this).addClass('selected');
                });
            });
            sugs = data.length;
        }

        input.on('keydown', input, function(e) { //tab + enter
            var keyCode = e.keyCode || e.which;
            if (keyCode == 9) {
                if ($('#searchsug').css('display') == 'block') {
                    var selected = $('#searchsug A.selected');
                    if (selected.length) {
                        e.preventDefault();
                        input.val(selected.html());
                        return false;
                    }
                }
            } else if (keyCode == 13) {
                var selected = $('#searchsug A.selected');
                if (selected.length) {
                    window.location.href = selected.prop('href');
                    e.preventDefault();
                    return false;
                }
            }
        });

        this.focusout(function() {
            timeout = setTimeout(function() {
                $('#searchsug').fadeOut(500);
                input.removeClass('active');
            }, 500);
            run = false;

        });
        this.focusin(function() {
            clearTimeout(timeout);
            $('#searchsug').fadeIn(500);
            input.addClass('active');
            run = true;
        });

        input.keyup(function(e) {
            run = true;
            ajaxSearch(e)
        });

        getSug(input.val());

    };
})(jQuery);

//buy order
(function($) {
    $.fn.BuyOrder = function() {
        var email = $(this).find('#email');
        var agree = $(this).find('#agree');
        // email.after('<div class="errorMessage" id="email_error" style="display:none">РќРµ РґРµР№СЃС‚РІРёС‚РµР»СЊРЅС‹Р№ Р°РґСЂРµСЃСЃ РїРѕС‡С‚С‹</div>');
        //email.after('<div class="errorMessage" id="agre_error" style="display:none">РќРµ РґРµР№СЃС‚РІРёС‚РµР»СЊРЅС‹Р№ Р°РґСЂРµСЃСЃ РїРѕС‡С‚С‹</div>');
        //var submit = $(this).find('.submit');
        var emailerror = $('#email_error');
        var agreeerror = $('#agree_error');
        var valid = false;

        /*
         alert($(this).find('input[checked]').val());
         */
        $(this).find('input[type=radio]').each(function() {
            $(this).click(function() {
                scrollto();
            });
        });

        function scrollto() {
            var offset = Math.round(email.offset().top + $(document).height() / 2);
            if ($(document).scrollTop() < offset)
                $("html, body").animate({scrollTop: offset}, "fast");

        }

        $(this).submit(function() {
            /*
             if($(this).find('input[checked]').val()=='undefined') {
             return false;
             }*/

            if (!agree.is(':checked')) {
                agreeerror.show();
                return false;
            }

            if (!valid) {
                emailerror.show();
                return false;
            }
        });

        email.change(function() {
            check(1)
        });

        agree.change(function() {
            if (!agree.is(':checked'))
                agreeerror.show();
            else
                agreeerror.hide();
        });

        email.keyup(function(e) {
            check()
        });

        function check(echo) {
            var emailval = jQuery.trim(email.val());
            if (emailval.match(/^(.*?)@(.*?)\.(.*?)$/)) {
                // submit.attr('disabled', false);
                valid = true;
                emailerror.hide();
            } else {
                //submit.attr('disabled', true);
                valid = false;
                if (echo)
                    emailerror.show();
            }
        }
        //init
        check()

    };
})(jQuery);
//ajax page
(function($) {
    $.fn.pageAjax = function() {
        var obj = $(this);
        obj.before('<a name="' + obj.attr('id') + '"');
        var cache = {};
        function makeLink() {
            obj.find('a').each(function() {
                $(this).prop('href', $(this).prop('href').replace('ajax', '') + '#' + obj.attr('id'));//
                $(this).click(function() {
                    var url = $(this).prop('href');
                    if (!url.match(/\/page/))
                        url = url.replace(obj.attr('id'), obj.attr('id') + 'ajax');

                    //  url = url + '/page1';

                    loadPage(url.replace('/page', 'ajax/page'));
                    return false;
                });
            });
        }

        function loadPage(url) {
            if (typeof cache[url] != 'undefined') {
                obj.html(cache[url]);
                makeLink();
            }
            else
                $.get(url, function(data) {
                    if (data) {
                        cache[url] = data;
                        obj.html(data);
                        makeLink();
                    }
                }, 'html');
            $("html, body").animate({scrollTop: obj.offset().top}, "fast");
        }
        //init
        makeLink();
    };
})(jQuery);
/* gTab */
(function($) {
    $.fn.gTab = function() {
        var obj = $(this);
        var html = '<UL id="gTabH"></UL>';
        $(obj).before(html);
        var k = 0;
        var prev = 0;
        $("DIV", obj).each(function(i) {
            $(this).attr('id', 'gTabI' + k);
            if (k > 0)
                $(this).css('display', 'none');
            $(document.createElement("li"))
                    //.attr('id', 'gTabA' + k)
                    .html('<A href=\"javascript:void(0);\" id="gTabA' + k + '">' + $("H1", this).text() + '</A>') //rel=' + k + ' 
                    .appendTo($("#gTabH"))
                    .click(function() {
                //toggle($("a", $(this)).attr('rel'));
                toggle(i); //
            });
            if (k == prev)
                $("#gTabA0").css('text-decoration', 'none');
            k++;
        });
        function toggle(tab) {
            tab = parseInt(tab);
            if (tab != prev) {
                $("#gTabA" + prev).css('text-decoration', 'underline');
                $("#gTabA" + parseInt(tab)).css('text-decoration', 'none');
                $("#gTabI" + prev).css('display', 'none');
                $("#gTabI" + parseInt(tab)).css('display', 'block');
                //    $("#gTabI" + prev).toggle("slow");
                //    $("#gTabI" + tab).toggle("slow");
                prev = tab;
            }

        }

    };
})(jQuery);
/* floatMenu *//*
 (function($) {
 $.fn.floatMenu = function() {
 
 $(this).clone().attr('id', 'headerMenu').appendTo($("#main"));
 
 //habrahabr
 var isMobileDevice = (/android|webos|iphone|ipad|ipod|blackberry/i.test(navigator.userAgent.toLowerCase()));
 if (isMobileDevice) {
 return;
 }
 
 var float_block = $('#headerMenu');
 float_block.addClass('menu_float');
 var show_float_block = false;
 
 float_block.hide();
 
 $(window).bind('scroll resize', function() {
 if ($(window).height() > 500) {
 if (this.pageYOffset > 155) {
 show_float_block = true;
 } else
 show_float_block = false;
 } else
 show_float_block = false;
 
 if (show_float_block) {
 float_block.show();
 } else {
 float_block.hide();
 }
 
 });
 
 };
 })(jQuery);
 */
(function($) {
    $.fn.countdown = function(cur, end, title) {
        var elem = $(this);
        var userDate = new Date();
        var diff = cur - Math.floor(userDate.getTime() / 1000);
        elem.attr('title', title);
        //end -= 86400 + 3600 * 20 + 12 * 60;

        function timeUpdate() {
            var Time = new Date();
            var left = Math.floor(end - (Time.getTime() / 1000) - diff);
            left--;
            if (left <= 0) {
                clearInterval(timer);
                elem.html('Finish');
                return false;
            }
            elem.html(timePrepare(left));
        }

        function timePrepare(time) {
            var H = 0;
            var M = 0;
            var S = 0;
            H = Math.floor(time / 3600);
            M = Math.floor((time - H * 3600) / 60);
            S = time - H * 3600 - M * 60;
            return (H < 10 ? '0' + H : H) + ' : ' + (M < 10 ? '0' + M : M) + ' : ' + (S < 10 ? '0' + S : S);
        }

        timeUpdate();
        var timer = setInterval(timeUpdate, 1000);
    };
})(jQuery);


(function($) {
    $.fn.gifts = function(VK, csrf, flashList) {

        var clicked = false;
        var obj = $(this);
        var margin = "143px";
        var r = 0;
        var obj = $(this);
        $(this).click(function() {
            obj.prop("disabled", true);
            if (!$("#gift_share").hasClass("clicked")) {
                flash('makeShare');
                return false;
            } else
                $('.gift_flash').hide();
            //$('#gift_err_makeShare').hide();

            if ($('#gift_manual').val()) // РµСЃР»Рё РµСЃС‚СЊ Р·РЅР°С‡РµРЅРёРµ РІ РїРѕР»Рµ СЂСѓС‡РЅРѕРіРѕ РІРІРѕРґР°, РёРґРµРј РїРѕ РЅРµРјСѓ
                post(encodeURIComponent($('#gift_manual').val()));
            else {
                function authInfo(response)
                {
                    if (response.session)
                        post(response.session.mid);
                    else if (!clicked)
                    {
                        clicked = true;

                        VK.Auth.login(authInfo);
                    } else { //show manual input form
                        $('.gift_manual').show();
                        obj.prop("disabled", false);
                    }
                }
                VK.Auth.getLoginStatus(authInfo);
            }
        });

        function flash(option, color) {
            if (!color)
                $('#gift_flash').html(flashList[option]).show();
            else
                $('#gift_flash').html(flashList[option]).css('color', color).show();
        }

        function post(id) {
            if (r == 2)
                location.reload();

            $.ajax({
                type: "POST",
                url: '/game/gifts/ajax/',
                data: 'id=' + id + '&YII_CSRF_TOKEN=' + csrf,
                success: function(code) {
                    obj.prop("disabled", false);
                    /*console.log(code);*/
                    if (code) {
                        $('.gift_flash').hide();
                        if (code > 0) {
                            if (code == 200) { //OK
                                flash('success', 'green');
                                obj.hide();
                                $(".gift_wrap").css("marginLeft", margin);
                            }
                            else if (code == 418) {  //teapot
                                flash('default');
                                r++;
                            }
                            else if (code == 304) { //exist
                                flash('exists', 'green');
                                obj.hide();
                                $(".gift_wrap").css("marginLeft", margin);
                            }
                        }
                        else {
                            if (code == -1)
                                flash('group');
                            else if (code == -2)
                                flash('friends');
                            else if (code == -3)
                                flash('vk');
                            else if (code == -4)
                                flash('post');
                            else if (code == -210)
                                flash('hidden');
                            else {
                                flash('default');
                                r++;
                            }
                        }
                    } else {
                        r++;
                        flash('default');
                    }
                },
                dataType: 'json'
            });

        }

    };
})(jQuery);



/*
 /*  countdown
 * http://alexmuz.ru/jquery-countdown/
 *    
 *      
 (function($) {
 $.fn.countdown = function(date) {
 
 var timeDifference = function(begin, end) {
 if (end < begin) {
 return false;
 }
 var diff = {
 seconds: [end.getSeconds() - begin.getSeconds(), 60],
 minutes: [end.getMinutes() - begin.getMinutes(), 60],
 hours: [end.getHours() - begin.getHours(), 24],
 days: [end.getDate() - begin.getDate(), new Date(begin.getYear(), begin.getMonth() + 1, 0).getDate()],
 };
 var result = new Array();
 var flag = false;
 for (i in diff) {
 if (flag) {
 diff[i][0]--;
 flag = false;
 }
 if (diff[i][0] < 0) {
 flag = true;
 diff[i][0] += diff[i][1];
 }
 if (diff[i][0] < 10)
 diff[i][0] = '0' + diff[i][0];
 
 if (!diff[i][0])
 continue;
 
 result.push(diff[i][0]);
 }
 return result.reverse().join(' : ');
 };
 var elem = $(this);
 
 var timeUpdate = function() {
 var s = timeDifference(new Date(), date);
 if (s.length) {
 elem.html(s);
 } else {
 clearInterval(timer);
 elem.html('Finis');
 }
 };
 timeUpdate();
 var timer = setInterval(timeUpdate, 1000);
 };
 })(jQuery);
 
 */

/*
 * Placeholder plugin for jQuery
 * ---
 * Copyright 2010, Daniel Stocks (http://webcloud.se)
 * Released under the MIT, BSD, and GPL Licenses.
 * 
 */
/*
 (function($) {
 function Placeholder(input) {
 this.input = input;
 if (input.attr('type') == 'password') {
 this.handlePassword();
 }
 // Prevent placeholder values from submitting
 $(input[0].form).submit(function() {
 if (input.hasClass('placeholder') && input[0].value == input.attr('placeholder')) {
 input[0].value = '';
 }
 });
 }
 Placeholder.prototype = {
 show: function(loading) {
 // FF and IE saves values when you refresh the page. If the user refreshes the page with
 // the placeholders showing they will be the default values and the input fields won't be empty.
 if (this.input[0].value === '' || (loading && this.valueIsPlaceholder())) {
 if (this.isPassword) {
 try {
 this.input[0].setAttribute('type', 'text');
 } catch (e) {
 this.input.before(this.fakePassword.show()).hide();
 }
 }
 this.input.addClass('placeholder');
 this.input[0].value = this.input.attr('placeholder');
 }
 },
 hide: function() {
 if (this.valueIsPlaceholder() && this.input.hasClass('placeholder')) {
 this.input.removeClass('placeholder');
 this.input[0].value = '';
 if (this.isPassword) {
 try {
 this.input[0].setAttribute('type', 'password');
 } catch (e) {
 }
 // Restore focus for Opera and IE
 this.input.show();
 this.input[0].focus();
 }
 }
 },
 valueIsPlaceholder: function() {
 return this.input[0].value == this.input.attr('placeholder');
 },
 handlePassword: function() {
 var input = this.input;
 input.attr('realType', 'password');
 this.isPassword = true;
 // IE < 9 doesn't allow changing the type of password inputs
 if ($.browser.msie && input[0].outerHTML) {
 var fakeHTML = $(input[0].outerHTML.replace(/type=(['"])?password\1/gi, 'type=$1text$1'));
 this.fakePassword = fakeHTML.val(input.attr('placeholder')).addClass('placeholder').focus(function() {
 input.trigger('focus');
 $(this).hide();
 });
 $(input[0].form).submit(function() {
 fakeHTML.remove();
 input.show()
 });
 }
 }
 };
 var NATIVE_SUPPORT = !!("placeholder" in document.createElement("input"));
 $.fn.placeholder = function() {
 return NATIVE_SUPPORT ? this : this.each(function() {
 var input = $(this);
 var placeholder = new Placeholder(input);
 placeholder.show(true);
 input.focus(function() {
 placeholder.hide();
 });
 input.blur(function() {
 placeholder.show(false);
 });
 // On page refresh, IE doesn't re-populate user input
 // until the window.onload event is fired.
 if (navigator.userAgent.match(/msie/i)) { //$.browser.msie
 $(window).load(function() {
 if (input.val()) {
 input.removeClass("placeholder");
 }
 placeholder.show(true);
 });
 // What's even worse, the text cursor disappears
 // when tabbing between text inputs, here's a fix
 input.focus(function() {
 if (this.value == "") {
 var range = this.createTextRange();
 range.collapse(true);
 range.moveStart('character', 0);
 range.select();
 }
 });
 }
 });
 }
 })(jQuery);*/
// Generated by CoffeeScript 1.6.3
/*
 Lightbox v2.6
 by Lokesh Dhakar - http://www.lokeshdhakar.com
 
 For more information, visit:
 http://lokeshdhakar.com/projects/lightbox2/
 
 Licensed under the Creative Commons Attribution 2.5 License - http://creativecommons.org/licenses/by/2.5/
 - free for use in both personal and commercial projects
 - attribution requires leaving author name, author link, and the license info intact
 */
(function($) {
    $.fn.Lightboxs = function() {
        var Lightbox, LightboxOptions;
        LightboxOptions = (function() {
            function LightboxOptions() {
                this.fadeDuration = 500;
                this.fitImagesInViewport = true;
                this.resizeDuration = 700;
                this.showImageNumberLabel = true;
                this.wrapAround = true;
            }

            LightboxOptions.prototype.albumLabel = function(curImageNum, albumSize) {
                return "РР·РѕР±СЂР°Р¶РµРЅРёРµ " + curImageNum + " РёР· " + albumSize;
            };
            return LightboxOptions;
        })();
        Lightbox = (function() {
            function Lightbox(options) {
                this.options = options;
                this.album = [];
                this.currentImageIndex = void 0;
                this.init();
            }

            Lightbox.prototype.init = function() {
                this.enable();
                return this.build();
            };
            Lightbox.prototype.enable = function() {
                var _this = this;
                return $('body').on('click', 'a[data-lightbox]', function(e) { //a[rel^=lightbox], area[rel^=lightbox], , area[data-lightbox]
                    _this.start($(e.currentTarget));

                    return false;
                });
            };
            Lightbox.prototype.build = function() {
                var _this = this;
                //$("<div id='lightboxOverlay' class='lightboxOverlay'></div><div id='lightbox' class='lightbox'><div class='lb-outerContainer'><div class='lb-container'><img class='lb-image' src='' /><div class='lb-nav'><a class='lb-prev' href='' ></a><a class='lb-next' href='' ></a></div><div class='lb-loader'><a class='lb-cancel'></a></div></div></div><div class='lb-dataContainer'><div class='lb-data'><div class='lb-details'><span class='lb-caption'></span><span class='lb-number'></span></div><div class='lb-closeContainer'><a class='lb-close'></a></div></div></div></div>").appendTo($('body'));
                $("<div id='lightboxOverlay' class='lightboxOverlay'></div>\
<div id='lightbox' class='lightbox'>\n\
<div class='lb-dataContainer'>\n\
    <div class='lb-data'>\n\
        <div class='lb-details'><span class='lb-caption'></span><span class='lb-number'></span></div>\n\
        <div class='lb-closeContainer'><a class='lb-close'></a></div>\n\
    </div>\n\
</div>\
<div class='lb-outerContainer'><div class='lb-container'><img class='lb-image' src='' /><div class='lb-nav'><a class='lb-prev' href='' ></a><a class='lb-next' href='' ></a></div><div class='lb-loader'><a class='lb-cancel'></a></div></div></div>\n\
</div>\
").appendTo($('body'));
                this.$lightbox = $('#lightbox');
                this.$overlay = $('#lightboxOverlay');
                this.$outerContainer = this.$lightbox.find('.lb-outerContainer');
                this.$container = this.$lightbox.find('.lb-container');
                this.containerTopPadding = parseInt(this.$container.css('padding-top'), 10);
                this.containerRightPadding = parseInt(this.$container.css('padding-right'), 10);
                this.containerBottomPadding = parseInt(this.$container.css('padding-bottom'), 10);
                this.containerLeftPadding = parseInt(this.$container.css('padding-left'), 10);
                this.$overlay.hide().on('click', function() {
                    _this.end();
                    return false;
                });
                this.$lightbox.hide().on('click', function(e) {
                    if ($(e.target).attr('id') === 'lightbox') {
                        _this.end();
                    }
                    return false;
                });
                this.$outerContainer.on('click', function(e) {
                    if ($(e.target).attr('id') === 'lightbox') {
                        _this.end();
                    }
                    return false;
                });
                this.$lightbox.find('.lb-prev').on('click', function() {
                    if (_this.currentImageIndex === 0) {
                        _this.changeImage(_this.album.length - 1);
                    } else {
                        _this.changeImage(_this.currentImageIndex - 1);
                    }
                    return false;
                });
                this.$lightbox.find('.lb-next').on('click', function() {
                    if (_this.currentImageIndex === _this.album.length - 1) {
                        _this.changeImage(0);
                    } else {
                        _this.changeImage(_this.currentImageIndex + 1);
                    }
                    return false;
                });
                return this.$lightbox.find('.lb-loader, .lb-close').on('click', function() {
                    _this.end();
                    return false;
                });
            };
            Lightbox.prototype.start = function($link) {
                var $window, a, dataLightboxValue, i, imageNumber, left, top, _i, _len, _ref; //_j,_len1,, ,_ref1
                $(window).on("resize", this.sizeOverlay);
                $('select, object, embed').css({
                    visibility: "hidden"
                });
                this.$overlay.width($(document).width()).height($(document).height()).fadeIn(this.options.fadeDuration);
                this.album = [];
                imageNumber = 0;
                dataLightboxValue = $link.attr('data-lightbox');
                if (dataLightboxValue) {
                    _ref = $($link.prop("tagName") + '[data-lightbox="' + dataLightboxValue + '"]');
                    for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
                        a = _ref[i];
                        this.album.push({
                            link: $(a).attr('href'),
                            title: $(a).attr('title')
                        });
                        if ($(a).attr('href') === $link.attr('href')) {
                            imageNumber = i;
                        }
                    }
                }
                $window = $(window);
                top = $window.scrollTop() + $window.height() / 10;
                left = $window.scrollLeft();
                this.$lightbox.css({
                    top: top + 'px',
                    left: left + 'px'
                }).fadeIn(this.options.fadeDuration);
                this.changeImage(imageNumber);
            };
            Lightbox.prototype.changeImage = function(imageNumber) {
                var $image, preloader,
                        _this = this;
                this.disableKeyboardNav();
                $image = this.$lightbox.find('.lb-image');
                this.sizeOverlay();
                this.$overlay.fadeIn(this.options.fadeDuration);
                $('.lb-loader').fadeIn('slow');
                this.$lightbox.find('.lb-image, .lb-nav, .lb-prev, .lb-next, .lb-numbers, .lb-caption').hide(); //.lb-dataContainer
                this.$outerContainer.addClass('animating');
                preloader = new Image();
                preloader.onload = function() {
                    var $preloader, imageHeight, imageWidth, maxImageHeight, maxImageWidth, windowHeight, windowWidth;
                    $image.attr('src', _this.album[imageNumber].link);
                    $preloader = $(preloader);
                    $image.width(preloader.width);
                    $image.height(preloader.height);
                    if (_this.options.fitImagesInViewport) {
                        windowWidth = $(window).width();
                        windowHeight = $(window).height();
                        maxImageWidth = windowWidth - _this.containerLeftPadding - _this.containerRightPadding - 20;
                        maxImageHeight = windowHeight - _this.containerTopPadding - _this.containerBottomPadding - 110;
                        if ((preloader.width > maxImageWidth) || (preloader.height > maxImageHeight)) {
                            if ((preloader.width / maxImageWidth) > (preloader.height / maxImageHeight)) {
                                imageWidth = maxImageWidth;
                                imageHeight = parseInt(preloader.height / (preloader.width / imageWidth), 10);
                                $image.width(imageWidth);
                                $image.height(imageHeight);
                            } else {
                                imageHeight = maxImageHeight;
                                imageWidth = parseInt(preloader.width / (preloader.height / imageHeight), 10);
                                $image.width(imageWidth);
                                $image.height(imageHeight);
                            }
                        }
                    }
                    return _this.sizeContainer($image.width(), $image.height());
                };
                preloader.src = this.album[imageNumber].link;
                this.currentImageIndex = imageNumber;
            };
            Lightbox.prototype.sizeOverlay = function() {
                return $('#lightboxOverlay').width($(document).width()).height($(document).height());
            };
            Lightbox.prototype.sizeContainer = function(imageWidth, imageHeight) {
                var newHeight, newWidth, oldHeight, oldWidth,
                        _this = this;
                oldWidth = this.$outerContainer.outerWidth();
                oldHeight = this.$outerContainer.outerHeight();
                newWidth = imageWidth + this.containerLeftPadding + this.containerRightPadding;
                newHeight = imageHeight + this.containerTopPadding + this.containerBottomPadding;
                this.$outerContainer.animate({
                    width: newWidth,
                    height: newHeight
                }, this.options.resizeDuration, 'swing');
                setTimeout(function() {
                    _this.$lightbox.find('.lb-dataContainer').width(newWidth);
                    _this.$lightbox.find('.lb-prevLink').height(newHeight);
                    _this.$lightbox.find('.lb-nextLink').height(newHeight);
                    _this.showImage();
                }, this.options.resizeDuration);
            };
            Lightbox.prototype.showImage = function() {
                this.$lightbox.find('.lb-loader').hide();
                this.$lightbox.find('.lb-image').fadeIn('slow');
                this.updateNav();
                this.updateDetails();
                this.preloadNeighboringImages();
                this.enableKeyboardNav();
            };
            Lightbox.prototype.updateNav = function() {
                this.$lightbox.find('.lb-nav').show();
                if (this.album.length > 1) {
                    if (this.options.wrapAround) {
                        this.$lightbox.find('.lb-prev, .lb-next').show();
                    } /*else {
                     if (this.currentImageIndex > 0) {
                     this.$lightbox.find('.lb-prev').show();
                     }
                     if (this.currentImageIndex < this.album.length - 1) {
                     this.$lightbox.find('.lb-next').show();
                     }
                     }*/
                }
            };
            Lightbox.prototype.updateDetails = function() {
                var _this = this;
                if (typeof this.album[this.currentImageIndex].title !== 'undefined' && this.album[this.currentImageIndex].title !== "") {
                    this.$lightbox.find('.lb-caption').html(this.album[this.currentImageIndex].title).fadeIn('fast');
                }
                if (this.album.length > 1 && this.options.showImageNumberLabel) {
                    this.$lightbox.find('.lb-number').text(this.options.albumLabel(this.currentImageIndex + 1, this.album.length)).fadeIn('fast');
                } else {
                    this.$lightbox.find('.lb-number').hide();
                }
                this.$outerContainer.removeClass('animating');
                this.$lightbox.find('.lb-dataContainer').fadeIn(this.resizeDuration, function() {
                    return _this.sizeOverlay();
                });
            };
            Lightbox.prototype.preloadNeighboringImages = function() {
                var preloadNext, preloadPrev;
                if (this.album.length > this.currentImageIndex + 1) {
                    preloadNext = new Image();
                    preloadNext.src = this.album[this.currentImageIndex + 1].link;
                }
                if (this.currentImageIndex > 0) {
                    preloadPrev = new Image();
                    preloadPrev.src = this.album[this.currentImageIndex - 1].link;
                }
            };
            Lightbox.prototype.enableKeyboardNav = function() {
                $(document).on('keyup.keyboard', $.proxy(this.keyboardAction, this));
            };
            Lightbox.prototype.disableKeyboardNav = function() {
                $(document).off('.keyboard');
            };
            Lightbox.prototype.keyboardAction = function(event) {
                var KEYCODE_ESC, KEYCODE_LEFTARROW, KEYCODE_RIGHTARROW, key, keycode;
                KEYCODE_ESC = 27;
                KEYCODE_LEFTARROW = 37;
                KEYCODE_RIGHTARROW = 39;
                keycode = event.keyCode;
                key = String.fromCharCode(keycode).toLowerCase();
                if (keycode === KEYCODE_ESC || key.match(/x|o|c/)) {
                    this.end();
                } else if (key === 'p' || keycode === KEYCODE_LEFTARROW) {
                    if (this.currentImageIndex !== 0) {
                        this.changeImage(this.currentImageIndex - 1);
                    }
                } else if (key === 'n' || keycode === KEYCODE_RIGHTARROW) {
                    if (this.currentImageIndex !== this.album.length - 1) {
                        this.changeImage(this.currentImageIndex + 1);
                    }
                }
            };
            Lightbox.prototype.end = function() {
                this.disableKeyboardNav();
                $(window).off("resize", this.sizeOverlay);
                this.$lightbox.fadeOut(this.options.fadeDuration);
                this.$overlay.fadeOut(this.options.fadeDuration);
                return $('select, object, embed').css({
                    visibility: "visible"
                });
            };
            return Lightbox;
        })();
        $(function() {
            var lightbox, options;
            options = new LightboxOptions();
            return lightbox = new Lightbox(options);
        });
    }
})(jQuery);
/*
 // share42.com | 10.11.2013 | (c) Dimox 
 (function($) {
 $.fn.share42 = function() {
 var el = $(this);
 //var obj = $('#share42');
 var i = '';
 var m1 = 205;
 //obj.css({top: m1});
 //var m2 = 205;
 //var m3 = 10;
 var f = '/i/';
 var meta = $('meta[name="description"]').attr('content');
 if (meta !== undefined)
 var d = meta;
 else
 var d = '';
 
 if ($('#slider').length > 0)
 m1 -= 5;
 
 var u = encodeURIComponent(location.href);
 var t = encodeURIComponent(document.title);
 t = t.replace(/\'/g, '%27');
 //i = encodeURIComponent(i);
 d = encodeURIComponent(d);
 d = d.replace(/\'/g, '%27');
 var fbQuery = 'u=' + u;
 // if (i != 'null' && i != '')
 //    fbQuery = 's=100&p[url]=' + u + '&p[title]=' + t + '&p[summary]=' + d + '&p[images][0]=' + i;
 var vkImage = '';
 // if (i != 'null' && i != '')
 //    vkImage = '&image=' + i;
 var s = new Array(
 '"#" data-count="vk" onclick="window.open(\'http://vk.com/share.php?url=' + u + '&title=' + t + vkImage + '&description=' + d + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0\');return false" title="РџРѕРґРµР»РёС‚СЊСЃСЏ Р’ РљРѕРЅС‚Р°РєС‚Рµ"',
 '"#" data-count="twi" onclick="window.open(\'https://twitter.com/intent/tweet?text=' + t + '&url=' + u + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0\');return false" title="Р”РѕР±Р°РІРёС‚СЊ РІ Twitter"',
 '"#" data-count="fb" onclick="window.open(\'http://www.facebook.com/sharer.php?' + fbQuery + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0\');return false" title="РџРѕРґРµР»РёС‚СЊСЃСЏ РІ Facebook"',
 '"#" data-count="odkl" onclick="window.open(\'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st._surl=' + u + '&title=' + t + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0\');return false" title="Р”РѕР±Р°РІРёС‚СЊ РІ РћРґРЅРѕРєР»Р°СЃСЃРЅРёРєРё"',
 '"#" onclick="window.open(\'http://www.blogger.com/blog_this.pyra?t&u=' + u + '&n=' + t + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0\');return false" title="РћРїСѓР±Р»РёРєРѕРІР°С‚СЊ РІ Blogger.com"',
 '"#" onclick="window.open(\'https://plus.google.com/share?url=' + u + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0\');return false" title="РџРѕРґРµР»РёС‚СЊСЃСЏ РІ Google+"',
 '"http://my.ya.ru/posts_add_link.xml?URL=' + u + '&title=' + t + '&body=' + d + '" data-count="ya" title="РџРѕРґРµР»РёС‚СЊСЃСЏ РІ РЇ.СЂСѓ"',
 '"http://www.livejournal.com/update.bml?event=' + u + '&subject=' + t + '" title="РћРїСѓР±Р»РёРєРѕРІР°С‚СЊ РІ LiveJournal"',
 '"#" class="fav" title="РЎРѕС…СЂР°РЅРёС‚СЊ РІ РёР·Р±СЂР°РЅРЅРѕРµ Р±СЂР°СѓР·РµСЂР°"',
 '"#" onclick="window.open(\'http://zakladki.yandex.ru/newlink.xml?url=' + u + '&name=' + t + '&descr=' + d + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=500, toolbar=0, status=0\');return false" title="Р”РѕР±Р°РІРёС‚СЊ РІ РЇРЅРґРµРєСЃ.Р—Р°РєР»Р°РґРєРё"',
 '"#" onclick="window.open(\'http://www.google.com/bookmarks/mark?op=edit&output=popup&bkmk=' + u + '&title=' + t + '&annotation=' + d + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=500, toolbar=0, status=0\');return false" title="РЎРѕС…СЂР°РЅРёС‚СЊ Р·Р°РєР»Р°РґРєСѓ РІ Google"',
 '"#" onclick="window.open(\'http://bookmarks.yahoo.com/toolbar/savebm?u=' + u + '&t=' + t + '&d=' + d + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=400, toolbar=0, status=0\');return false" title="Р”РѕР±Р°РІРёС‚СЊ РІ Yahoo! Р—Р°РєР»Р°РґРєРё"',
 '"https://www.evernote.com/clip.action?url=' + u + '&title=' + t + '" title="Р”РѕР±Р°РІРёС‚СЊ РІ Evernote"',
 '"#" data-count="mail" onclick="window.open(\'http://connect.mail.ru/share?url=' + u + '&title=' + t + '&description=' + d + '&imageurl=' + i + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0\');return false" title="РџРѕРґРµР»РёС‚СЊСЃСЏ РІ РњРѕРµРј РњРёСЂРµ@Mail.Ru"',
 '"http://pikabu.ru/add_story.php?story_url=' + u + '" title="Р”РѕР±Р°РІРёС‚СЊ РІ Pikabu"',
 '"http://www.liveinternet.ru/journal_post.php?action=n_add&cnurl=' + u + '&cntitle=' + t + '" title="РћРїСѓР±Р»РёРєРѕРІР°С‚СЊ РІ LiveInternet"',
 '"http://digg.com/submit?url=' + u + '" title="Р”РѕР±Р°РІРёС‚СЊ РІ Digg"',
 '"#" data-count="lnkd" onclick="window.open(\'http://www.linkedin.com/shareArticle?mini=true&url=' + u + '&title=' + t + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=600, height=400, toolbar=0, status=0\');return false" title="Р”РѕР±Р°РІРёС‚СЊ РІ Linkedin"',
 '"http://share.yandex.ru/go.xml?service=moikrug&url=' + u + '&title=' + t + '&description=' + d + '" title="РџРѕРґРµР»РёС‚СЊСЃСЏ РІ РњРѕР№ РљСЂСѓРі"',
 '"http://www.myspace.com/Modules/PostTo/Pages/?u=' + u + '&t=' + t + '&c=' + d + '" title="Р”РѕР±Р°РІРёС‚СЊ РІ MySpace"',
 '"http://reddit.com/submit?url=' + u + '&title=' + t + '" title="Р”РѕР±Р°РІРёС‚СЊ РІ Reddit"',
 '"http://rutvit.ru/tools/widgets/share/popup?url=' + u + '&title=' + t + '" title="Р”РѕР±Р°РІРёС‚СЊ РІ Р СѓРўРІРёС‚"',
 '"#" onclick="window.open(\'http://www.tumblr.com/share?v=3&u=' + u + '&t=' + t + '&s=' + d + '\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=450, height=440, toolbar=0, status=0\');return false" title="Р”РѕР±Р°РІРёС‚СЊ РІ Tumblr"',
 '"http://share42.com/" title="Share42.com - Р‘РµСЃРїР»Р°С‚РЅС‹Р№ СЃРєСЂРёРїС‚ РєРЅРѕРїРѕРє СЃРѕС†РёР°Р»СЊРЅС‹С… Р·Р°РєР»Р°РґРѕРє Рё СЃРµС‚РµР№"');
 
 var l = '';
 var iNum = 24;
 var iShow = 8;
 var iPages = Math.ceil(iNum / iShow);
 var curpage = 0;
 var pageheight = 296;
 for (j = 0; j < iNum; j++) {
 l += '<span class="share42-item"><a rel="nofollow" style="background:url(' + f + 'icons.png) -' + 32 * j + 'px 0 no-repeat" href=' + s[j] + ' target="_blank"></a></span>';// + s42s;
 }
 el.after('<div id="share42" class="gray_bg" style="position:fixed;z-index:9999;top:' + m1 + 'px;margin-left:980px"><a href="#" class="s42a t"></a><div class="s42s"><div class="wrap">' + l + '</div></div><a href="#" class="s42a"></a></div>');
 var wrap = $('#share42 .wrap');
 
 $('#share42').delegate('a.s42a:not(.t)', 'click', function() {
 moveDown();
 return false;
 });
 $('#share42').delegate('a.s42a.t', 'click', function() {
 moveUp();
 return false;
 });
 
 function moveUp() {
 var newpage = curpage - 1;
 if (newpage < 0)
 newpage = iPages - 1;
 curpage = newpage;
 wrap.animate({marginTop: -newpage * pageheight}, {queue: false, duration: 700});
 }
 
 function moveDown() {
 var newpage = curpage + 1;
 if (newpage > iPages - 1)
 newpage = 0;
 curpage = newpage;
 wrap.animate({marginTop: -newpage * pageheight}, {queue: false, duration: 700});
 }
 
 $('#share42').delegate('a.fav', 'click', function() {
 title = document.title;
 url = document.location;
 try {
 window.external.AddFavorite(url, title);
 } catch (e) {
 try {
 window.sidebar.addPanel(title, url, "");
 } catch (e) {
 if (typeof(opera) == "object") {
 var a = $(this);
 a.rel = "sidebar";
 a.title = title;
 a.url = url;
 return true;
 } else {
 alert('РќР°Р¶РјРёС‚Рµ Ctrl-D, С‡С‚РѕР±С‹ РґРѕР±Р°РІРёС‚СЊ СЃС‚СЂР°РЅРёС†Сѓ РІ Р·Р°РєР»Р°РґРєРё');
 }
 }
 }
 return false;
 });
 }
 })(jQuery);
 */

/*
 var l = '';
 var iNum = 24;
 var iShow = 8;
 var iPages = Math.ceil(iNum / iShow);
 for (j = 0; j < s.length; j++) {
 var s42s = '';
 if ((j + 1) % iShow == 0) {
 s42s = '</div><div class="s42s">';
 }
 l += '<span class="share42-item"><a rel="nofollow" style="background:url(' + f + 'icons.png) -' + 32 * j + 'px 0 no-repeat" href=' + s[j] + ' target="_blank"></a></span>' + s42s;
 }
 ;
 el.after('<div id="share42" class="gray_bg" style="position:fixed;z-index:9999;top:' + m1 + 'px;margin-left:980px"><div class="s42s">' + l + '</div></div>');
 var a = '<a href="#" class="s42a"></a>';
 var d = '#share42 a.s42a';
 var l = '#share42 div.s42s';
 $(l + ':first').append(a);
 $(l + ':not(:first)').css({display: 'none'});
 if ($(l).length > iPages)
 $(l + ':last').remove();
 function ac() {
 $(d + ':first-child').addClass('t');
 $(d + ':last-child').addClass('b');
 }
 function r() {
 $(d).not(':visible').remove();
 }
 $('#share42').delegate('a.s42a:not(.t)', 'click', function() {
 var p = $(this).parent();
 r();
 p.animate({height: 'hide'}, 700).next().not(':last-child').prepend(a).append(a);
 p.next(':last-child').prepend(a);
 ac();
 p.next().animate({height: 'show'}, 700);
 return false;
 });
 $('#share42').delegate('a.s42a.t', 'click', function() {
 var p = $(this).parent();
 r();
 p.animate({height: 'hide'}, 700).prev().not(':first-child').prepend(a).append(a);
 p.prev(':first-child').append(a);
 ac();
 p.prev().animate({height: 'show'}, 700);
 return false;
 });
 
 */