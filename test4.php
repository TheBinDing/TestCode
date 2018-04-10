<?php
session_start();//เปิดใช้งานตัวแปรแบบ session
require("inc/connect2.php");
$setColumn=3;//แสดง4 คอลัมน์ต่อ1แถว ถ้าต้องการให้แสดงกี่คอลัมน์ให้กำหนดตรงนี้
$ColumnStart=1;//คอลัมน์เริ่มต้นเป็น 1 เสมอ
$rsShowProduct=mssql_query('SELECT * FROM product ORDER BY pd_id ASC');//ดึงข้อมูลล่าสุด10แถวจากเทเบิล
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
(function($){
    $.box = function(data){//แสดงไดอะล็อกตะกร้าสินค้า
        var config={
            action : '',
            ajaxurl : null,
            addClass    :   '',
            ajaxdata    :   {}
        };
        if(typeof data == 'object'){
            $.extend(config, data);
            $('body').data('box',config);
        }
        var divbox;
        var divbody;
        if($('#box').length==0){
            divbox = $('<div/>').attr('id','box').hide();
            var html = '';
            html += '<table cellpadding="0" cellspacing="0" align="center" class="cartbox">';
            html += '<tbody>';
            html += '<tr><td></td><td><div class="close">CLOSE</div></td><td></td></tr>';
            html += '<tr><td></td><td id="boxbody"></td><td></td></tr>';
            html += '<tr><td></td><td></td><td></td></tr>';
            html += '</tbody>';
            html += '</table>';
            divbox.html(html);
            divbox.appendTo(document.body);
            divbody = $('#boxbody');
        }else{
            divbox = $('#box');
            divbody = $('#boxbody');
        }
        divbox.addClass('position-absolute');
        if(config.addClass!=''){
            divbox.addClass(config.addClass);
        }
        if(config.ajaxurl!=null){
            divbody.html('');
            $.ajax({
                type: 'POST',
                url: config.ajaxurl,
                cache: false,
                data: config.ajaxdata,
                success: function(data) {
                    divbody.html(data);
                    $.boxPosition(divbox);
                }
            });
        }else if(config.html!=null){
            divbody.html(config.html);
        }else if(config.selector!=null){
            $(divbody).empty();
            $(config.selector).clone().appendTo(divbody);
        }else if(typeof this == 'object' && $(this).length > 0 ){
            var w = $(this).outerWidth(true);
            divbody.empty();
            divbody.width(w);
            divbody.html($(this).html());
        }
        $.boxPosition(divbox);
        var divback = null;
        if($('#boxback').length==0){
            divback = $('<div/>').attr('id','boxback').hide().insertBefore(divbox);
        }else{
            divback = $('#boxback');
        }
        $(divback).width($(window).width());
        $(window).resize(function(){
            $(divback).width($(window).width());
        });
        if($(document).height()>$(window).height()){
            $(divback).height($(document).height());
        }else{
            $(divback).height($(window).height());
            $(window).resize(function(){
                $(divback).height($(window).height());
            });
        }
        $(divback).css('background-color','#000').css('opacity',0.3).css('filter', 'alpha(opacity='+(0.3*100)+')');
        if(config.action!=''){
            $.boxAction(config.action,divbox,divback,config);
            if(config.callback != null){
                config.callback();
            }
        }
        //Close box
        $('#box, #box .close, #boxback').bind('click.close',function(event){
            if(event.target == this){
                $.boxAction('hide',divbox,divback,config);
                $('#box, #box .close, #boxback').unbind('click.close');
            }
        });
    };
    $.boxAction = function(action,divbox,divback,config){
        if(action=='show'){
            $(divbox).fadeIn(300);
            $(divback).fadeIn(300);
            $(document).unbind('keydown.box');
            $(document).bind('keydown.box',function(event){
                if($(divbox).length==0){
                    $(document).unbind('keydown.box');
                }else{
                    if(event.keyCode == 27){
                        $(document).unbind('keydown.box');
                        $.boxAction('hide',divbox,divback,config);
                    }
                }
            });
        } else if (action == 'hide'){
            if(config.action == 'showhide'){
                $(divback).add(divbox).remove();
            }else{
                $(divbox).fadeOut(300,function(){
                    $(this).remove();
                });
                $(divback).fadeOut(300,function(){
                    $(this).remove();
                });
            }
        } else if (action=='showhide'){
            $(document).one('keydown.box',function(event){
                if(event.keyCode == 27){
                    $.boxAction('hide',divbox,divback,config);
                }
            });
            divbox.add(divback).fadeIn(500).delay(2000).fadeOut(500,function(){
                $(divbox).remove();
                $(divback).remove();
                $(document).unbind('keydown.box',function(event){
                    if(event.keycode == 27){
                        $.boxAction('hide',divbox,divback,config);
                    }
                });
            });
        }
    };
    $.boxPosition = function(divbox){//position of box dialog in center window
        var top;
        top = ($(window).height()-28)/4;
        top_css = parseInt($(document).scrollTop()+top);
        divbox.css('top',top_css+'px');
        divbox.css('left','0px');
    }
})(jQuery);
function add2cart(ele,pdid){// add to cart ajax
    $.ajax({
        url:"test5.php?cartid="+pdid,
        dataType: 'json',
        success: function(data) {
            img2cart($(ele).closest('.productItem').find('.productImg'),function(){
                $('.cart_num').html(data.num);
                $('.cart_quantity').html(data.quantity);
            });
        }
    });
}
function img2cart(img,success){// animate product image
    if(img==null || $(img).length == 0){
    }else{
        var $imgclone = $(img).clone();
        $imgclone.get(0).className='';
        var _h = $(img).height();
        var _w = $(img).width();
        var __h = $('.my-cart').height();
        var mycart_position=$('.my-cart').position().left;
        var __w = __h*_w/_h;
        $imgclone.css({position:'absolute',top:$(img).position().top,left:$(img).position().left,height: _h,width: _w});
        $imgclone.appendTo('body');
        var prop = {
            top: $(window).scrollTop()+40,
            left:mycart_position,
            opacity: 0.5,
            height: __h,
            width: __w
        };
        $imgclone.animate(prop,1000,function(){
            $imgclone.remove();
            if(typeof success == 'function'){
                success();
            }
        });
    }
}
function openMycart(){
    var html='';
    $.box({
        ajaxurl: 'mycart.php',
        action  : 'show'
    });
}
</script>
<title>Add To Cart  Jquery Ajax</title>
<style>
body{
    font-family:Tahoma, Geneva, sans-serif;
    font-size:14px; 
}
a{
    color:#333;
    text-decoration:none;
}
#boxback {
    left: 0;
    position: absolute;
    top: 0;
    z-index: 22221;
}
#box {
    width: 99%;
    z-index: 22222;
}
#box.position-absolute {
    position: absolute;
}
#box .close{
    color:#fff;
    float:right;
    background:url(img/del.gif) no-repeat right center;
    padding-right:16px;
    cursor:pointer;
}
</style>
</head>
<body>
<table width="950" border="0" align="center">
    <tr>
        <td width="84%">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <?php while($showProduct=mssql_fetch_array($rsShowProduct)){//วันลูปแสดงผลสินค้าทีละแถว?>
                    <td align="center" class="productItem">
                        <img border="1" src="img/<?=$showProduct['pd_img']?>" alt="<?=$showProduct['pd_name']?>" width="120" class="productImg" /> <?php echo '<br />'.$showProduct['pd_name']?><br/>
                        <!-- <a href="test5.php?cartid=<?=$showProduct['pd_id']?>"> -->
                        <a href="#" onclick="add2cart(this,<?=$showProduct['pd_id']?>); return false;">
                            <img src="img/addtocart.gif" width="24" height="24" border="0"  />
                        </a>
                    </td>
                    <?php
                    if($ColumnStart==$setColumn){//หากคอลัมน์เท่ากับจำนวนคอลัมน์ที่กำหนดไว้
                        echo '</tr><tr>';//สร้างแท็ก </tr> ปิด เพื่อจบแถว และสร้าง <tr>เพื่อสร้างแถวใหม่
                        $ColumnStart=0;//เซตเป็น 0 เพื่อเริ่มนับคอลัมน์ใหม่
                    }
                    $ColumnStart++;//เพิ่มคอลัมน์ทีละ1คอลัมน์
                    } ?>
                </tr>
            </table>
        </td>
        <!-- <td width="16%" valign="top">
            <div style="float:right;border:1px dashed #333;padding:10px;position:fixed;background:#FF9;z-index:123;" class="my-cart">
                <b>
                    <img src="img/addtocart.gif" width="24" height="24" /> สินค้าในตะกร้า
                </b><br/>
                <div style="margin-left:20px;">
                    <?php
                    if(count($_SESSION["cartNumber"])>0){
                        $TotalAmount=0;$TotalPrice=0;
                        foreach($_SESSION["cartNumber"] as $RowCount){
                            $quantity+=$_SESSION[$RowCount][1];#คำนวณหาจำนวนสินค้าทั้งหมด
                        }
                        $num=count($_SESSION['cartNumber']);
                    }else{
                        $num=0;
                        $quantity=0;
                    }
                    ?>
                    <a href="#" onclick="openMycart();return false;">
                        <span class="cart_num"><?=$num?></span> รายการ
                        <span class="cart_quantity"><?=$quantity?> </span> ชิ้น
                    </a>
                </div>
            </div>
        </td> -->
    </tr>
</table>
</body>
</html>