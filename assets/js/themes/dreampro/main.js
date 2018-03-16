$(document).ready(function () {
    var xside = parseFloat($('.xh').height()) - 115;
    $('#container #sidebar ul').css('max-height', xside);

    $(window).resize(function () {
        var winW = $(window).width();

        if (winW > 980) {
            $('.hdbox.hdside i').removeAttr('class');
            $('.hdbox.hdside i').attr('class', 'fa fa-close fa-fw');

            $('.hdbox.hdside').attr('active', true);
            $('#container #sidebar').css('left', '0');
        } else {
            $('.hdbox.hdside i').removeAttr('class');
            $('.hdbox.hdside i').attr('class', 'fa fa-bars fa-fw');

            $('.hdbox.hdside').removeAttr('active');
            $('#container #sidebar').css('left', '-100%');
        }

        var xside = parseFloat($('.xh').height()) - 115;
        $('#container #sidebar ul').css('max-height', xside);
    })

    $(document).on("click", ".hdbox.hdside", function () {
        if ($(this).attr('active') == 'true') {
            $('.hdbox.hdside i').removeAttr('class');
            $('.hdbox.hdside i').attr('class', 'fa fa-bars fa-fw');

            $(this).removeAttr('active');
            $('#container #sidebar').css('left', '-100%');
        } else {
            $('.hdbox.hdside i').removeAttr('class');
            $('.hdbox.hdside i').attr('class', 'fa fa-close fa-fw');

            $(this).attr('active', true);
            $('#container #sidebar').css('left', '0');

            var xside = parseFloat($('.xh').height()) - 115;
            $('#container #sidebar ul').css('max-height', xside);
        }
    })

    $(document).on("click", ".checkall", function () {
        $('.showlevel input:checkbox').prop('checked', this.checked);

        $(".showlevel").each(function () {
            idx = $(this).attr('id');

            if ($('.showlevel#' + idx + ' input:checkbox').is(':checked') == true) {
                $('.' + idx).slideDown('fast', function () {
                    $(this).attr('active', 'true');
                });
            } else {
                $('.' + idx).slideUp('fast', function () {
                    $(this).removeAttr('active');
                });
            }
        });
    });

    $(document).on("keyup", ".filter", function (e) {
        var filter = $(this).val();

        $(".showlevel.checkbox").each(function (index) {
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).fadeOut();
            } else {
                $(this).show();
            }
        });

        if (filter == '') {
            showcheck()
        }

        e.preventDefault();
    });

    $(document).on("click", ".showlevel.checkbox", function (e) {
        idx = $(this).attr('id');
        checkx = $('#' + idx + ' input:checkbox');

        if (checkx.is(':checked') == true) {
            if ($('.' + idx).length > 0) {
                if ($('.' + idx).attr('active') == 'true') {
                    checkx.prop('checked', false);
                }
            } else {
                checkx.prop('checked', false);
            }
        } else {
            checkx.prop('checked', true);
        }

        if (checkx.is(':checked') == true) {
            if ($(".showlevel." + idx).length > 0) {
                showlevel(idx, true)
            }
        } else {
            if ($(".showlevel." + idx).length > 0) {
                showlevel(idx, false)
            }
        }

        e.preventDefault();
    });

    var flag = 'gp-default';
    $('.mnmenu').click(function () {
        var id = $(this).attr('id');

        if (id != flag) {
            $('#' + flag).removeAttr('class');
            $('div#' + flag).removeAttr('active');
            $('div#' + flag).slideUp('fast');

            $('#' + id).addClass('mnmenu mn-active');

            $('div#' + id).slideDown('fast', function () {
                $(this).attr('active', true);
            });
        } else {
            if ($('div#' + flag).attr('active') == 'true') {
                $('div#' + flag).slideUp('fast', function () {
                    $('#' + flag).removeAttr('class');
                    $('#' + flag).addClass('mnmenu');
                    $(this).attr('active', false);
                });
            } else {
                $('div#' + id).slideDown('fast', function () {
                    $('#' + id).addClass('mnmenu mn-active');
                    $(this).attr('active', true);
                });
            }
        }

        flag = id;
    });

    $(document).on("click", ".mnradio", function (e) {
        var id = $(this).attr('for');
        var act = $(this).attr('active');

        $('.boxradio .mnradio').each(function () {
            var idx = $(this).attr('for');
            var actx = $(this).attr('active');
            if (id != idx && actx == 'true') {
                $('.boxradio .' + idx).slideUp('fast');
                $(this).removeAttr('active');
            }
        });

        if (act == undefined) {
            $('.boxradio .' + id).slideDown('fast');
            $(this).attr('active', true);

            if ($('.boxradio label.error').attr('style') == undefined || $('.boxradio label.error').attr('style') != '') {
                $('.boxradio label.error').remove();
            }
        }
    });

    $('#routertable tr td textarea, #formtable tr td textarea, .boxtab textarea').each(function () {
        if ($(this).attr('class') == 'tiny-active') {
            var idx = $(this).attr('id');
            var cnx = $('#is_' + idx).html();
            if (cnx != '') {
                $('#' + idx).html(cnx);
            }
            tinymcework(idx);
            $('#is_' + idx).html('');
        }
    });

    $('#routertable tr td .date_time, #formtable tr td .date_time, .boxtab .date_time').each(function () {
        var xid = $(this).attr('id');
        $('#' + xid).datetimepicker({
            format: 'd-m-Y H:i',
            step: 5
        });
    });

    $('#routertable tr td .colorcode, #formtable tr td .colorcode, .boxtab .colorcode').each(function () {
        var xid = $(this).attr('id');
        var xrel = $(this).attr('rel');
        $('#' + xid).ColorPicker({
            onSubmit: function (hsb, hex, rgb, el) {
                $(el).val(hex);
                $(el).ColorPickerHide();
                $('#' + xrel).css({background: '#' + hex});
            },
            onBeforeShow: function () {
                $(this).ColorPickerSetColor(this.value);
            }
        })
    });

    $('#routertable tr td .birthday, #formtable tr td .birthday, .boxtab .birthday').each(function () {
        var xid = $(this).attr('id');
        $('#' + xid).datetimepicker({
            format: 'd-m-Y',
            timepicker: false,
            closeOnDateSelect: true,
        });
    });

    $('#routertable tr td .timer, #formtable tr td .timer, .boxtab .timer').each(function () {
        var xid = $(this).attr('id');
        $('#' + xid).datetimepicker({
            datepicker: false,
            format: 'H:i'
        });
    });

    $(document).on('keypress', '.hashtag', function (e) {
        var val = $(this).val();
        var tag = $(this).attr('id');
        var show = $(this).attr('show');
        $(':input[type="submit"]').prop('disabled', true);

        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();

            $('#' + tag).val('').focus();

            var itag = 1;

            // Check Already Count
            var valID = [];
            $('.box' + tag).each(function (i) {
                var id = $(this).attr('id');
                if (id !== undefined) {
                    valID[i] = $('#' + id + '_in').val();
                    itag = parseInt($(this).attr('val')) + 1;
                }
            });

            var x = 0;
            $.each(valID, function (i, value) {
                if (value == val) {
                    x = 1;
                }
            });

            var split = tag.split('_');
            var xtag = (split[1]) ? split[0] : tag;

            if (x == 0) {
                $('.' + show).append(
                    '<div class="ibox box' + tag + '" id="' + tag + '_' + itag + '" val="' + itag + '">'
                        + '<span>'
                            + val +
                            '<a href="javascript:void(0)" onclick="remove_item(\'#' + tag + ',' + itag + '\')" class="cl-red"><i class="fa fa-times fa-fw"></i></a>'
                        + '</span>'
                        + '<input type="hidden" id="' + tag + '_' + itag + '_in" name="' + xtag + '[]" value="' + val + '">'
                    + '</div>'
                );
            }

            $(':input[type="submit"]').prop('disabled', false);

            if(split[1])
            {
                $('.showhide_' + split[1]).hide();
                $('.showhide_' + split[1]).removeAttr('val');
                $('.result_' + split[1]).html('');
            }

            return false;
        }
    });

    $(document).on('mouseover', 'body', function () {
        var wait = $(this).data("wait");
        if (wait) {
            clearInterval(wait);
        }

        wait = setInterval(function () {
            var base_url = $('.base_url').attr('val');

            $.post(base_url + "login/session_checking", function (data) {
                if (data == "0") {
                    alert("Your session has been expired!");
                    window.location = (base_url + 'login');
                }
            });
        }, 50000);

        $(this).data("wait", wait);
        return false;
    });
});

