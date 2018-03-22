$(document).ready(function (e) {
    $(document).on("click", ".showauto", function () {
        var base_url = $('.base_url').attr('val');
        var idx = $(this).attr('idx');
        var tag = $(this).attr('tag');
        var show = $(this).attr('show');
        var value_id = $(this).attr('val');
        var value_name = $('.' + value_id).attr('val');

        // Hashtag
        if ($('#' + tag + '_' + idx).val() !== undefined) {
            if (show) {
                var itag = 1;

                // Check Already Count
                var valID = [];
                $('.box' + tag + '_' + idx).each(function (i) {
                    var id = $(this).attr('id');
                    if (id !== undefined) {
                        valID[i] = $('#' + id + '_in').val();
                        itag = itag + 1;
                    }
                });

                var x = 0;
                $.each(valID, function (i, value) {
                    if (value === value_id) {
                        x = 1;
                    }
                });

                if (x === 0) {
                    $('.' + show).append(
                        '<span class="ibox box' + tag + '_' + idx + '" id="' + tag + '_' + idx + '_' + itag + '" val="' + itag + '">'
                            + '<span>'
                                + value_name +
                                '<a href="javascript:void(0)" onclick="remove_item(\'#' + tag + '_' + idx + ',' + itag + '\')" class="cl-red"><i class="fa fa-times fa-fw"></i></a>'
                            + '</span>'
                            + '<input type="hidden" id="' + tag + '_' + idx + '_' + itag + '_in" name="' + tag + '_id[]" value="' + value_id + '">'
                        + '</div>'
                    );
                }

                $('#' + tag + '_' + idx).val('');
            } else {
                $('#' + tag + '_' + idx).val(value_name);
                $('#' + tag + '_id_' + idx).val(value_id);
            }
        }

        // Report Summary
        if ($('#history').val() == '') {
            $('#post_id_' + idx).val(value_id);
        }

        // Country
        if ($('#country_name_' + idx).val() != undefined) {
            $('#country_name_' + idx).val(value_name);
        }

        // Iso Code
        if ($('#iso_code_' + idx).val() != undefined) {
            $('#iso_code_' + idx).val(value_name);
        }

        // Language
        if ($('#language_code_' + idx).val() != undefined) {
            $('#language_code_' + idx).val(value_name);
        }

        $('.showhide_' + idx).hide();
        $('.showhide_' + idx).removeAttr('val');
        $('.result_' + idx).html('');
    });

    $(document).on("click", function (e) {
        var clicked = $(e.target);
        if (!clicked.hasClass('input_multi')) {

            // Language
            $('#table_language #boxresult').each(function () {
                if ($(this).attr('val') == 'auto-active') {
                    var show = $(this).attr('class');
                    $("." + show).hide();
                    $("." + show).removeAttr('val');

                    var split = show.split("_");
                    $('.result_' + split[1]).html('');
                }
            });

            $('#boxresult').hide();
            $('.boxresult').slideUp("fast");
        }
    });

    // Single Price User Merchant
    $(document).on('keyup', '#product_price', function () {
        var val = $(this).val();
        var umargin = $('#product_margin').val();

        if (umargin != '') {
            var sval = umargin / 100 * val;

            pval = 0;
            if (val > 0) {
                if (umargin > 0) {
                    pval = parseFloat(val) - parseFloat(sval);
                } else {
                    pval = parseFloat(val);
                }
            }

            $('#product_purchase').val(pval);
        }
    });

    $(document).on('keyup', '#product_margin', function () {
        var umargin = $(this).val();
        var val = $('#product_price').val();

        if (val != '') {
            var sval = umargin / 100 * val;

            pval = 0;
            if (val > 0) {
                if (umargin > 0) {
                    pval = parseFloat(val) - parseFloat(sval);
                } else {
                    pval = parseFloat(val);
                }
            }

            $('#product_purchase').val(pval);
        }

        $('.pack_price').map(function (v) {
            var id = $(this).attr('val');
            var val = $('#pack_price_' + id).val();

            if (val != undefined) {
                if (val != '') {
                    var sval = umargin / 100 * val;

                    pval = 0;
                    if (val > 0) {
                        if (umargin > 0) {
                            pval = parseFloat(val) - parseFloat(sval);
                        } else {
                            pval = parseFloat(val);
                        }
                    }

                    $('#pack_purchase_' + id).val(pval);
                }
            }
        })
    });

    // Packages Price User Merchant
    $(document).on('keyup', '.pack_price', function () {
        var id = $(this).attr('val');
        var val = $(this).val();
        var umargin = $('#product_margin').val();

        if (umargin != '') {
            var sval = umargin / 100 * val;

            pval = 0;
            if (val > 0) {
                if (umargin > 0) {
                    pval = parseFloat(val) - parseFloat(sval);
                } else {
                    pval = parseFloat(val);
                }
            }

            $('#pack_purchase_' + id).val(pval);
        }
    });

    // Multi Price User Merchant
    $(document).on('keyup', '.product_price', function () {
        var id = $(this).attr('val');
        var val = $(this).val();
        var umargin = $('#product_margin_' + id).val();

        if (umargin != '') {
            var sval = umargin / 100 * val;

            pval = 0;
            if (val > 0) {
                if (umargin > 0) {
                    pval = parseFloat(val) - parseFloat(sval);
                } else {
                    pval = parseFloat(val);
                }
            }

            $('#product_purchase_' + id).val(pval);
        }
    });

    $(document).on('keyup', '.product_margin', function () {
        var id = $(this).attr('val');
        var umargin = $(this).val();
        var val = $('#product_price_' + id).val();

        if (val != '') {
            var sval = umargin / 100 * val;

            pval = 0;
            if (val > 0) {
                if (umargin > 0) {
                    pval = parseFloat(val) - parseFloat(sval);
                } else {
                    pval = parseFloat(val);
                }
            }

            $('#product_purchase_' + id).val(pval);
        }
    });
});

var ff = 0;
$(window).load(function () {
    // level
    ff = $('.ulevel').attr('ff');
})

function formatDate(date = '', time) {
    var d = new Date(date);
    xday = ('0' + d.getDate()).slice(-2);
    xmonth = ('0' + (d.getMonth() + 1)).slice(-2);
    xdate = xday + '-' + xmonth + '-' + d.getFullYear();
    xtime = d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();

    if (time) {
        return xdate + ' ' + xtime;
    } else {
        return xdate;
    }
}

// console.info(formatNumber(1000240.5)); // 1000240.50
function formatNumber(num) {
    num = parseInt(num);
    var ss = num.toString().split(".");
    if (ss[1] > 0) {
        return num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1")
    } else {
        return num.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1")
    }
}

