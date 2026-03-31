;(function ($) {

    /**
     * @author  <github.com/tarampampam>
     * @weblog  http://blog.kplus.pro/
     * @project https://github.com/tarampampam/jquery.textmistake
     *
     * @version 0.1
     *
     * @licensy Licensed under the MIT, license text: http://goo.gl/JsVjCF
     */

    $.fn.textmistake = function (options) {
        // Default settings
        var defaults = {
                'l10n': {
                    'title': 'Report a typo author:',
                    'urlHint': 'Url of the page with error:',
                    'errTextHint': 'Text with the error:',
                    'yourComment': 'Your comment:',
                    'userComment': 'Comment by user:',
                    'commentPlaceholder': 'Type comment',
                    'cancel': 'Cancel',
                    'send': 'Send',

                    'mailSubject': 'Typo on the site',
                    'mailTitle': 'Typo on the site',

                    'mailSended': 'Notification sent',
                    'mailSendedDesc': 'Your notification has been sent successfully. Thank you for your feedback!',
                    'mailNotSended': 'Sending error',
                    'mailNotSendedDesc': 'Your message has not been sent, sorry.',
                },
                'debug': true, // fet 'false' if all tested and works fine
                'initCss': true,
                'initHtml': true,

                'overlayColor': '#666',
                'overlayOpacity': 0.5,
                'windowZindex': 10001,
                'hideBodyScroll': true,

                'textLimit': 400,
                'contextLength': 40,
                'closeOnEsc': true,

                'mailTo': 'shamsiddinovs102@gmail.com', // your_email@address.here
                //'mailFrom': 'info@'+window.location.hostname,
                // 'mailFrom': 'info@agmk.uz',
                'mailFrom': 'reply_ammc@agmk.uz',

                'mandrillKey': '', // Get your - https://mandrill.com/signup/
                'sendmailUrl': '',

                'animateSpeed': 0,
                'autocloseTime': 10000,

                // Callbacks
                'onShow': function (state) {
                },
                'onHide': function (state) {
                },
                'onLoadingShow': function (state) {
                },
                'onLoadingHide': function (state) {
                },
                'onCtrlEnter': function () {
                },
                'onEscPressed': function () {
                },
                'onSendMail': function (response) {
                },
                'onAjaxDone': function (response) {
                },
                'onAjaxResultError': function (response) {
                },
                'onAjaxSendError': function (response) {
                },
            },
            // Apply user settings to defaults
            settings = $.extend({}, defaults, options),
            log = function (text) {
                if (settings.debug) {
                    var now = new Date().toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
                    return console.log('[' + now + '] ' + text);
                }
            },
            html = $('html').first(),
            head = $('head').first(),
            body = $('body').first();

        // Add styles to head
        if (settings.initCss && (head.find('#mt_s').length === 0)) head.append('<style id="mt_s" type="text/css">\
        html.mistake-open,html.mistake-open body{\
            min-height:100%}\
        html.mistake-open body{\
            display:block;position:relative;overflow:hidden;top:0;left:0}\
        #mt_o{\
            position:fixed;padding:0;margin:0;top:0;left:0;width:100%;height:100%;\
            background:' + settings.overlayColor + ';z-index:' + settings.windowZindex.toString() + ';-moz-opacity:' + settings.overlayOpacity.toString() + ';opacity:' + settings.overlayOpacity.toString() + ';zoom:1;display:none}\
        #mt_c{\
            position:fixed;top:50%;left:50%;width:454px;height:auto;padding:30px 42px;\
            background:#fff;border:1px solid #777;outline:0;box-shadow:0 4px 16px rgba(0,0,0,.2);\
            font-family:Arial,sans-serif;font-size:13px;line-height:18px;\
            word-wrap:break-word;z-index:' + (settings.windowZindex + 1).toString() + ';display:none}\
        #mt_c div.loading, #mt_c div.loading div.overlay{\
            position:absolute;top:0;left:0;width:100%;height:100%;}\
        #mt_c div.loading{\
            z-index:' + (settings.windowZindex + 2).toString() + ';display:none\
        }\
        #mt_c div.loading div.overlay{\
            background:#666;-moz-opacity:0.1;opacity:0.1;\
        }\
        #mt_c div.loading div.spinner{\
            position:absolute;left:50%;top:50%;width:30px;height:30px;margin:-15px 0 0 -15px;background-color:#222;\
            -webkit-animation:rotateplane 1.2s infinite ease-in-out;\
            animation:rotateplane 1.2s infinite ease-in-out}\
                @-webkit-keyframes rotateplane\
                {0%{-webkit-transform:perspective(120px)}\
                50%{-webkit-transform:perspective(120px) rotateY(180deg)}\
                100%{-webkit-transform:perspective(120px) rotateY(180deg) rotateX(180deg)}}\
                @keyframes rotateplane\
                {0%{transform:perspective(120px) rotateX(0deg) rotateY(0deg);-webkit-transform:perspective(120px) rotateX(0deg) rotateY(0deg)}\
                50%{transform:perspective(120px) rotateX(-180.1deg) rotateY(0deg);-webkit-transform:perspective(120px) rotateX(-180.1deg) rotateY(0deg)}\
                100%{transform:perspective(120px) rotateX(-180deg) rotateY(-179.9deg);-webkit-transform:perspective(120px) rotateX(-180deg) rotateY(-179.9deg)}}\
        #mt_c .close{\
            position:absolute;right:0;top:0;margin:0;padding:17px;width:11px;height:11px;\
            background:url(\'https://i.imgur.com/U3EnhFo.png\') no-repeat center center;\
            -moz-opacity:.7;opacity:.7;cursor:pointer;z-index:' + (settings.windowZindex + 10).toString() + '\}\
        #mt_c .close:hover{\
            -moz-opacity:1;opacity:1}\
        #mt_c div.title{\
            height:32px;padding:0 0 0 40px;margin:0 0 16px;background-repeat:no-repeat;background-position:left center}\
        #mt_c div.title.feedback{\
            background-image:url(\'https://i.imgur.com/BCvESIh.png\')}\
        #mt_c div.title.fire{\
            background-image:url(\'http://i.imgur.com/CHwbq2g.png\')}\
        #mt_c div.title.mail{\
            background-image:url(\'http://i.imgur.com/Mo8R3H8.png\')}\
        #mt_c div.title.star{\
            background-image:url(\'http://i.imgur.com/wgTKfJF.png\')}\
        #mt_c div.title.cross{\
            background-image:url(\'http://i.imgur.com/5nx776T.png\')}\
        #mt_c div.title h1{\
            color:#000;display:inline;font-family:Arial,sans-serif;font-size:14px;font-weight:400;line-height:32px}\
        #mt_c p{\
            margin:0 0 13px;padding:0}\
        #mt_c p.nowrap{\
            white-space:nowrap;overflow:hidden;position:relative}\
            #mt_c p.nowrap::after{\
                content:\'\';position:absolute;right:0;top:0;width:40px;height:100%;\
                background:-moz-linear-gradient(left,rgba(255,255,255,0.2),#fff 100%);\
                background:-webkit-linear-gradient(left,rgba(255,255,255,0.2),#fff 100%);\
                background:-o-linear-gradient(left,rgba(255,255,255,0.2),#fff 100%);\
                background:-ms-linear-gradient(left,rgba(255,255,255,0.2),#fff 100%);\
                background:linear-gradient(to right,rgba(255,255,255,0.2),#fff 100%)}\
        #mt_c p.nopadding{\
            margin:0;padding:0\
        }\
        #mt_c p .url{\
            color:#0f5bd9;text-decoration:underline}\
        #mt_c blockquote{\
            font-family:Arial,sans-serif;font-size:13px;line-height:18px;\
            padding:0;margin:6px 25px 20px 25px;background-image:none;background:transperent}\
        #mt_c blockquote strong{\
            font-weight:700;color:#d31;text-decoration:underline}\
        #mt_c input[type=\'text\']{\
            width:100%;background-color:#fff;border:1px solid #d9d9d9;\
            border-radius:1px;box-sizing:border-box;font-size:13px;padding:3px 8px;\
            resize:none;text-align:start;word-wrap:break-word}\
            #mt_c input[type=\'text\']:focus{\
                outline:0;border-color:#4d90fe}\
        #mt_c div.buttons{\
            margin:22px 0 0;text-align:right}\
        #mt_c input[type=\'button\']{\
            background-color:#f5f5f5;background-image:-webkit-linear-gradient(top,#f5f5f5,#f1f1f1);\
            border-radius:2px;border:1px solid #e2e2e2;color:#444;\
            font-family:Arial,sans-serif;font-size:11px;font-weight:700;\
            height:29px;letter-spacing:normal;line-height:27px;\
            margin:0 0 0 16px;padding:0 15px;text-align:center;outline:0}\
            #mt_c input[type=\'button\']:hover{\
                border-color:#d2d2d2}\
    </style>');

        // Add html to body end
        if (settings.initHtml && (body.find('#mt_c').length === 0)) body.append('<div id="mt_c">' +
            '<div class="loading"><div class="spinner"></div><div class="overlay"></div></div>' +
            '<div class="close mt_cl"></div>' +
            '<div class="title feedback"><h1>' + settings.l10n.title + '</h1></div>' +
            '<p class="msg"></p>' +
            '<p class="nowrap">' + settings.l10n.urlHint + ' <span class="url"></span></p>' +
            '<p class="nopadding">' + settings.l10n.errTextHint + '</p>' +
            '<blockquote></blockquote>' +
            '<p>' + settings.l10n.yourComment + '</p>' +
            '<p><input type="text" maxlength="256" value="" placeholder="' + settings.l10n.commentPlaceholder + '" /></p>' +
            '<div class="buttons">' +
            '<input type="button" class="mt_cl" value="' + settings.l10n.cancel + '" />' +
            '<input type="button" class="mt_snd" value="' + settings.l10n.send + '" />' +
            '</div>' +
            '</div><div id="mt_o"></div>');

        var overlay = body.find('#mt_o'),
            content = body.find('#mt_c'),
            loading = content.find('div.loading').first(),
            title = content.find('div.title').first(),
            message = content.find('p.msg').first(),
            url = content.find('span.url').first(),
            textdata = content.find('blockquote').first(),
            comment = content.find('input[type=text]').first(),
            close = content.find('.mt_cl'),
            send = content.find('.mt_snd'),

            autocloseTimer = null,

            // Get selected text
            getSelectionText = function () {
                var text = '';
                if (window.getSelection) {
                    text = window.getSelection().toString();
                } else if (document.selection && document.selection.type != 'Control') {
                    text = document.selection.createRange().text;
                }
                return text;
            },

            // Get all unselected text (return {before:N1,after:N2})
            // http://stackoverflow.com/a/9000719
            getUnselectedText = function (e) {
                var t, n, o, a = "", r = "";
                return "undefined" != typeof window.getSelection ? (t = window.getSelection(), t.rangeCount ? n = t.getRangeAt(0) : (n = document.createRange(), n.collapse(!0)), o = document.createRange(), o.selectNodeContents(e), o.setEnd(n.startContainer, n.startOffset), a = o.toString(), o.selectNodeContents(e), o.setStart(n.endContainer, n.endOffset), r = o.toString()) : (t = document.selection) && "Control" != t.type && (n = t.createRange(), o = document.body.createTextRange(), o.moveToElementText(e), o.setEndPoint("EndToStart", n), a = o.text, o.moveToElementText(e), o.setEndPoint("StartToEnd", n), r = o.text), {
                    before: a,
                    after: r
                }
            },
            // Make string escape (html chars)
            // http://stackoverflow.com/a/12034334
            escapeHtml = function (string) {
                var entityMap = {"&": "&amp;", "<": "&lt;", ">": "&gt;", '"': '&quot;', "'": '&#39;', "/": '&#x2F;'};
                return String(string).replace(/[&<>"'\/]/g, function (s) {
                    return entityMap[s];
                });
            },

            // Clear string from any 'invalid' chars and empty spaces
            clearString = function (s) {
                return s.replace(/\s+/g, ' ').replace(/[^a-zа-яё0-9\.\,\ \_\-\(\)\[\]\{\}\`\~\@\#\$\%\^\:\*]/gi, '');
            },

            // Move window to screen center
            centerWindow = function () {
                content.css({
                    'margin-top': -(content.height() / 2 + parseInt(content.css('padding-top'))),
                    'margin-left': -((content.width() / 2) + parseInt(content.css('padding-left')))
                });
            },

            // Show loading splash
            showLoading = function (visible) {
                if (typeof visible === 'boolean')
                    if (visible) {
                        if ($.isFunction(settings.onLoadingShow)) settings.onLoadingShow(visible); // callback
                        loading.show().find('*').show(); // show 'loading' container
                    } else {
                        if ($.isFunction(settings.onLoadingHide)) settings.onLoadingHide(visible); // callback
                        loading.hide(); // hide 'loading'
                    }
            },

            // Show mistake window
            showWindow = function (visible) {
                if (typeof visible === 'boolean')
                    if (visible) { // If we need to show
                        if ($.isFunction(settings.onShow)) settings.onShow(visible); // callback
                        if (settings.hideBodyScroll) html.addClass('mistake-open'); // hide body scroll
                        content.find('*').show(); // show all inside objects
                        title.removeClass().addClass('title feedback'); // setup default title classes
                        message.html('').hide(); // reset and hide 'msg' container
                        loading.hide(); // hide 'loading' container
                        overlay.show(settings.animateSpeed); // show overlay
                        centerWindow(); // center message window (text must be setted before this function call)
                        content.show(settings.animateSpeed); // and show window
                        return true;
                    } else {
                        if ($.isFunction(settings.onHide)) settings.onHide(visible); // callback
                        if (settings.hideBodyScroll) html.removeClass("mistake-open");
                        content.hide(settings.animateSpeed); // hide window
                        overlay.hide(settings.animateSpeed); // hide overlay
                        return false;
                    }
                return null;
            },

            // Get mistake window state
            windowIsOpen = function () {
                return (overlay.is(':visible') && content.is(':visible'));
            },

            // Modify window for message output, and show this shit
            showMessage = function (caption, text, cssclass) {
                if (!overlay.is(':visible')) overlay.show(); // show overlay if needed
                content.find('*').hide(); // hide all inside window
                showLoading(false); // hide loading screen (heed this line for callback)
                content.find('div.close').show(); // show close cross
                title.show().find('h1').html(caption).show(); // setup and show title
                if (cssclass) title.removeClass().addClass('title ' + cssclass); // setup title class
                message.html(text).show(); // setup and show message
                centerWindow(); // center window

                if (settings.autocloseTime > 0) {
                    clearInterval(autocloseTimer);
                    autocloseTimer = setInterval(function () {
                        showWindow(false);
                        clearInterval(autocloseTimer);
                    }, settings.autocloseTime);
                }

                if (!content.is(':visible')) content.show(); // show content if needed
            },

            // Make email addr validation
            // http://stackoverflow.com/a/46181/2252921
            validEmail = function (addr) {
                return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(addr);
            },

            // Send main function
            // ------------------
            sendMail = function () {
                if (!validEmail(settings.mailTo))
                    return log('Email "' + settings.mailTo + '" is not valid');

                if (!validEmail(settings.mailFrom))
                    return log('Declare valid "Mail From" address');

                var mailBody = '<html lang="en"><head><meta charset="utf-8" /></head><body>' +
                    '<h2>' + settings.l10n.mailTitle + '</h2>' + "\n" +
                    '<p><small>' + settings.l10n.urlHint + ' <a href="' /*+ url.text() */ + '" target="_blank">' /*+ url.text()*/ + '</a></small></p>' + "\n\n" +
                    '<p>' + settings.l10n.errTextHint + '</p>' + "\n" +
                    '<blockquote>' + textdata.html() + '</blockquote>' + "\n\n";
                if (comment.val())
                    mailBody += '<p>' + settings.l10n.userComment + '<br />' + "\n" + '<em>' + comment.val() + '</em></p>';
                mailBody += '</body></html>';

                var apiUrl = '',
                    mailData = {
                        'key': '',
                        'message': {
                            'from_email': settings.mailFrom,
                            'to': [{'email': settings.mailTo, 'type': 'to'}],
                            'autotext': 'true',
                            'subject': clearString(settings.l10n.mailSubject),
                            'html': mailBody
                        }
                    };

                // I think api key length forever eq. 22
                if (settings.sendmailUrl.length > 0) {
                    mailData.key = settings.mandrillKey;
                    apiUrl = settings.sendmailUrl;
                }

                // I think api key length forever eq. 22
                if (settings.mandrillKey && settings.mandrillKey.length == 22) {
                    mailData.key = settings.mandrillKey;
                    // Docs - https://mandrillapp.com/api/docs/messages.JSON.html#method=send
                    apiUrl = 'https://mandrillapp.com/api/1.0/messages/send.json';
                }

                if (apiUrl.length == 0) {
                    showMessage('Wrong settings', 'Check plugin settings', 'fire');
                    return false;
                }
                data = mailData
                console.log(mailBody)
                $.ajax({
                    url: 'https://agmk.uz/u/enter/test',
                    type: 'POST',
                    data: JSON.stringify(mailBody),
                    contentType: 'application/json',
                    success: function (data) {
                        console.log(data)
                    }
                }).done(function (response) {
                    console.log(response)
                    if ($.isFunction(settings.onAjaxDone)) settings.onAjaxDone(response); // callback
                    if (((typeof response[0] !== 'undefined') && (response[0].status === 'sent'))
                        || ((typeof response.code !== 'undefined') && (response.code == 1))) {
                        if ($.isFunction(settings.onSendMail)) settings.onSendMail(response); // callback
                        showMessage(settings.l10n.mailSended, settings.l10n.mailSendedDesc, 'star');
                    } else {
                        if ($.isFunction(settings.onAjaxResultError)) settings.onAjaxResultError(response); // callback
                        showMessage(settings.l10n.mailNotSended, settings.l10n.mailNotSendedDesc, 'fire');
                        log('Request was sended, but server answer is not valid');
                    }
                }).fail(function (xhr, status, error) {
                    console.log(xhr)
                });
                /*	$.ajax({

                    }).done(
                        function(response) {
                        console.log(response)
                    })*/

                showLoading(true);
            };

        // Event on objects with close .class
        close.on('click', function () {
            showWindow(false);
        });

        // Event on objects with send .class
        send.on('click', function () {
            sendMail();
        });

        // Event on Ctrl + Enter
        body.keydown(function (e) {
            if (e.ctrlKey && e.keyCode == 13) {
                if ($.isFunction(settings.onCtrlEnter)) settings.onCtrlEnter(); // callback
                var unselected = getUnselectedText(document.body),
                    atStart = clearString(unselected.before.slice(-settings.contextLength)),
                    atEnd = clearString(unselected.after.slice(0, settings.contextLength)),
                    selectedText = escapeHtml(getSelectionText()).replace(/(\r\n|\n|\r)/gm, ' ');
                if (selectedText.length < 1)
                    return false;
                if (selectedText.length > settings.textLimit) {
                    log('Too many text');
                    return false;
                }

                comment.val(''); // clear comment input

                url.text(window.location.href);
                textdata.html('&hellip;' + atStart + '<strong>' + selectedText + '</strong>' + atEnd + '&hellip;');

                showWindow(true);
            }
        });

        // event on ESC key pressed
        body.keyup(function (e) {
            if (settings.closeOnEsc && windowIsOpen() && e.keyCode == 27) {
                if ($.isFunction(settings.onEscPressed)) settings.onEscPressed(); // callback
                showWindow(false);
            }
        });
    };

})(jQuery);