//function session_checking()
//{
//    var base_url = $('.base_url').attr('val');
//    
//    $.post(base_url+"login/session_checking", function(data) {
//        if(data == "0")
//        {
//            alert("Your session has been expired!");
//            window.location=(base_url+'login');
//        }
//    });
//}

function showlevel(idx, stats) {
    if (stats == true) {
        $(".showlevel." + idx).each(function () {
            ids = $(this).attr('id');
            $('#' + ids).slideDown('fast', function () {
                $(this).attr('active', 'true');
            });

            if ($('#' + ids + ' input:checkbox').is(':checked') == true && $(".showlevel." + ids).length > 0) {
                showlevel(ids, stats);
            }
        });
    } else {
        $(".showlevel." + idx).each(function () {
            ids = $(this).attr('id');
            $('#' + ids).slideUp('fast', function () {
                $(this).removeAttr('active');
            });

            if ($(".showlevel." + ids).length > 0) {
                showlevel(ids, stats);
            }
        });
    }
}

function showcheck() {
    pr = 0;
    $(".showlevel").each(function () {
        idx = $(this).attr('id');

        if ($('#' + idx).attr('track') != undefined) {
            pr = 0;
        } else {
            pr = 1;
        }

        if ($('#' + idx + ' input:checkbox').is(':checked') == false) {
            if (pr > 0) {
                $('.' + idx).removeAttr('active');
            }
        } else {
            if (pr > 0) {
                $('.' + idx).show();
                $('.' + idx).attr('active', 'true');
            }
        }

        tr = 0;
        if (pr == 0) {
            if ($('#' + idx).attr('track') != undefined) {
                tr = levelcheck($('#' + idx).attr('track'))
            }

            if (tr > 0) {
                $('#' + idx).show();
                $('#' + idx).attr('active', 'true');
            } else {
                $('#' + idx).hide();
                $('#' + idx).removeAttr('active');
            }
        }
    });
}