// console.info(currencyFormat(102665.4)); // USD 102,665.40
function currencyFormat(num) {
    num = parseInt(num);
    var ss = num.toString().split(".");
    if (ss[1] > 0) {
        return "USD " + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
    } else {
        return "Rp " + num.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
    }
}

// console.info(currencyFormatDE(1234567.89)); // output 1.234.567,89 �
function currencyFormatDE(num) {
    num = parseInt(num);
    return num
            .toFixed(2) // always two decimal digits
            .replace(".", ",") // replace decimal point character with ,
            .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.") + " �" // use . as a separator
}

function remove_value(val) {
    $(val).val('');
    $("a" + val).remove();
    $("img" + val).remove();
    $("video" + val).remove();
}

function remove_item(val) {
    val = val.split(",");

    $(val[0] + "_" + val[1]).fadeOut();
    $(val[0] + "_" + val[1]).remove();
}

function autocommulti(urlx) {
    var wait = $(this).data('wait');
    var base_url = $('.base_url').attr('val');
    var split = urlx.split("/");

    if (split[4] == undefined) {
        var val = $('#' + split[2] + '_' + split[3]).val();
        var idx = split[3];
        var xurlx = split[0] + '/' + split[1] + '/' + split[3];
    } else {
        var val = $('#' + split[3] + '_' + split[4]).val();
        var idx = split[4];
        var xurlx = split[0] + '/' + split[1] + '/' + split[2] + '/' + split[4];
    }

    if (wait) {
        clearTimeout(wait);
    }

    wait = setTimeout(function () {
        $.ajax({
            type: "post",
            url: base_url + xurlx,
            data: "val=" + val,
            cache: false,
            success: function (msg) {
                $('.showhide_' + idx).show();
                $('.showhide_' + idx).attr('val', 'auto-active');
                $('.result_' + idx).html(msg).show();
            }
        });
    }, 500);

    $(this).data('wait', wait);
    return false;
}

function actchain(urlx, valx, showx, datax) {
    var wait = $(this).data('wait');
    var times = 0;
    if ($('.base_url').attr('val') == undefined) {
        times = 500;
        if (wait) {
            clearTimeout(wait);
        }
    }

    wait = setTimeout(function () {
        var base_url = $('.base_url').attr('val');
        var show_val = (showx == undefined) ? $('.show_val').attr('val') : showx;

        var mapper = valx.split("/");
        if (mapper.length > 1) {
            var xVal = [];
            mapper.map(function (val) {
                if ($('#' + val).val() != undefined) {
                    xVal.push($('#' + val).val());
                } else {
                    $('.' + val).each(function () {
                        var idx = $(this).attr('for');
                        var actx = $(this).attr('active');
                        if (actx == 'true') {
                            xVal.push($('#' + idx).val());
                        }
                    });
                }
            })
            var val = xVal;
        } else {
            var val = ($('#' + valx).val() == undefined) ? $('.' + valx).val() : $('#' + valx).val();
        }

        if (val == undefined) {
            var val = [];
            $('.cinput').each(function (i) {
                val[i] = $(this).val();
            });
        }

        if ($('#actload').attr('val') != 'true') {
            if ($('.search').html() == undefined) {
                if ($('#boxbutton ul').html() == undefined) {
                    $('#boxbutton a').fadeIn(500).after("<div id='actload' val='true'></div>");
                } else {
                    $('#boxbutton ul.tabs').fadeIn(500).after("<div id='actload' val='true'></div>");
                }
            } else {
                $('.search').fadeIn(500).before("<div id='actload' val='true'></div>");
            }
        }

        var postdata = "val=" + val
        if (datax != undefined) {
            postdata += "&data=" + datax;
        }

        var request = $.ajax({
            type: "post",
            url: base_url + urlx,
            data: postdata,
            cache: false,
            success: function (msg) {
                if (Object.prototype.toString.call(msg) == '[object String]') {
                    var vHtml = msg.vHtml;
                    if (msg.vHtml == undefined) {
                        var vHtml = msg;
                    }

                    if ($("." + show_val).html() != undefined) {
                        $("." + show_val).html(vHtml).fadeIn('fast');
                    } else {
                        $("#" + show_val).val(vHtml);
                    }
                }

                if (msg.xSplit != undefined) {
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
                }

                $('#actload').fadeOut(500).remove();
            }
        });
    }, times)

    if ($('.base_url').attr('val') == undefined) {
        $(this).data('wait', wait);
    }

    return false;
}

function autoretrive(field, value) {
    var xjson = JSON.parse(value);
    $.each(xjson, function (i, val) {
        var count = 1;

        // Check Already Count
        var valID = [];
        $('.box' + field).each(function (i) {
            if ($('#' + field + '_' + count).attr('val') == count) {
                valID[i] = $('#' + field + '_id_' + count).val();
                count = count + 1;
            }
        });

        $('.show' + field).append(
            '<div class="box' + field + '" id="' + field + '_' + count + '" val="' + count + '">'
            + '<div class="ibox">'
            + val[field + '_name'] +
            '<a href="javascript:void(0)" onclick="remove_item(\'#' + field + ',' + count + '\')" style="color: #dd0000;"><i class="fa fa-times fa-fw"></i></a>'
            + '</div>'
            + '<input type="hidden" id="' + field + '_id_' + count + '" name="' + field + '_id[]" value="' + val[field + '_id'] + '">'
            + '</div>'
        );
    });
}

/* Picture */

function dpost_picture() {
    var tbl = $('table_picture .row');
    var lastRow = tbl.length;
    var count = lastRow;

    // Check Already Count
    if ($('#rows_picture_' + count).val() == count) {
        $('.rows_picture').each(function (i) {
            if ($('#rows_picture_' + count).val() == count) {
                count = count + 1;
            }
        });
    }

    $('#table_picture').append(
        '<div class="row mg-b10 pic_' + count + '">'
        + '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 layout-row">'
        + '<input type="file" class="input_multi" id="uploadpic_' + count + '" name="uploadpic[]">'
        + '<span class="flex"></span>'
        + '<a href="javascript:void(0)" class="btn_action" onclick="remove_item(\'.pic,' + count + '\')"><i class="fa fa-remove fa-fw"></i></a>'
        + '</div>'
        + '<input type="hidden" id="rows_picture_' + count + '" class="rows_picture" name="rows_picture[]" value="' + count + '">'
        + '</div>'
    );
}

