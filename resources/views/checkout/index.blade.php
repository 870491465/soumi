<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="http://yanshi.bj8dream.com/static/xiaoniren/css/common.css" rel="external nofollow" />
    <base target="_self" />
    <title>嗖咪在线充值</title>
    <script type="text/javascript" src="http://yanshi.bj8dream.com/static/xiaoniren/js/jQuery_v172_min.js"></script>
    <style type="text/css">
        /* Bank Select */
        .ui-list-icons li { float:left; margin:0px 10px 25px 0px; width:218px; padding-right:10px; display:inline; }
        .ui-list-icons li input { vertical-align:middle; }
        .ui-list-icons li .icon-box { cursor:pointer; width:190px; background:#FFF; line-height:36px; border:1px solid #DDD; vertical-align:middle; position:relative; display:inline-block; zoom:1; }
        .ui-list-icons li .icon-box.hover, .ui-list-icons li .icon-box.current { border:1px solid #FA3; }
        .ui-list-icons li .icon-box-sparkling { position:absolute; top:-18px; left:0px; height:14px; line-height:14px; }
        .ui-list-icons li .icon { float:left; width:126px; padding:0px; height:36px; display:block; line-height:30px; color:#07f; font-weight:bold; white-space:nowrap; overflow:hidden; position:relative; z-index:1; }
        .ui-list-icons li .bank-name { position:absolute; left:5px; z-index:0; height:36px; width:121px; overflow:hidden; }
        /* Bank Background */
        .ui-list-icons li .ABC, .ui-list-icons li .ICBC, .ui-list-icons li .CCB, .ui-list-icons li .PSBC,
        .ui-list-icons li .BOC, .ui-list-icons li .CMB, .ui-list-icons li .COMM, .ui-list-icons li .SPDB,
        .ui-list-icons li .CEB { background:#FFF url(images/ICBC_bank.gif) no-repeat 5px center; }
        /* Bank Submit */
        .paybok { padding:0px 0px 0px 20px; }
        .paybok .csbtx { border-radius:3px; color:#FFF; font-weight:bold; }
    </style>
    <script type="text/javascript">
        $(function(){
//Bank Hover
            $('.ui-list-icons > li').hover(function(){
                $(this).children('.icon-box').addClass('hover');
            }, function(){
                $(this).children('.icon-box').removeClass('hover');
            });

//Bank Click
            $('.ui-list-icons > li').click(function(){
                for ( var i=0; i<$('.ui-list-icons > li').length; i++ ){
                    $('.ui-list-icons > li').eq(i).children('.icon-box').removeClass('current');
                }
                $(this).children('.icon-box').addClass('current');
            });
        })
    </script>
</head>
<body>
<div class="paying">
    <form action="/huayi_test/order/charge.php" method="post" class="validator" name="f" onsubmit="return chongzhi();" >
        <div class="payamont">
            <input type="text" id="money" name="money"  value="{!! $amount !!}" disabled />
            <span>元</span>
        </div>
        <div class="clr"></div>
        <ul class="ui-list-icons clrfix">
            <li>
                <input type="radio" name="bank" id="ABC" value="" checked="checked">
                <label class="icon-box current" for="ABC">
                    <span class="icon-box-sparkling" bbd="false"> </span>
                    <span class="false icon ABC" title="中国农业银行"></span>
                    <span class="bank-name">中国农业银行</span>
                </label>
            </li>
            <li>
                <input type="radio" name="bank" id="ICBC" value="">
                <label class="icon-box" for="ICBC">
                    <span class="icon-box-sparkling" bbd="false"> </span>
                    <span class="false icon ICBC" title="中国工商银行"></span>
                    <span class="bank-name">中国工商银行</span>
                </label>
            </li>
            <li>
                <input type="radio" name="bank" id="CCB" value="">
                <label class="icon-box" for="CCB">
                    <span class="icon-box-sparkling" bbd="false"> </span>
                    <span class="false icon CCB" title="中国建设银行"></span>
                    <span class="bank-name">中国建设银行</span>
                </label>
            </li>
            <li>
                <input type="radio" name="bank" id="CCB" value="">
                <label class="icon-box" for="CCB">
                    <span class="icon-box-sparkling" bbd="false"> </span>
                    <span class="false icon CCB" title="中国建设银行"></span>
                    <span class="bank-name">中国建设银行</span>
                </label>
            </li>
            <li>
                <input type="radio" name="bank" id="PSBC" value="">
                <label class="icon-box" for="PSBC">
                    <span class="icon-box-sparkling" bbd="false"> </span>
                    <span class="false icon PSBC" title="中国邮政储蓄银行"></span>
                    <span class="bank-name">中国邮政储蓄银行</span>
                </label>
            </li>
            <li>
                <input type="radio" name="bank" id="BOC" value="">
                <label class="icon-box" for="BOC">
                    <span class="icon-box-sparkling" bbd="false"> </span>
                    <span class="false icon BOC" title="中国银行"></span>
                    <span class="bank-name">中国银行</span>
                </label>
            </li>
            <li>
                <input type="radio" name="bank" id="CMB" value="">
                <label class="icon-box" for="CMB">
                    <span class="icon-box-sparkling" bbd="false"> </span>
                    <span class="false icon CMB" title="招商银行"></span>
                    <span class="bank-name">招商银行</span>
                </label>
            </li>
            <li>
                <input type="radio" name="bank" id="COMM" value="">
                <label class="icon-box" for="COMM">
                    <span class="icon-box-sparkling" bbd="false"> </span>
                    <span class="false icon COMM" title="交通银行"></span>
                    <span class="bank-name">交通银行</span>
                </label>
            </li>
            <li>
                <input type="radio" name="bank" id="SPDB" value="">
                <label class="icon-box" for="SPDB">
                    <span class="icon-box-sparkling" bbd="false"> </span>
                    <span class="false icon SPDB" title="浦发银行"></span>
                    <span class="bank-name">浦发银行</span>
                </label>
            </li>
            <li>
                <input type="radio" name="bank" id="CEB" value="">
                <label class="icon-box" for="CEB">
                    <span class="icon-box-sparkling" bbd="false"> </span>
                    <span class="false icon CEB" title="中国光大银行"></span>
                    <span class="bank-name">中国光大银行</span>
                </label>
            </li>
        </ul>
        <div class="paybok"><input class="csbtx" type="button" value="确认充值" onclick="this.form.submit();" /></div>
    </form>
</div>

</body>
</html>