function levelcheck(track, me = 0, tr = 0, loop = 0) {
    if ($('#' + track).attr('track') != undefined && track != undefined) {
        tr = ($('#' + track + ' input:checkbox').is(':checked') == true) ? 1 : 0;
        if (loop == 0) {
            me = tr
        }
    } else {
        if ($('#' + track + ' input:checkbox').is(':checked') == true) {
            if (tr == 0 && loop > 0) {
                tr = 0;
            } else {
                if (me == 0 && loop > 0) {
                    tr = ($('#' + track).attr('track') != undefined) ? 1 : 0;
                } else {
                    tr = 1;
                }
            }
        } else {
            tr = 0;
        }
    }

    if ($('#' + track).attr('track') != undefined && track != undefined) {
        track = $('#' + track).attr('track');
        return levelcheck(track, me, tr, 1);
    } else {
        return tr;
    }
}

function actcheckall(id) {
    $('.ctab').attr('checked', $('#' + id).is(':checked'));
    $('#checkall').click(function () {
        $('.ctab').prop('checked', this.checked);
    });
}

function actmenu(urlx) {
    var base_url = $('.base_url').attr('val');

    $('.boxcontent').fadeOut(0);
    if ($('#loadmenu').attr('val') != 'true') {
        $('#content').fadeIn(500).append("<div id='loadmenu' val='true'></div>");
    }

    $.ajax({
        type: "post",
        url: base_url + urlx,
        data: "val=true",
        cache: false,
        success: function (msg) {
            $('#loadmenu').fadeOut(500).remove();
            $('.boxcontent').fadeIn(500).html(msg.vHtml);

            if (msg.sortDir == 'desc') {
                $('.csort').attr('val', 'asc');
            } else {
                $('.csort').attr('val', 'desc');
            }

            nav_first();
        }
    });

    var urlNew = urlSplit(urlx)
    urlUpdate(urlNew);
}

function actcheck(urlx, getx) {
    var jqtest = $('.jqtest').attr('val');
    var base_url = $('.base_url').attr('val');
    var caction = $('.caction').val();
    var val = [];
    $('.ctab:checked').each(function (i) {
        val[i] = $(this).val();
    });

    //if (caction == 1) {
    if (confirm('Do you want to run this action?')) {
        if (getx != undefined) {
            caction = caction + getx;
        }

        if (val == "") {
            return false;
        } else {
            $('#boxjq').fadeOut(0);
            $('.boxcontent').fadeIn(500).append("<div id='loading'></div>");

            var request = $.ajax({
                type: "post",
                url: base_url + urlx + "/" + caction,
                data: "val=true&checked=" + val,
                cache: false
            });

            actrequest(request);
        }
    }

    return false;
    /*} else {
     if (val == "") {
     return false;
     } else {
     if (getx != undefined) {
     caction = caction+getx;
     }

     $('#boxjq').fadeOut(0);
     $('.boxcontent').fadeIn(500).append("<div id='loading'></div>");

     var request = $.ajax({
     type: "post",
     url: base_url+urlx+"/"+caction,
     data: "val=true&checked="+val,
     cache: false
     });

     actrequest(request);
     }
     }*/
}

function actlimit(urlx) {
    var base_url = $('.base_url').attr('val');
    var val = $('.climit').val();

    if ($('#actload').attr('val') != 'true') {
        $('.search').fadeIn(500).before("<div id='actload' val='true'></div>");
    }

    var request = $.ajax({
        type: "post",
        url: base_url + urlx,
        data: "val=" + val,
        cache: false,
        success: function (msg) {
            $("#boxjq").html(msg.vHtml);
            $('#actload').fadeOut(500).remove();

            if (msg.sortDir == 'desc') {
                $('.csort').attr('val', 'asc');
            } else {
                $('.csort').attr('val', 'desc');
            }

            nav_first();
        }
    });
}

function actsort(idx) {
    var base_url = $('.base_url').attr('val');
    var urlx = $('#showsort').attr('value');

    if ($('#routertable #' + idx).attr('val') != undefined) {
        var val = [idx, $('#routertable #' + idx).attr('val')];
    } else {
        var val = [idx, $('.boxtab #' + idx).attr('val')];
    }

    if ($('#actload').attr('val') != 'true') {
        $('.search').fadeIn(500).before("<div id='actload' val='true'></div>");
    }

    var request = $.ajax({
        type: "post",
        url: base_url + urlx,
        data: "val=" + val,
        cache: false,
        success: function (msg) {
            $("#boxjq").html(msg.vHtml);
            $('#actload').fadeOut(500).remove();

            if (val[1] == 'desc') {
                $('.csort').attr('val', 'asc');
            } else {
                $('.csort').attr('val', 'desc');
            }

            nav_first();
        }
    });
}

function actsearch(urlx) {
    var wait = $(this).data('wait');
    var base_url = $('.base_url').attr('val');

    if (wait) {
        clearTimeout(wait);
    }

    wait = setTimeout(function () {
        var val = [];
        $('.cinput').each(function (i) {
            val[i] = $(this).val();
        });

        if ($('#actload').attr('val') != 'true') {
            $('.search').fadeIn(500).before("<div id='actload' val='true'></div>");
        }

        var request = $.ajax({
            type: "post",
            url: base_url + urlx,
            data: "val=" + val,
            cache: false,
            success: function (msg) {
                $("#boxjq").html(msg.vHtml);
                $('#actload').fadeOut(500).remove();

                if (msg.sortDir == 'desc') {
                    $('.csort').attr('val', 'asc');
                } else {
                    $('.csort').attr('val', 'desc');
                }

                nav_first();
            }
        });
    }, 500);

    $(this).data('wait', wait);
    return false;
}