function dpost_picture_view(picture_id, picture_pic, path_pic) {
    if (picture_id == undefined) {
        picture_id = '';
    }
    if (picture_pic == undefined) {
        picture_pic = '';
    }
    if (path_pic == undefined) {
        path_pic = '';
    }

    var base_url = $('.base_url').attr('val');
    var tbl = $('table_picture .row');
    var lastRow = tbl.length;
    var count = lastRow;

    // Check Already Count
    if ($('#rows_picture_' + count).val() == count) {
        $('.rows_picture').each(function (i) {
            if ($('#rows_picture_' + count).val() == count) {
                count = count + 1;
            }
        });
    }

    if (picture_id == '') {
        $('#table_picture').append(
            '<div class="row mg-b10 pic_' + count + '">'
            + '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 layout-row">'
            + '<input type="file" class="input_multi" id="uploadpic_' + count + '" name="uploadpic[]">'
            + '<span class="flex"></span>'
            + '<a href="javascript:void(0)" class="btn_action" onclick="remove_item(\'.pic,' + count + '\')"><i class="fa fa-remove fa-fw"></i></a>'
            + '</div>'
            + '<input type="hidden" name="picture_pic[]" value="' + picture_pic + '">'
            + '<input type="hidden" class="picture_id" id="picture_id_' + count + '" name="picture_id[]" value="0">'
            + '<input type="hidden" id="rows_picture_' + count + '" class="rows_picture" name="rows_picture[]" value="' + count + '">'
            + '</div>'
        );
    } else {
        $('#table_picture').append(
            '<div class="row mg-b10 pic_' + count + '">'
            + '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 layout-row">'
            + '<input type="file" class="input_multi" id="uploadpic_' + count + '" name="uploadpic[]">'
            + '<span class="flex"></span>'
            + '<a href="javascript:void(0)" class="btn_action" onclick="remove_item(\'.pic,' + count + '\')"><i class="fa fa-remove fa-fw"></i></a>'
            + '</div>'
            + '<input type="hidden" name="picture_pic[]" value="' + picture_pic + '">'
            + '<input type="hidden" class="picture_id" id="picture_id_' + count + '" name="picture_id[]" value="' + picture_id + '">'
            + '<input type="hidden" id="rows_picture_' + count + '" class="rows_picture" name="rows_picture[]" value="' + count + '">'
            + '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tx-center">'
            + '<img src="' + base_url + '../' + path_pic + '/ori_' + picture_pic + '" class="max-wd">'
            + '</div>'
            + '</div>'
        );
    }

}

function edit_dpost_picture(path_pic = 'upload/post/default') {
    var xjson = JSON.parse($('#xpic').val());

    for (i = 0; i < xjson.length; i++) {
        dpost_picture_view(xjson[i].picture_id, xjson[i].picture_pic, path_pic);
    }
}

/* Information */

function dpost_info(pobject, pid, pname, pdesc) {
    var lgcode = $('#lang_code').val();
    var lgtext = $('#lang_text').val();

    if (pobject == undefined) {
        pobject = '';
    }
    if (pid == undefined) {
        pid = '';
    }
    if (pname == undefined) {
        pname = '';
    }
    if (pdesc == undefined) {
        pdesc = '';
    }

    var tbl = $('table_info .row');
    var lastRow = tbl.length;
    var count = lastRow;

    // Check Already Count
    if ($('#rows_info_' + count).val() == count) {
        $('.rows_info').each(function (i) {
            if ($('#rows_info_' + count).val() == count) {
                count = count + 1;
            }
        });
    }

    var iid = (pid != '') ? '<input type="hidden" id="info_id_' + count + '" class="info_id" name="info_id[]" value="' + pid + '">' : '';
    var iname = '<input type="text" class="input_multi" id="info_name_' + count + '" name="info_name[]" value="' + pname + '" placeholder="Title" required>';
    var idesc = '<textarea name="info_desc[]" id="info_desc_' + count + '" class="tiny-active" rows="15" cols="80" style="height: 300px;">' + pdesc + '</textarea>'
        + '<div id="is_info_desc_' + count + '" style="display: none;">' + pdesc + '</div>';
    if (lgtext != undefined) {
        lgcode = lgcode.split(",");
        lgtext = lgtext.split(",");

        var x = 0;
        var iname = '';
        var idesc = '';
        lgtext.map(function (v) {
            if (pobject != '') {
                pobject['data'].map(function (vn) {
                    if (vn.lang_code == lgcode[x]) {
                        pname = vn.text_title;
                        pdesc = vn.text_desc;
                        return false;
                    }
                })
            }

            var style = (x > 0) ? 'style="display:none;"' : 'style="display:block;"';

            iname += '<div id="tab-' + v + '" ' + style + '>'
                + '<input type="text" class="input_multi" id="info_name_' + count + '" name="info_name[' + v + '][]" value="' + pname + '" placeholder="Title" required>'
                + '</div>';

            idesc += '<div id="tab-' + v + '" ' + style + '>'
                + '<textarea name="info_desc[' + v + '][]" id="info_desc_' + count + '_' + v + '" class="tiny-active" rows="15" cols="80" style="height: 300px;"></textarea>'
                + '<div id="is_info_desc_' + count + '_' + v + '" style="display: none;">' + pdesc + '</div>'
                + '</div>';

            x++;
        })
    }

    $('#table_info').append(
        '<div class="row mg-b10 rel_' + count + '">'
        + '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'
        + '<div class="layout-row">'
        + '<div class="pos-rel wd-100">'
        + iname
        + '</div>'
        + '<span class="flex"></span>'
        + '<a href="javascript:void(0)" class="btn_action" onclick="remove_item(\'.rel,' + count + '\')"><i class="fa fa-remove fa-fw"></i></a>'
        + '</div>'
        + idesc
        + '</div>'
        + iid
        + '<input type="hidden" id="rows_info_' + count + '" class="rows_info" name="rows_info[]" value="' + count + '">'
        + '</div>'
    );

    if (lgtext != undefined) {
        lgtext.map(function (v) {
            var idmce = 'info_desc_' + count + '_' + v;
            var cnx = $('#is_' + idmce).html();
            if (cnx != '') {
                $('#' + idmce).html(cnx);
            }
            tinymcework(idmce);
        })
    } else {
        var idmce = 'info_desc_' + count;
        var cnx = $('#is_' + idmce).html();
        if (cnx != '') {
            $('#' + idmce).html(cnx);
        }
        tinymcework(idmce);
    }
}

function edit_dpost_info() {
    var xjson = JSON.parse($('#vinfo').val());

    for (i = 0; i < xjson.length; i++) {
        var pid = (xjson[i].info_id !== undefined) ? xjson[i].info_id : xjson[i].id;
        var pname = (xjson[i].info_name !== undefined) ? xjson[i].info_name : '';
        var pdesc = (xjson[i].info_desc !== undefined) ? xjson[i].info_desc : '';

        dpost_info(xjson[i], pid, pname, pdesc);
    }
}

/* Available Date */

