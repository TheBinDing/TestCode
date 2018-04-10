<?php
session_start();
require("inc/connect2.php");
?>
<script type="text/javascript">
function deleteProduct(ele){
  var CartEle=$(ele).parent().parent().attr('id');
  var CartId=$(ele).parent().parent().attr('id').split("-");
    $.ajax({
      url:"test5.php?cartdel="+CartId[1],
    dataType: 'json',
      success: function(data) {
      $('.cart_num').html(data.num);
      $('.cart_quantity').html(data.quantity);
      $('.cart_price').html(data.price);
      $('.productTable tr#'+CartEle+'').remove();
    }
  }); 
}
function updateProduct(ele){
  var Pd=$(ele).parent().parent().attr('id').split("-");
  var quantity=$(ele).val();
  $.ajax({
      url:"test5.php",
    type: 'POST',
    data: {product_id:Pd[0],updatecart:Pd[1], quantity:quantity},
    dataType: 'json',
      success: function(data) {
      $('.cart_num').html(data.num);
      $('.cart_quantity').html(data.quantity);
      $('.cart_price').html(data.price);
    }
  }); 
}
</script>
<table width="100%" class="productTable" border="0" cellpadding="5" cellspacing="0" style="border-bottom:#DADADA solid 2px;background:#9C0;">
  <tr bgcolor="#FFFF99">
    <td width="18%"><strong>รหัสสินค้า</strong></td>
    <td width="62%"><strong>ชื่อสินค้า</strong></td>
    <td width="7%" align="center"><strong>จำนวน</strong></td>
    <td width="5%" align="center"><strong>ราคา</strong></td>
    <td width="8%" align="center"><strong>ลบ</strong></td>
  </tr>
  <?
if(count($_SESSION["cartNumber"])>0){#จำนวนข้อมูลที่มีอยู่หากมากกว่า0
foreach($_SESSION["cartNumber"] as $RowCount){#วนลูปดึงข้อมูลสินค้าออกมาให้ครบตามจำนวนข้อมูลที่มีอยู่
$rs_showpd=mysql_fetch_array(mysql_query("SELECT* FROM product WHERE pd_id=".$_SESSION[$RowCount][0].""));
if($rs_showpd["pd_amount"]<1){#ตรวจสอบจำนวนสินค้า หากจำนวนสินค้าเท่ากับ0
echo "<script>";
echo "alert('ขออภัยสินค้า \"".$rs_showpd["name_pd"]."\" หมดแล้ว');window.location='test5.php?del=".$RowCount."';";
        echo "</script>";
exit();
}else if($_SESSION[$RowCount][1]>$rs_showpd["pd_amount"]){#จำนวนสินค้ามากกว่าจำนวนสินค้าในร้าน
echo "<script>";
echo "alert('จำนวนสินค้าของ \"".$rs_showpd["pd_name"]."\" มีมากกว่าจำนวนสินค้าในร้าน');";
        echo "</script>";
$_SESSION[$RowCount][1]=$rs_showpd["pd_amount"];#เซตจำนวนสินค้าใหม่ให้มีค่่าเท่ากับจำนวนสินค้าในร้าน
}
?>
  <tr id="<?=$rs_showpd["pd_id"]?>-<?=$RowCount?>">
    <td><?=$rs_showpd["pd_id"]#รหัสสินค้า?></td>
    <td height="23">
      <?=$rs_showpd["pd_name"]#ชื่อสินค้า?></td>
    <td align="center"><input style="text-align:center;" name="pd_amount" type="text" id="pd_amount" size="5" value="<?=$_SESSION[$RowCount][1]#จำนวนสินค้า?>" onkeyup="updateProduct(this);"/></td>
    <td align="center"><?=$TotalPriceAmount=$_SESSION[$RowCount][2]*$_SESSION[$RowCount][1]#ราคาสินค้า?></td>
    <td align="center"><a href="#" onclick="deleteProduct(this); return false;"><img src="../../images/icon/delete.png" width="16" height="16" border="0"/></a></td>
  </tr>
  <?
$TotalAmount+=$_SESSION[$RowCount][1];#คำนวณหาจำนวนสินค้าทั้งหมด
$TotalPrice+=$TotalPriceAmount;#คำนวณหาราคาสินค้าทั้งหมด
}
?>
  <tr style="border-bottom:#DADADA 1px solid;">
    <td align="right" style="border-bottom:#DADADA solid 1px;">&nbsp;</td>
    <td height="23" align="right" style="border-bottom:#DADADA solid 1px;"><strong> รวม</strong></td>
    <td align="center" style="border-bottom:#DADADA solid 1px;"><strong>
      <span class="cart_quantity"><?= $TotalAmount?></span>
    </strong></td>
    <td align="center" style="border-bottom:#DADADA solid 1px;"><strong>
      <span class="cart_price"><?= $TotalPrice?></span>
    </strong></td>
    <td align="center" style="border-bottom:#DADADA solid 1px;">&nbsp;</td>
  </tr>
  <? } else { ?>
  <tr>
    <td height="23" colspan="5" align="center"><strong>ไม่พบสินค้าในตระกร้า</strong></td>
  </tr>
  <? } ?>
</table>