function openform(urlx) {
    var base_url = $('.base_url').attr('val');

    $('.boxcontent').fadeOut(0);
    $('#content').fadeIn(500).append("<div id='loadmenu'></div>");

    $.ajax({
        type: "post",
        url: base_url + urlx,
        data: "val=true",
        cache: false,
        success: function (msg) {
            $('#loadmenu').fadeOut(500).remove();

            if (msg.xState == false) {
                $('.boxcontent').fadeIn(500);
                $('#boxmessage').fadeIn(500).html("<div class='" + msg.xCss + "'>" + msg.xMsg + "</div>");
            } else {
                $('.boxcontent').fadeIn(500).html(msg);
            }
        },
        complete: function () {
            $('#routertable tr td textarea, #formtable tr td textarea, .boxtab textarea').each(function () {
                if ($(this).attr('class') == 'tiny-active') {
                    var idx = $(this).attr('id');
                    var cnx = ($('#is_' + idx).html() != undefined) ? $('#is_' + idx).html() : '';
                    $('#' + idx).val(cnx);

                    tinymcework(idx);
                    $('#is_' + idx).html('');
                }
            });

            $('#routertable tr td .date_time, #formtable tr td .date_time, .boxtab .date_time').each(function () {
                var xid = $(this).attr('id');
                $('#' + xid).datetimepicker({
                    format: 'd-m-Y H:i',
                    step: 5
                });
            });

            $('#routertable tr td .colorcode, #formtable tr td .colorcode, .boxtab .colorcode').each(function () {
                var xid = $(this).attr('id');
                var xrel = $(this).attr('rel');
                $('#' + xid).ColorPicker({
                    onSubmit: function (hsb, hex, rgb, el) {
                        $(el).val(hex);
                        $(el).ColorPickerHide();
                        $('#' + xrel).css({background: '#' + hex});
                    },
                    onBeforeShow: function () {
                        $(this).ColorPickerSetColor(this.value);
                    }
                })
            });

            $('#routertable tr td .birthday, #formtable tr td .birthday, .boxtab .birthday').each(function () {
                var xid = $(this).attr('id');
                $('#' + xid).datetimepicker({
                    format: 'd-m-Y',
                    timepicker: false,
                    closeOnDateSelect: true,
                });
            });

            $('#routertable tr td .timer, #formtable tr td .timer, .boxtab .timer').each(function () {
                var xid = $(this).attr('id');
                $('#' + xid).datetimepicker({
                    datepicker: false,
                    format: 'H:i'
                });
            });

            FileStore = [];
            setTimeout(function () {
                init_upload()
            }, 500);
        }
    });

    var urlNew = urlSplit(urlx)
    urlUpdate(urlNew);
}