function dpost_available(pdate, pquota, premain, pseason) {
    if (pdate == undefined) {
        pdate = '';
    }
    if (pquota == undefined) {
        pquota = '';
    }
    if (premain == undefined) {
        premain = '';
    }
    if (pseason == undefined) {
        pseason = '';
    }

    var tbl = $('table_available .row');
    var lastRow = tbl.length;
    var count = lastRow;

    // Check Already Count
    if ($('#rows_available_' + count).val() == count) {
        $('.rows_available').each(function (i) {
            if ($('#rows_available_' + count).val() == count) {
                count = count + 1;
            }
        });
    }

    if (pdate !== '') {
        pdate = formatDate(pdate);
    }

    var xsdata = '';
    var xseason = {no: 0, yes: 1};
    for (var k in xseason) {
        if (pseason == xseason[k]) {
            xsdata += '<option value="' + xseason[k] + '" selected>' + k + '</option>';
        } else {
            xsdata += '<option value="' + xseason[k] + '">' + k + '</option>';
        }
    }

    $('#table_available').append(
        '<div class="row normalize mg-b10 av_' + count + '">'
        + '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pad-r mg-b10">'
        + '<label>High Season</label>'
        + '<div class="layout-row">'
        + '<div class="mg-r5">'
        + '<select name="is_season[]" id="is_season" class="cinput select_router tx-cp" required>'
        + xsdata
        + '</select>'
        + '</div>'
        + '<span class="flex"></span>'
        + '<div class="wd-100">'
        + '<input type="text" class="input_multi date_time_' + count + '" id="av_date_' + count + '" name="av_date[]" value="' + pdate + '" placeholder="Date" required>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">'
        + '<label>Quota</label>'
        + '<div class="layout-row">'
        + '<input type="text" class="input_multi" id="av_quota_' + count + '" name="av_quota[]" value="' + pquota + '" placeholder="Quota" required>'
        //+ '<input type="text" class="input_multi mg-l5" id="av_remain_'+ count +'" name="av_remain[]" value="'+premain+'" placeholder="Remaining" disabled>'
        + '<span class="flex"></span>'
        + '<a href="javascript:void(0)" class="btn_action" onclick="remove_item(\'.av,' + count + '\')"><i class="fa fa-remove fa-fw"></i></a>'
        + '</div>'
        + '</div>'
        + '<input type="hidden" id="rows_available_' + count + '" class="rows_available" name="rows_available[]" value="' + count + '">'
        + '</div>'
    );

    $('.date_time_' + count).datetimepicker({
        format: 'd-m-Y',
        timepicker: false,
        closeOnDateSelect: true
    });
}

function edit_dpost_available() {
    var xjson = JSON.parse($('#vavailable').html());

    for (i = 0; i < xjson.length; i++) {
        dpost_available(xjson[i].data_date, xjson[i].data_quota, xjson[i].data_remain, xjson[i].is_season);
    }
}

/* Packages */

function dpost_packages(pname, pcat, pdesc, ppurchase, pprice, pseason, pspecial, pdisc) {
    if (pname == undefined) {
        pname = '';
    }
    if (pcat == undefined) {
        pcat = '';
    }
    if (pdesc == undefined) {
        pdesc = '';
    }
    if (ppurchase == undefined) {
        ppurchase = '';
    }
    if (pprice == undefined) {
        pprice = '';
    }
    if (pseason == undefined) {
        pseason = '';
    }
    if (pspecial == undefined) {
        pspecial = '';
    }
    if (pdisc == undefined) {
        pdisc = '';
    }

    var tbl = $('table_packages .row');
    var lastRow = tbl.length;
    var count = lastRow;

    // Check Already Count
    if ($('#rows_packages_' + count).val() == count) {
        $('.rows_packages').each(function (i) {
            if ($('#rows_packages_' + count).val() == count) {
                count = count + 1;
            }
        });
    }

    console.log(ff);
    if (ff == 0) {
        var line1 = '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mg-b10">'
            + '<label>Purchase Price</label>'
            + '<input type="number" min="0" class="input_multi" id="pack_purchase_' + count + '" name="pack_purchase[]" value="' + formatNumber(ppurchase) + '" required>'
            + '</div>'
            + '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mg-b10">'
            + '<label>Sell Price</label>'
            + '<input type="number" min="0" val="' + count + '" class="input_multi pack_price" id="pack_price_' + count + '" name="pack_price[]" value="' + formatNumber(pprice) + '" required>'
            + '</div>';

        var line2 = '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mg-b10">'
            + '<label>Season Price</label>'
            + '<input type="number" min="0" class="input_multi" id="pack_season_' + count + '" name="pack_season[]" value="' + formatNumber(pseason) + '">'
            + '</div>'
            + '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mg-b10">'
            + '<label>Special Price</label>'
            + '<input type="number" min="0" class="input_multi" id="pack_special_' + count + '" name="pack_special[]" value="' + formatNumber(pspecial) + '">'
            + '</div>'
            + '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mg-b10">'
            + '<label>Discount</label>'
            + '<input type="number" min="0" class="input_multi" id="pack_disc_' + count + '" name="pack_disc[]" value="' + formatNumber(pdisc) + '">'
            + '</div>';
    } else {
        var line1 = '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mg-b10">'
            + '<label>Purchase Price</label>'
            + '<input type="number" min="0" class="input_multi" id="pack_purchase_' + count + '" name="pack_purchase[]" value="' + formatNumber(ppurchase) + '" required>'
            + '</div>'
            + '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mg-b10">'
            + '<label>Season Price</label>'
            + '<input type="number" min="0" class="input_multi" id="pack_season_' + count + '" name="pack_season[]" value="' + formatNumber(pseason) + '">'
            + '</div>';

        var line2 = '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mg-b10">'
            + '<label>Special Price</label>'
            + '<input type="number" min="0" class="input_multi" id="pack_special_' + count + '" name="pack_special[]" value="' + formatNumber(pspecial) + '">'
            + '</div>'
            + '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mg-b10">'
            + '<label>Discount</label>'
            + '<input type="number" min="0" class="input_multi" id="pack_disc_' + count + '" name="pack_disc[]" value="' + formatNumber(pdisc) + '">'
            + '</div>';
    }

    var no = $('.rows_packages').length + 1;
    $('#table_packages').append(
        '<div class="row mg-b20 pack_' + count + '">'
        + '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'
        + '<div class="layout-row layout-center">'
        + '<label>#' + no + '</label>'
        + '<span class="flex"></span>'
        + '<a href="javascript:void(0)" class="btn_action" onclick="remove_item(\'.pack,' + count + '\')"><i class="fa fa-remove fa-fw"></i></a>'
        + '</div>'
        + '<label>Package Name</label>'
        + '<input type="text" class="input_multi mg-b5" id="pack_name_' + count + '" name="pack_name[]" value="' + pname + '" placeholder="Name" required>'
        //+ '<div class="layout-row">'
        //+ '<input type="text" class="input_multi mg-b5 mg-r5" id="pack_name_'+ count +'" name="pack_name[]" value="'+pname+'" placeholder="Name" required>'
        //+ '<input type="text" class="input_multi mg-b5 mg-l5" id="pack_cat_'+ count +'" name="pack_cat[]" value="'+pcat+'" placeholder="Category">'
        //+ '</div>'
        + '</div>'
        + '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'
        + '<label>Description</label>'
        + '<textarea name="pack_desc[]" id="pack_desc' + count + '" class="input_multi mg-t5" rows="5">' + pdesc + '</textarea>'
        + '</div>'
        + line1
        + line2
        + '<input type="hidden" id="rows_packages_' + count + '" class="rows_packages" name="rows_packages[]" value="' + count + '">'
        + '</div>'
    );
}