function saveadd(urlx, cnfx) {
    if ($('#form_add').valid()) {
        var jqtest = $('.jqtest').attr('val');
        var base_url = $('.base_url').attr('val');

        var cnt = 1;
        if (cnfx != undefined) {
            if (confirm('Do you want to process data?')) {
                var cnt = 1;
            } else {
                var cnt = 0;
                return false;
            }
        }

        if (cnt > 0) {
            if ($('#tabs').val() == undefined) {
                $('#boxjq').fadeOut(0);
                $('.boxcontent').fadeIn(500).append("<div id='loading'></div>");
            } else {
                if ($('#actload').attr('val') != 'true') {
                    $('.search').fadeIn(500).before("<div id='actload' val='true'></div>");
                }
            }

            $('.boxtab textarea').each(function () {
                if ($(this).attr('class') == 'tiny-active') {
                    var idx = $(this).attr('id');

                    $('#boxjq form').append("<input type='hidden' name='" + idx + "' id='" + idx + "'>");

                    var r = tinymce.get(idx).getContent()
                        .replace(/<[^>]*>/ig, ' ')
                        .replace(/<\/[^>]*>/ig, ' ')
                        .replace(/&nbsp;|&#160;/gi, ' ')
                        .replace(/\s+/ig, ' ')
                        .trim();

                    if (r == '') {
                        $('input#' + idx).val(r);
                    } else {
                        $('input#' + idx).val(tinymce.get(idx).getContent());
                    }
                }
            });

            $('#routertable tr td textarea, #formtable tr td textarea').each(function () {
                if ($(this).attr('class') == 'tiny-active') {
                    var idx = $(this).attr('id');

                    $('#boxjq form').append("<input type='hidden' name='" + idx + "' id='" + idx + "'>");

                    var r = tinymce.get(idx).getContent()
                        .replace(/<[^>]*>/ig, ' ')
                        .replace(/<\/[^>]*>/ig, ' ')
                        .replace(/&nbsp;|&#160;/gi, ' ')
                        .replace(/\s+/ig, ' ')
                        .trim();

                    if (r == '') {
                        $('input#' + idx).val(r);
                    } else {
                        $('input#' + idx).val(tinymce.get(idx).getContent());
                    }
                }
            });

            if (jqtest == 'true') {
                var dtype = 'text';
            } else {
                var dtype = 'json';
            }

            $(document).on('submit', '#form_add', function (e) {
                e.preventDefault();
                var formURL = $(this).attr('action');
                var postData = $(this).serializeArray();

                var val = [];
                $('.ctab:checked').each(function (i) {
                    val[i] = $(this).val();
                });

                if (val.length > 0) {
                    var cnData = {name: 'checked', value: val};
                    postData = postData.concat(cnData)
                }

                var request = $.ajax({
                    type: "post",
                    url: formURL,
                    data: postData,
                    cache: false
                });

                actreqform(request);
                e.stopImmediatePropagation();
            });

            var urlNew = urlSplit(urlx)
            urlUpdate(urlNew);
        }
    }
}

function saveaddmulti(urlx, cnfx) {
    if ($('#form_addmulti').valid()) {
        var jqtest = $('.jqtest').attr('val');
        var base_url = $('.base_url').attr('val');

        var cnt = 1;
        if (cnfx != undefined) {
            if (confirm('Do you want to process data?')) {
                var cnt = 1;
            } else {
                var cnt = 0;
                return false;
            }
        }

        if (cnt > 0) {
            $('#boxjq').fadeOut(0);
            $('.boxcontent').fadeIn(500).append("<div id='loading'></div>");

            $('.boxtab textarea').each(function () {
                if ($(this).attr('class') == 'tiny-active') {
                    var idx = $(this).attr('id');

                    $('#boxjq form').append("<input type='hidden' name='" + idx + "' id='" + idx + "'>");

                    var r = tinymce.get(idx).getContent()
                        .replace(/<[^>]*>/ig, ' ')
                        .replace(/<\/[^>]*>/ig, ' ')
                        .replace(/&nbsp;|&#160;/gi, ' ')
                        .replace(/\s+/ig, ' ')
                        .trim();

                    if (r == '') {
                        $('input#' + idx).val(r);
                    } else {
                        $('input#' + idx).val(tinymce.get(idx).getContent());
                    }
                }
            });

            $('#routertable tr td textarea, #formtable tr td textarea').each(function () {
                if ($(this).attr('class') == 'tiny-active') {
                    var idx = $(this).attr('id');

                    $('#boxjq form').append("<input type='hidden' name='" + idx + "' id='" + idx + "'>");

                    var r = tinymce.get(idx).getContent()
                        .replace(/<[^>]*>/ig, ' ')
                        .replace(/<\/[^>]*>/ig, ' ')
                        .replace(/&nbsp;|&#160;/gi, ' ')
                        .replace(/\s+/ig, ' ')
                        .trim();

                    if (r == '') {
                        $('input#' + idx).val(r);
                    } else {
                        $('input#' + idx).val(tinymce.get(idx).getContent());
                    }
                }
            });

            if (jqtest == 'true') {
                var dtype = 'text';
            } else {
                var dtype = 'json';
            }

            $(document).on('submit', '#form_addmulti', function (e) {
                e.preventDefault();

                if (FileStore.length > 0) {
                    var FStore = [];
                    FileStore.map(function (v) {
                        FStore.push(v.data);
                    })
                    $(this).append("<input type='hidden' name='filestore' value='" + JSON.stringify(FStore) + "'>");
                }

                var formURL = $(this).attr('action');
                var formData = new FormData(this);

                var request = $.ajax({
                    type: "post",
                    url: formURL,
                    data: formData,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false
                });

                actreqform(request);
                e.stopImmediatePropagation();
            });

            var urlNew = urlSplit(urlx)
            urlUpdate(urlNew);
        }
    }
}

function deleteid(urlx) {

    if (confirm('Do you want to delete?')) {
        var jqtest = $('.jqtest').attr('val');
        var base_url = $('.base_url').attr('val');

        $('#boxjq').fadeOut(0);
        $('.boxcontent').fadeIn(500).append("<div id='loading'></div>");

        var request = $.ajax({
            type: "post",
            url: base_url + urlx,
            data: "val=true",
            cache: false
        });

        actrequest(request);
    }

    return false;
}

function actbutton(urlx) {

    var jqtest = $('.jqtest').attr('val');
    var base_url = $('.base_url').attr('val');

    $('#boxjq').fadeOut(0);
    $('.boxcontent').fadeIn(500).append("<div id='loading'></div>");

    var request = $.ajax({
        type: "post",
        url: base_url + urlx,
        data: "val=true",
        cache: false
    });

    actrequest(request);
}

function actreqform(request) {
    var jqtest = $('.jqtest').attr('val');

    if (jqtest == 'true') {
        request.done(function (msg) {
            $('.xdsoft_datetimepicker').remove();
            $('#loading').fadeOut(500).remove();
            $('.boxcontent').fadeIn(500).html(msg);
        });
    } else {
        request.done(function (msg) {
            if (Object.prototype.toString.call(msg) == '[object String]') {
                msg = JSON.parse(msg);
            } //console.log(msg);

            if (msg.xReport == true) {
                $('.boxcontent').fadeIn(500).html(msg.vHtml);
            } else {
                $('.xdsoft_datetimepicker').remove();
                $('#loading').fadeOut(500).remove();

                if (msg.xSplit != undefined) {
                    $('#boxjq').fadeIn(500);
                    $.each(msg.xData, function (v, n) {
                        if (Object.prototype.toString.call(n) == '[object Object]') {
                            $.each(n, function (v1, n1) {
                                $('.' + v + ' .' + v1).html(n1).show();
                                if (n1 == '') {
                                    $('.' + v).hide();
                                }
                            })
                        } else {
                            $('.' + v).html(n).show();
                            if (n == '') {
                                $('.' + v).hide();
                            }
                        }
                    })
                } else {
                    if (msg.xState == false) {
                        $('#boxjq').fadeIn(500);
                    } else {
                        $('.boxcontent').fadeIn(500).html(msg.vHtml);
                    }
                }

                if (msg.xMsg != undefined) {
                    $('#boxmessage').fadeIn(500).html("<div class='" + msg.xCss + "'>" + msg.xMsg + "</div>");
                }

                nav_first();
            }

            $('.boxtab textarea').each(function () {
                if ($(this).attr('class') == 'tiny-active') {
                    var idx = $(this).attr('id');
                    var cnx = ($('#is_' + idx).html() != undefined) ? $('#is_' + idx).html() : '';
                    $('#' + idx).val(cnx);
                    console.log(cnx);

                    tinymcework(idx);
                    $('#is_' + idx).html('');
                }
            });

            $('#routertable tr td textarea, #formtable tr td textarea').each(function () {
                if ($(this).attr('class') == 'tiny-active') {
                    var idx = $(this).attr('id');
                    var cnx = ($('#is_' + idx).html() != undefined) ? $('#is_' + idx).html() : '';
                    $('#' + idx).val(cnx);
                    console.log(cnx);

                    tinymcework(idx);
                    $('#is_' + idx).html('');
                }
            });
        });

        request.fail(function (jqXHR, textStatus) {
            $('#loading').fadeOut(500).remove();
            $('#boxjq').fadeIn(500);
            $('#boxmessage').fadeIn(500).html("<div class='boxfailed'>Request failed: " + textStatus + "</div>");

            history.pushState({url: "" + urlHistory + ""}, "", urlHistory);
        });
    }
}

function actrequest(request) {
    var jqtest = $('.jqtest').attr('val');

    if (jqtest == 'true') {
        request.done(function (msg) {
            $('#loading').fadeOut(500).remove();
            $('#boxjq').fadeIn(500).html(msg);
        });
    } else {
        request.done(function (msg) {
            $('#loading').fadeOut(500).remove();

            if (msg.xSplit != undefined) {
                $('#boxjq').fadeIn(500);
                $.each(msg.xData, function (v, n) {
                    if (Object.prototype.toString.call(n) == '[object Object]') {
                        $.each(n, function (v1, n1) {
                            $('.' + v + ' .' + v1).html(n1).show();
                            if (n1 == '') {
                                $('.' + v).hide();
                            }
                        })
                    } else {
                        $('.' + v).html(n).show();
                        if (n == '') {
                            $('.' + v).hide();
                        }
                    }
                })
            } else {
                if (msg.xState == false) {
                    $('#boxjq').fadeIn(500);
                } else {
                    $('#boxjq').fadeIn(500).html(msg.vHtml);

                    nav_first();
                }
            }

            $('#boxmessage').fadeIn(500).html("<div class='" + msg.xCss + "'>" + msg.xMsg + "</div>");

            //nav_first();
        });

        request.fail(function (jqXHR, textStatus) {
            $('#loading').fadeOut(500).remove();
            $('#boxjq').fadeIn(500);
            $('#boxmessage').fadeIn(500).html("<div class='boxfailed'>Request failed: " + textStatus + "</div>");

            history.pushState({url: "" + urlHistory + ""}, "", urlHistory);
        });
    }
}

function urlSplit(urlx) {
    var base_url = $('.base_url').attr('val');
    var split = urlx.split("/");
    var urlNew = '';
    var ux = 0;
    split.map(function (uri) {
        if (ux > 0) {
            var xr = 1;
            switch (uri) {
                case 'view':
                case 'save':
                case 'update':
                case 'delete':
                    xr = 0;
                    break;
            }

            if (xr > 0) {
                urlNew = urlNew + '/' + uri;
            }
        } else {
            urlNew = base_url + uri;
        }
        ux++;
    })

    return urlNew;
}

var urlHistory = '';
function urlUpdate(urlPath) {
    urlHistory = (history.state != null) ? history.state.url : '';
    history.pushState({url: "" + urlPath + ""}, "", urlPath);
}

var tabb = '';
function tabbutton(id) {
    $('#boxtable div').each(function () {
        if ($(this).attr('class') == 'btn-active') {
            var idx = $(this).attr('id');

            $('.' + idx).removeClass('btn-active');
            $('#' + idx).removeAttr('class');
            $('div#' + idx).fadeOut(0);

            var fltab = idx;
        }
    });

    if (tabb != id) {
        $('.' + id).addClass('btn-active');
        $('#' + id).attr('class', 'btn-active');
        $('div#' + id).fadeIn('fast');

        tabb = id;
    } else {
        tabb = '';
    }


}

function tabmenu(id) {
    $('#boxtable ul li a').each(function () {
        if ($(this).attr('class') == 'tab-active') {
            var idx = $(this).attr('id');

            $('#' + idx).removeAttr('class');
            $('div#' + idx).fadeOut(0);

            var fltab = idx;
        }
    });

    $('#' + id).attr('class', 'tab-active');
    $('div#' + id).fadeIn('fast');
}

function tabflag(id) {
    $('#boxbutton ul li a').each(function () {
        if ($(this).attr('class') == 'flag-active') {
            var idx = $(this).attr('id');

            $('a#' + idx).removeAttr('class');
            $('div.btn#' + idx).fadeOut(0);
            $('div#' + idx).fadeOut(0);

            var fltab = idx;
        }
    });

    $('.textflag ul li a').each(function () {
        if ($(this).attr('class') == 'flag-active') {
            var idx = $(this).attr('id');

            $('a#' + idx).removeAttr('class');
            $('div.btn#' + idx).fadeOut(0);
            $('div#' + idx).fadeOut(0);

            var fltab = idx;
        }
    });

    $('a#' + id).attr('class', 'flag-active');
    $('div.btn#' + id).fadeIn('fast');
    $('div#' + id).fadeIn('fast');
}

function tinymcework(idx) {
    var base_url = $('.base_url').attr('val');

    tinymce.init({
        selector: "textarea#" + idx,
        theme: "modern",
        plugins: [
            "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template textcolor paste fullpage textcolor, importcss"
        ],

        toolbar1: "formatselect fontselect fontsizeselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist table forecolor backcolor"
        + " outdent indent blockquote link unlink image media | searchreplace code preview print fullscreen | insertfile insertimage",
        image_advtab: true,
        menubar: false,
        relative_urls: false,
        remove_script_host: false,
        convert_urls: true,
        toolbar_items_size: 'small',
        file_browser_callback: function (field, url, type, win) {
            tinyMCE.activeEditor.windowManager.open({
                file: base_url + '../assets/js/kcfinder/?opener=tinymce4&field=' + field + '&type=' + type,
                title: 'KCFinder',
                width: 700,
                height: 500,
                inline: true,
                close_previous: false
            }, {
                window: win,
                input: field
            });
            return false;
        }
    });

    //tinymce.activeEditor.setContent('');
    //tinymce.get(idx).getContent(''); 
}

/* Google Map */

var latlng = {lat: '', lng: ''};
var markers = [];
var stoplisten = 1;
var isAutocomplete = false;
var map, marker, infowindow, geocoder;

$(document).on('click', '#map-pinpoint', function (e) {
    geoListener(map, infowindow, geocoder, latlng, true);
    setTimeout(function () {
        $('#pac-input').val($('#location_address').val());
    }, 500);

    e.preventDefault();
});

function setDataMap(location, address, clear) {
    $('#pac-input').val('');
    if (clear != undefined) {
        $('#location_lat').val('');
        $('#location_long').val('');
        $('#location_address').val('');
    } else {
        $('#location_lat').val(location.lat);
        $('#location_long').val(location.lng);
        $('#location_address').val(address);
    }
}

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {zoom: 17});
    geocoder = new google.maps.Geocoder;
    infowindow = new google.maps.InfoWindow();
    //console.log(latlng);

    // Set Default Location
    if (latlng.lat != '' && latlng.lng != '') {
        map.setCenter(latlng);

        var marker = new google.maps.Marker({
            position: latlng,
            map: map
        });
        markers.push(marker);

        geoListener(map, infowindow, geocoder, latlng);
    } else {
        geocoder.geocode({'address': 'Monas, Jakarta'}, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                map.setZoom(16);
                map.setCenter(results[0].geometry.location);
            } else {
                window.alert('Geocode was not successful for the following reason: ' + status);
            }
        });

        // Geolocation GPS
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                stoplisten = 1;

                var location = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                map.setZoom(17);
                map.setCenter(location);

                var marker = new google.maps.Marker({
                    position: location,
                    map: map
                });
                markers.push(marker);

                geoListener(map, infowindow, geocoder, latlng);
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infowindow, map.getCenter());
        }
    }

    // Result Map Center show after move Maps
    google.maps.event.addListener(map, 'idle', function () {
        if (isAutocomplete) {
            isAutocomplete = false;
            return;
        }

        //console.log(stoplisten);
        if (stoplisten == 0) {
            geoListener(map, infowindow, geocoder, latlng);
        } else {
            stoplisten = 0;
        }
    });

    // Link Search Box to the UI Element
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);

    map.addListener('bounds_changed', function () {
        searchBox.setBounds(map.getBounds());
    });

    searchBox.addListener('places_changed', function () {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        deleteMarkers();

        var bounds = new google.maps.LatLngBounds();
        if (places.length > 1) {
            map.fitBounds(bounds);
        } else {
            stoplisten = 1;

            var location = {
                lat: places[0].geometry.location.lat(),
                lng: places[0].geometry.location.lng()
            };

            map.setZoom(17);
            map.setCenter(location);

            $('#location_lat').val('');
            $('#location_long').val('');
            $('#location_address').val('');
        }
    });

    // This event listener calls addMarker() when the map is clicked.
    google.maps.event.addListener(map, 'click', function (event) {
        isAutocomplete = true;
        addMarker(event.latLng, map, infowindow, geocoder);
    });
}