function edit_dpost_packages() {
    var xjson = JSON.parse($('#vpackages').html());

    for (i = 0; i < xjson.length; i++) {
        dpost_packages(xjson[i].pack_name, xjson[i].pack_category, xjson[i].pack_desc, xjson[i].pack_purchase, xjson[i].pack_price, xjson[i].pack_season, xjson[i].pack_special, xjson[i].pack_disc);
    }
}

/* Extra */

function dpost_extra(vparent, vchild) {
    if (vparent == undefined) {
        vparent = '';
    }
    if (vchild == undefined) {
        vchild = '';
    }

    var tbl = $('table_extra .row');
    var lastRow = tbl.length;
    var count = lastRow;

    // Check Already Count
    if ($('#rows_extra_' + count).val() == count) {
        $('.rows_extra').each(function (i) {
            if ($('#rows_extra_' + count).val() == count) {
                count = count + 1;
            }
        });
    }

    var xextra = '';
    if ($('#xextra').html() != '') {
        xd = JSON.parse($('#xextra').html());
        xd.map(function (val) {
            var unit = (val.extra_unit != '') ? ' (' + val.extra_unit + ')' : '';
            if (vparent == val.extra_id) {
                xextra += '<option value="' + val.extra_id + '" selected>' + val.text_title + unit + '</option>';
            } else {
                xextra += '<option value="' + val.extra_id + '">' + val.text_title + unit + '</option>';
            }
        })
    }

    $('#table_extra').append(
        '<div class="row det_' + count + '">'
        + '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 layout-row">'
        + '<div class="wd-40 mg-r5">'
        + '<select name="xextra[]" id="xextra_' + count + '" class="cinput select_multi chosen-select-deselect" onchange="actchain(\'product/extra/autonom/' + count + '\', \'xextra_' + count + '\', \'vextra_' + count + '\')">'
        + '<option value=""></option>' + xextra
        + '</select>'
        + '</div>'
        + '<div class="wd-60 vextra_' + count + '">'
        + '<select name="vextra[][]" id="vextra_' + count + '" class="cinput select_multi chosen-select-deselect">'
        + '<option value=""></option>'
        + '</select>'
        + '</div>'
        + '<span class="flex"></span>'
        + '<a href="javascript:void(0)" class="btn_action" onclick="remove_item(\'.det,' + count + '\')"><i class="fa fa-remove fa-fw"></i></a>'
        + '</div>'
        + '<input type="hidden" id="rows_extra_' + count + '" class="rows_extra" name="rows_extra[]" value="' + count + '">'
        + '</div>'
    );

    if (vchild != '') {
        actchain('product/extra/autonom/' + count, 'xextra_' + count, 'vextra_' + count, vchild);
    }

    $('.chosen-select-deselect').chosen({allow_single_deselect: true});
    $('.chosen-container').css({width: '100%'});
}

function edit_dpost_extra() {
    var xjson = JSON.parse($('#vextra').html());

    if (xjson.p != undefined) {
        for (i = 0; i < xjson.p.length; i++) {
            var p = (xjson.p != null) ? xjson.p[i] : true;
            var c = (xjson.c != null) ? xjson.c[i] : true;
            dpost_extra(p, c);
        }
    }
}

/* Details */

function dpost_details(vparent, vchild) {
    if (vparent == undefined) {
        vparent = '';
    }
    if (vchild == undefined) {
        vchild = '';
    }

    var tbl = $('table_details .row');
    var lastRow = tbl.length;
    var count = lastRow;

    // Check Already Count
    if ($('#rows_detail_' + count).val() == count) {
        $('.rows_detail').each(function (i) {
            if ($('#rows_detail_' + count).val() == count) {
                count = count + 1;
            }
        });
    }

    var xdetail = '';
    if ($('#xdetails').html() != '') {
        xd = JSON.parse($('#xdetails').html());
        xd.map(function (val) {
            var unit = (val.detail_unit != '') ? ' (' + val.detail_unit + ')' : '';
            if (vparent == val.detail_id) {
                xdetail += '<option value="' + val.detail_id + '" selected>' + val.text_title + unit + '</option>';
            } else {
                xdetail += '<option value="' + val.detail_id + '">' + val.text_title + unit + '</option>';
            }
        })
    }

    $('#table_details').append(
        '<div class="row det_' + count + '">'
        + '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 layout-row">'
        + '<div class="wd-40 mg-r5">'
        + '<select name="xdetail[]" id="xdetail_' + count + '" class="cinput select_multi chosen-select-deselect" onchange="actchain(\'additional/details/autonom/' + count + '\', \'xdetail_' + count + '\', \'vdetail_' + count + '\')">'
        + '<option value=""></option>' + xdetail
        + '</select>'
        + '</div>'
        + '<div class="wd-60 vdetail_' + count + '">'
        + '<select name="vdetail[][]" id="vdetail_' + count + '" class="cinput select_multi chosen-select-deselect">'
        + '<option value=""></option>'
        + '</select>'
        + '</div>'
        + '<span class="flex"></span>'
        + '<a href="javascript:void(0)" class="btn_action" onclick="remove_item(\'.det,' + count + '\')"><i class="fa fa-remove fa-fw"></i></a>'
        + '</div>'
        + '<input type="hidden" id="rows_detail_' + count + '" class="rows_detail" name="rows_detail[]" value="' + count + '">'
        + '</div>'
    );

    if (vchild != '') {
        actchain('additional/details/autonom/' + count, 'xdetail_' + count, 'vdetail_' + count, vchild);
    }

    $('.chosen-select-deselect').chosen({allow_single_deselect: true});
    $('.chosen-container').css({width: '100%'});
}

function edit_dpost_details() {
    var xjson = JSON.parse($('#vdetails').html());

    if (xjson.p != undefined) {
        for (i = 0; i < xjson.p.length; i++) {
            var p = (xjson.p != null) ? xjson.p[i] : true;
            var c = (xjson.c != null) ? xjson.c[i] : true;
            dpost_details(p, c);
        }
    }
}

/* Relation */

function dpost_relation(pid) {
    if (pid == undefined) {
        pid = '';
    }

    var tbl = $('table_relation .row');
    var lastRow = tbl.length;
    var count = lastRow;

    // Check Already Count
    if ($('#rows_relation_' + count).val() == count) {
        $('.rows_relation').each(function (i) {
            if ($('#rows_relation_' + count).val() == count) {
                count = count + 1;
            }
        });
    }

    $('#table_relation').append(
        '<div class="row mg-b10 rel_' + count + '">'
        + '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 layout-row">'
        + '<div class="pos-rel wd-100">'
        + '<input type="text" class="input_multi" id="product_name_' + count + '" name="product_name[]" value="' + pid + '" autocomplete="off"'
        + 'onkeyup="autocommulti(\'product/autoproduct/product_name/' + count + '\')" placeholder="Search product in here..." required>'
        + '<input type="hidden" name="product_id[]" id="product_id_' + count + '">'
        + '<div id="boxresult" class="showhide_' + count + '"><div class="result_' + count + '"></div></div>'
        + '</div>'
        + '<span class="flex"></span>'
        + '<a href="javascript:void(0)" class="btn_action" onclick="remove_item(\'.rel,' + count + '\')"><i class="fa fa-remove fa-fw"></i></a>'
        + '</div>'
        + '<input type="hidden" id="rows_relation_' + count + '" class="rows_relation" name="rows_relation[]" value="' + count + '">'
        + '</div>'
    );
}

function edit_dpost_relation() {
    var xjson = JSON.parse($('#relation').html());

    for (i = 0; i < xjson.length; i++) {
        dpost_relation(xjson[i]);
    }
}

/* Merchant */

function dpost_merchant(vpic, vmargin, vcontract, vdesc, vbrand) {
    if (vpic == undefined) {
        vpic = '';
    }
    if (vmargin == undefined) {
        vmargin = '';
    }
    if (vcontract == undefined) {
        vcontract = '';
    }
    if (vdesc == undefined) {
        vdesc = '';
    }
    if (vbrand == undefined) {
        vbrand = '';
    }

    var tbl = $('table_merchant .row');
    var lastRow = tbl.length;
    var count = lastRow;

    // Check Already Count
    if ($('#rows_merchant_' + count).val() == count) {
        $('.rows_merchant').each(function (i) {
            if ($('#rows_merchant_' + count).val() == count) {
                count = count + 1;
            }
        });
    }

    var xbrand = '';
    if ($('#xbrand').html() != '') {
        xd = JSON.parse($('#xbrand').html());
        xd.map(function (val) {
            if (vbrand == val.brand_id) {
                xbrand += '<option value="' + val.brand_id + '" selected>' + val.brand_name + '</option>';
            } else {
                xbrand += '<option value="' + val.brand_id + '">' + val.brand_name + '</option>';
            }
        })
    }

    $('#table_merchant').append(
        '<div class="var_' + count + '">'
        + '<div class="row">'
        + '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 layout-row layout-center mg-b10 rm-pad">'
        + '<a href="javascript:void(0)" class="btn_action" onclick="remove_item(\'.var,' + count + '\')"><i class="fa fa-remove fa-fw"></i></a>'
        + '<span class="flex"></span>'
        + '<select name="brand_id[]" id="brand_id_' + count + '" class="cinput select_multi chosen-select-deselect" data-placeholder="Brand">'
        + '<option value=""></option>' + xbrand
        + '</select>'
        + '</div>'
        + '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mg-b10">'
        + '<input type="text" name="user_picm[]" id="user_picm_' + count + '" value="' + vpic + '" class="cinput input_multi" placeholder="PIC Merchant">'
        + '</div>'
        + '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mg-b10">'
        + '<input type="text" name="user_margin[]" id="user_margin_' + count + '" value="' + vmargin + '" class="cinput input_multi" placeholder="Margin (%)">'
        + '</div>'
        + '</div>'
        + '<div class="row">'
        + '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mg-b10">'
        + '<input type="text" name="user_contract[]" id="user_contract_' + count + '" value="' + vcontract + '" class="cinput input_multi" placeholder="Contract No">'
        + '</div>'
        + '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pad-b20">'
        + '<input type="text" name="user_desc[]" id="user_desc_' + count + '" value="' + vdesc + '" class="cinput input_multi" placeholder="Description">'
        + '</div>'
        + '<input type="hidden" id="rows_merchant_' + count + '" class="rows_merchant" name="rows_merchant[]" value="' + count + '">'
        + '</div>'
        + '</div>'
    );

    $('.chosen-select-deselect').chosen({allow_single_deselect: true});
    $('.chosen-container').css({width: '100%'});
}

function edit_dpost_merchant() {
    var xjson = JSON.parse($('#xmerchant').html());

    for (i = 0; i < xjson.length; i++) {
        dpost_merchant(xjson[i].user_picm, xjson[i].user_margin, xjson[i].user_contract, xjson[i].user_desc, xjson[i].brand_id);
    }
}

/* Textcode */

function xtextcode(txtitle, txvalue, txcode) {
    if (txtitle == undefined) {
        txtitle = '';
    }
    if (txvalue == undefined) {
        txvalue = '';
    }
    if (txcode == undefined) {
        txcode = '';
    }

    var tbl = $('#table_textcode .row');
    var lastRow = tbl.length;
    var count = lastRow;

    // Check Already Count
    if ($('#rows_text_' + count).val() == count) {
        $('.rows_text').each(function (i) {
            if ($('#rows_text_' + count).val() == count) {
                count = count + 1;
            }
        });
    }

    $('#table_textcode').append(
        "<div class='records_" + count + " mg-t10'>"
        + "<label>CODE : %" + txcode + "%</label>"
        + "<div class='row'>"
        + "<div class='col-lg-4 col-md-4 col-sm-4 col-xs-12 mg-b5 layout-row'>"
        + '<a href="javascript:void(0)" class="btn_action" onclick="remove_item(\'.records_,' + count + '\')"><i class="fa fa-remove fa-fw"></i></a>'
        + '<span class="flex"></span>'
        + '<input type="text" class="input_multi" id="text_title_' + count + '" name="text_title[]" value="' + txtitle + '" placeholder="Title">'
        + "</div>"
        + "<div class='col-lg-8 col-md-8 col-sm-8 col-xs-12 mg-b5'>"
        + '<input type="text" class="input_multi" id="text_value_' + count + '" name="text_value[]" value="' + txvalue + '" placeholder="Value">'
        + "</div>"

        + '<input type="hidden" id="rows_text_' + count + '" class="rows_text" name="rows_text[]" value="' + count + '">'
        + "<div class='clean'></div>"
        + "</div>"
        + "</div>"
    );
}