// Geocoder Location
function geoLocation(location, map, marker, infowindow, geocoder) {
    geocoder.geocode({'location': location}, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            latest_geocode = new GeocoderResult(results);
            infowindow.setContent(latest_geocode.getRecomendationName());
            infowindow.open(map, marker);

            //map.setZoom(17);
            map.setCenter(marker.getPosition());

            setDataMap(location, latest_geocode.getRecomendationName(), true);
        } else {
            window.alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

// Geocoder Location with Listener Maps
function geoListener(map, infowindow, geocoder, location, setdata) {
    latlng = {
        lat: map.getCenter().lat(),
        lng: map.getCenter().lng()
    };

    deleteMarkers();

    var marker = new google.maps.Marker({
        position: latlng,
        map: map
    });
    markers.push(marker);

    geocoder.geocode({'location': latlng}, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            if (results.length > 1) {
                if (location.lat != '' && location.lng != '') {
                    latest_geocode = new GeocoderResult(results);
                    infowindow.setContent(latest_geocode.getRecomendationName());
                    infowindow.open(map, marker);

                    if (setdata != undefined) {
                        setDataMap(latlng, latest_geocode.getRecomendationName());
                    } else {
                        setDataMap(latlng, latest_geocode.getRecomendationName(), true);
                    }
                }

                //map.setZoom(17);
                map.setCenter(marker.getPosition());
            } else {
                window.alert('Geocode was not successful for the following reason: ' + status);
            }
        }
    });
}

// Adds a marker to the map.
function addMarker(location, map, infowindow, geocoder) {
    deleteMarkers();

    var marker = new google.maps.Marker({
        position: location,
        map: map
    });
    markers.push(marker);

    geoLocation(location, map, marker, infowindow, geocoder);
}

// Sets the map on all markers in the array.
function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
    setMapOnAll(null);
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
    clearMarkers();
    markers = [];
}

var GeocoderResult = function (geocoderResults) {
    if (geocoderResults.length < 1) {
        return false;
    }
    var address_components = geocoderResults[0].address_components;
    var reference = this;
    reference.formatted_address = geocoderResults[0].formatted_address;
    address_components.forEach(function (component) {
        component.types.forEach(function (type) {
            switch (type) {
                case "administrative_area_level_3":
                    reference.district = component.long_name;
                    break;
                case "administrative_area_level_2":
                    reference.city = component.long_name;
                    break;
                case "administrative_area_level_1":
                    reference.province = component.long_name;
                    break;
                case "street_address":
                case "route":
                    reference.address = component.long_name;
                    break;
                case "premise":
                    reference.premise = component.long_name;
                    break;
                case "postal_code":
                    reference.postal = component.long_name;
            }
        });
    });
};
GeocoderResult.prototype.getObject = function () {
    return this;
};
GeocoderResult.prototype.getPostal = function () {
    return this.postal;
};
GeocoderResult.prototype.getDistrict = function () {
    return this.district;
};
GeocoderResult.prototype.getCity = function () {
    return this.city;
}
GeocoderResult.prototype.getProvince = function () {
    return this.province;
}
GeocoderResult.prototype.getRecomendationName = function () {
    var result = "";
    if (this.premise && this.premise.length > 5) {
        result += (this.premise + " - ");
    }
    if (this.address && this.address.length > 5) {
        result += (this.address + ", ");
    }
    if (this.district && this.district.length > 3) {
        result += (this.district + ", ");
    }
    if (this.postal) {
        result += (this.postal + " ");
    }
    if (result) {
        return result;
    } else if (this.formatted_address) {
        return this.formatted_address;
    } else {
        return "-";
    }
};