function edit_xtextcode() {
    var xjson = JSON.parse($('#xtext').html());

    xjson.forEach(function (obj) {
        var text_seo = obj.text_code;
        xtextcode(obj.text_title, obj[text_seo], obj.text_code);
    });
}

function xtextcode_lang(txlang, txtitle, txvalue, txcode) {
    if (txlang == undefined) {
        txlang = '';
    }
    if (txtitle == undefined) {
        txtitle = '';
    }
    if (txvalue == undefined) {
        txvalue = '';
    }
    if (txcode == undefined) {
        txcode = '';
    }

    var tbl = $('#table_textcode_' + txlang + ' .row');
    var lastRow = tbl.length;
    var count = lastRow;

    // Check Already Count
    if ($('#rows_text_' + txlang + '_' + count).val() == count) {
        $('.rows_text').each(function (i) {
            if ($('#rows_text_' + txlang + '_' + count).val() == count) {
                count = count + 1;
            }
        });
    }

    $('#table_textcode_' + txlang).append(
        "<div class='records_" + txlang + "_" + count + " mg-t10'>"
        + "<label>CODE : %" + txcode + "%</label>"
        + "<div class='row'>"
        + "<div class='col-lg-4 col-md-4 col-sm-4 col-xs-12 mg-b5 layout-row'>"
        + '<a href="javascript:void(0)" class="btn_action" onclick="remove_item(\'.records_' + txlang + ',' + count + '\')"><i class="fa fa-remove fa-fw"></i></a>'
        + '<span class="flex"></span>'
        + '<input type="text" class="input_multi" id="text_title_' + count + '" name="text_title[' + txlang + '][]" value="' + txtitle + '" placeholder="Title">'
        + "</div>"
        + "<div class='col-lg-8 col-md-8 col-sm-8 col-xs-12 mg-b5'>"
        + '<input type="text" class="input_multi" id="text_value_' + count + '" name="text_value[' + txlang + '][]" value="' + txvalue + '" placeholder="Value">'
        + "</div>"

        + '<input type="hidden" id="rows_text_' + txlang + '_' + count + '" class="rows_text" name="rows_text[' + txlang + '][]" value="' + count + '">'
        + "<div class='clean'></div>"
        + "</div>"
        + "</div>"
    );
}

function edit_xtextcode_lang() {
    var xjson = JSON.parse($('#xtext').html());

    xjson.forEach(function (obj) {
        var text_seo = obj.text_code;
        xtextcode_lang(obj.lang_id, obj.text_title, obj[text_seo], obj.text_code);
    });
}

/* Text Notif */

function xtextnotif(txtitle, txvalue, txcode) {
    if (txtitle == undefined) {
        txtitle = '';
    }
    if (txvalue == undefined) {
        txvalue = '';
    }
    if (txcode == undefined) {
        txcode = '';
    }

    var tbl = $('#table_textnotif .row');
    var lastRow = tbl.length;
    var count = lastRow;

    // Check Already Count
    if ($('#rows_notif_' + count).val() == count) {
        $('.rows_notif').each(function (i) {
            if ($('#rows_notif_' + count).val() == count) {
                count = count + 1;
            }
        });
    }

    $('#table_textnotif').append(
        "<div class='records_" + count + " mg-t10'>"
        + "<label>CODE : %" + txcode + "%</label>"
        + "<div class='row'>"
        + "<div class='col-lg-4 col-md-4 col-sm-4 col-xs-12 mg-b5 layout-row'>"
        + '<a href="javascript:void(0)" class="btn_action" onclick="remove_item(\'.records_,' + count + '\')"><i class="fa fa-remove fa-fw"></i></a>'
        + '<span class="flex"></span>'
        + '<input type="text" class="input_multi" id="notif_title_' + count + '" name="notif_title[]" value="' + txtitle + '" placeholder="Title">'
        + "</div>"
        + "<div class='col-lg-8 col-md-8 col-sm-8 col-xs-12 mg-b5'>"
        + '<input type="text" class="input_multi" id="notif_value_' + count + '" name="notif_value[]" value="' + txvalue + '" placeholder="Value">'
        + "</div>"

        + '<input type="hidden" id="rows_notif_' + count + '" class="rows_notif" name="rows_notif[]" value="' + count + '">'
        + "<div class='clean'></div>"
        + "</div>"
        + "</div>"
    );
}

function edit_xtextnotif() {
    var xjson = JSON.parse($('#xnotif').html());

    xjson.forEach(function (obj) {
        var notif_seo = obj.notif_code;
        xnotifcode(obj.notif_title, obj[notif_seo], obj.notif_code);
    });
}

function xtextnotif_lang(txlang, txtitle, txvalue, txcode) {
    if (txlang == undefined) {
        txlang = '';
    }
    if (txtitle == undefined) {
        txtitle = '';
    }
    if (txvalue == undefined) {
        txvalue = '';
    }
    if (txcode == undefined) {
        txcode = '';
    }

    var tbl = $('#table_textnotif_' + txlang + ' .row');
    var lastRow = tbl.length;
    var count = lastRow;

    // Check Already Count
    if ($('#rows_notif_' + txlang + '_' + count).val() == count) {
        $('.rows_notif').each(function (i) {
            if ($('#rows_notif_' + txlang + '_' + count).val() == count) {
                count = count + 1;
            }
        });
    }

    $('#table_textnotif_' + txlang).append(
        "<div class='records_" + txlang + "_" + count + " mg-t10'>"
        + "<label>CODE : %" + txcode + "%</label>"
        + "<div class='row'>"
        + "<div class='col-lg-4 col-md-4 col-sm-4 col-xs-12 mg-b5 layout-row'>"
        + '<a href="javascript:void(0)" class="btn_action" onclick="remove_item(\'.records_' + txlang + ',' + count + '\')"><i class="fa fa-remove fa-fw"></i></a>'
        + '<span class="flex"></span>'
        + '<input type="text" class="input_multi" id="notif_title_' + count + '" name="notif_title[' + txlang + '][]" value="' + txtitle + '" placeholder="Title">'
        + "</div>"
        + "<div class='col-lg-8 col-md-8 col-sm-8 col-xs-12 mg-b5'>"
        + '<input type="text" class="input_multi" id="notif_value_' + count + '" name="notif_value[' + txlang + '][]" value="' + txvalue + '" placeholder="Value">'
        + "</div>"

        + '<input type="hidden" id="rows_notif_' + txlang + '_' + count + '" class="rows_notif" name="rows_notif[' + txlang + '][]" value="' + count + '">'
        + "<div class='clean'></div>"
        + "</div>"
        + "</div>"
    );
}