/* Not Active */

//$('#form_add').submit(function(e){
//
//    var formURL = $(this).attr('action');
//    var postData = $(this).serializeArray(); // Form Add Standard
//
//    $.ajax({
//        type: "POST",
//        url: formURL,
//        data: postData,
//        cache: false,
//        success: function(msg)
//        {
//            console.log(msg);
//        }
//    });
//
//    e.preventDefault();
//});

//$('#form_addmulti').submit(function(e){
//
//    var formURL = $(this).attr('action');
//    var formData = new FormData(this); // Form Add & Image
//
//    $.ajax({
//        type: "POST",
//        url: formURL,
//        data: formData,
//        mimeType: "multipart/form-data",
//        contentType: false,
//        cache: false,
//        processData: false,
//        success: function(msg)
//        {
//            console.log(msg);
//        }
//    });
//
//    e.preventDefault();
//});

//$('#checkall').click(function () {
//    $('input:checkbox').prop('checked', this.checked);
//    $('.ctab').prop('checked', this.checked);
//});

//function saveadd(urlx) {
//    if($('#form_add').valid())
//    {
//        var base_url = $('.base_url').attr('val');
//        var val = [];
//        $('.cinput').each(function(i){
//            val[i] = $(this).val();
//        });
//
//        $('#boxjq').fadeOut(0);
//        $('.boxcontent').fadeIn(500).append("<div id='loading'></div>");
//
//        var request = $.ajax({
//            type: "post",
//            url: base_url+urlx,
//            data: "val="+val,
//            cache: false
//        });
//
//        var message = 'Data Successfully Inserted...';
//        actreqform(request, message);
//
//        var split = urlx.split("/");
//
//        if (split[2] != null) {
//            var urlNew = base_url+split[0]+'/'+split[1];
//        } else {
//            var urlNew = base_url+split[0];
//        }
//
//        urlUpdate(urlNew);
//    }
//}

//function updateedit(urlx) {
//    if($('#form_edit').valid())
//    {
//        var base_url = $('.base_url').attr('val');
//        var val = [];
//        $('.cinput').each(function(i){
//            val[i] = $(this).val();
//        });
//
//        $('#boxjq').fadeOut(0);
//        $('.boxcontent').fadeIn(500).append("<div id='loading'></div>");
//
//        var request = $.ajax({
//            type: "post",
//            url: base_url+urlx,
//            data: "val="+val,
//            cache: false
//        });
//
//        var message = 'Data Successfully Updated...';
//        actreqform(request, message);
//
//        var split = urlx.split("/");
//        var urlNew = base_url+split[0];
//        urlUpdate(urlNew);
//    }
//}