function edit_xtextnotif_lang() {
    var xjson = JSON.parse($('#xnotif').html());

    xjson.forEach(function (obj) {
        var notif_seo = obj.notif_code;
        xtextnotif_lang(obj.lang_id, obj.notif_title, obj[notif_seo], obj.notif_code);
    });
}

/* Post All */

function post_all(post_id, post_name) {
    if (post_id == undefined) {
        post_id = '';
    }
    if (post_name == undefined) {
        post_name = '';
    }

    var tbl = document.getElementById('table_post');
    var lastRow = tbl.rows.length;
    var count = lastRow;

    // Check Already Count
    if ($('#rows_post_' + count).val() == count) {
        $('.rows_post').each(function (i) {
            if ($('#rows_post_' + count).val() == count) {
                count = count + 1;
            }
        });
    }

    $('#table_post').append(
        '<tr class="records_' + count + '">'
        + '<td>'
        + '<input type="text" class="input_multi" id="post_name_' + count + '" name="post_name[]" value="' + post_name + '"'
        + 'onkeyup="autocommulti(\'post/autopost/post_name/' + count + '\')" placeholder="Type in search..." required>'
        + '<div id="boxresult" class="showhide_' + count + '"><div class="result_' + count + '"></div></div>'
        + '</td>'
        + '<td class="center">'
        + '<a href="javascript:void(0)" onclick="remove_item(\'.records,' + count + '\')">Delete</a>'
        + '<input type="hidden" class="post_id" id="post_id_' + count + '" name="post_id[]" value="' + post_id + '">'
        + '<input type="hidden" id="rows_post_' + count + '" class="rows_post" name="rows_post[]" value="' + count + '">'
        + '</td>'
        + '</tr>'
    );
}

function edit_post_all() {
    var xjson = JSON.parse($('#promo_post').val());

    for (i = 0; i < xjson.length; i++) {
        post_all(xjson[i].post_id,
            xjson[i].post_name);
    }
}

function capitalize(input) {
    return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
}

// Set Upload for Select and Drag
if (window.File && window.FileList && window.FileReader) {
    setTimeout(function () {
        init_upload()
    }, 500);
}

function init_upload() {
    if (document.getElementById("zupload") != undefined) {
        var fileselect = document.getElementById("zupload"),
            filedrag = document.getElementById("zfiles");

        // File Select
        fileselect.addEventListener("change", FileSelectHandler, false);

        // is XHR2 available?
        var xhr = new XMLHttpRequest();
        if (xhr.upload) {
            // File Drop
            filedrag.addEventListener("dragover", FileDragHover, false);
            filedrag.addEventListener("dragleave", FileDragHover, false);
            filedrag.addEventListener("drop", FileSelectHandler, false);
        }
    }
}

// File Drag Hover
function FileDragHover(e) {
    e.stopPropagation();
    e.preventDefault();
    if (e.type == "dragover") {
        $('.zfiles').addClass('active');
    } else {
        $('.zfiles').removeClass('active');
    }
}

// File Selection
function FileSelectHandler(e) {
    // Cancel event and hover styling
    FileDragHover(e);

    // Fetch FileList object
    if (e.type == "drop") {
        readPic(e.dataTransfer);
    } else {
        readPic(e.target);
    }
}

var FileStore = [];
function readPic(input) {
    if (input.files || input.length > 0) {
        for (i = 0; i < input.files.length; i++) {
            var reader = new FileReader();

            reader.onload = function (e) {
                var tbl = $('.zbox-images .zbox-pic');
                var count = tbl.length;

                // Check Already Count
                if ($('#rows_img_' + count).val() == count) {
                    $('.rows_img').each(function (i) {
                        if ($('#rows_img_' + count).val() == count) {
                            count = count + 1;
                        }
                    });
                }

                $('.zbox-images').append("<label class='col-lg-3 col-md-4 col-sm-4 col-xs-4 pad-l pad-r zbox-pic img_pic_" + count + "' for='" + count + "'>"
                    + "<div class='mg-l5 mg-r5'>"
                    + "<div class='zbox pos-rel mg-b10'>"
                    + "<div class='pad-all-10'>"
                    + "<span class='img' style='background-image: url(" + e.target.result + ")'></span>"
                    + "</div>"
                    + "<a href='javascript:void(0)' class='pos-abs delete' onclick='remove_pic(\".img_pic," + count + "\")'><i class='fa fa-trash fa-fw'></i></a>"
                    + "<a href='javascript:void(0)' class='zbox default' onclick='default_pic(\".img_pic," + count + "\")'>Set as Default</a>"
                    + "<input type='hidden' id='rows_img_" + count + "' class='rows_img' name='rows_img[]' value='" + count + "'>"
                    + "</div>"
                    + "</div>"
                    + "</label>")

                FileStore.push({'id': count, 'data': e.target.result});
            };

            reader.readAsDataURL(input.files[i]);
        }

        $('#zupload').wrap('<form>').closest('form').get(0).reset();
        $('#zupload').unwrap();
    }
}

function default_pic(val) {
    val = val.split(",");
    $('.zbox-pic').each(function (i) {
        var set = $(this).attr('for');

        if (set == val[1]) {
            $(val[0] + "_" + set + ' .default').attr('id', 'active');
            $('#is_default').val(i);
        } else {
            $(val[0] + "_" + set + ' .default').removeAttr('id');
        }
    })
}

function remove_pic(val) {
    val = val.split(",");

    $(val[0] + "_" + val[1]).fadeOut();
    $(val[0] + "_" + val[1]).remove();

    var FStore = [];
    FileStore.map(function (v) {
        if (v.id != val[1]) {
            FStore.push(v);
        }
    })
    FileStore = FStore;
}

//function xforeach()
//{
//    var json = [{
//                    "id" : "1", 
//                    "msg"   : "hi",
//                    "tid" : "2013-05-05 23:35",
//                    "fromWho": "hello1@email.se"
//                },
//                {
//                    "id" : "2", 
//                    "msg"   : "there",
//                    "tid" : "2013-05-05 23:45",
//                    "fromWho": "hello2@email.se"
//                }];
//    
//    // Sample 1
//    for(var i = 0; i < json.length; i++) {
//        var obj = json[i];
//    
//        console.log(obj);
//    }
//    
//    // Sample 2
//    for(var k in json) {
//        console.log(json[k]);
//    }
//    
//    // Sample 3
//    json.forEach(function(obj) { console.log(obj.id); });
//    
//    var xjson = JSON.parse($('#xjson').val());
//    var val = '';
//    for (i=0;i<xjson.length;i++)
//    {
//        if (i > 0) {
//            val = val + '<option value="'+ xjson[i].post_id +'">'+ xjson[i].post_name +'</option>';
//        } else {
//            val = '<option value="'+ xjson[i].post_id +'">'+ xjson[i].post_name +'</option>';
//        }
//    }
//}