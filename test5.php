<?php
session_start();//เปิดใช้งานตัวแปรแบบ session
require("inc/connect2.php");
function getjson_cart() {
    if(count($_SESSION["cartNumber"])>0){
        $TotalAmount=0;$TotalPrice=0;
        foreach($_SESSION["cartNumber"] as $RowCount){
        $TotalAmount+=$_SESSION[$RowCount][1];#คำนวณหาจำนวนสินค้าทั้งหมด
        $TotalPrice+=($_SESSION[$RowCount][2]*$_SESSION[$RowCount][1]);#คำนวณหาราคาสินค้าทั้งหมด
        }
        echo '{"num":"'.count($_SESSION["cartNumber"]).'","quantity":"'.$TotalAmount.'","price":"'.$TotalPrice.'"}';
    }else{
        echo '{"num":"0","quantity":"0","price":"0"}';
    }
}
if(isset($_GET["cartid"])){#Add to cart
    $cid=$_GET["cartid"];
    $_SESSION["cartcount"]++;
    $cartcount=$_SESSION["cartcount"];
    $CItemCount="cart$cartcount";
    $CartStatus="";#เอาไว้เก็บสถานะสินค้าว่าลูกค้าเลือกซ้ำหรือไม่
    $rs_showpd=mysql_query("SELECT * FROM  tb_product WHERE pd_id=".$cid."");
    $showpd=mysql_fetch_array($rs_showpd);
    if(count($_SESSION["cartNumber"])!=0 ){
        foreach($_SESSION["cartNumber"] as $RecCart){
            if($_SESSION[$RecCart][0]==$cid){#หากสินค้าซ้ำกับของเดิม(โดยตรวจสอบจาก ID ของสินค้า)
            $_SESSION[$RecCart][1]++;#เพิ่มจำนวนสินค้า
            $CartStatus="double";#เปลี่ยนสถานะ
        }
    }
}
if($CartStatus==""){#สถานะเป็นค่าว่าง แสดงว่าสินค้าไม่ซ้ำกับของเดิม
    $_SESSION[$CItemCount][0]=$cid;//รหัสสินค้า
    $_SESSION[$CItemCount][1]=1;//จำนวนเริ่มต้น
    $_SESSION[$CItemCount][2]=$showpd['pd_price'];//ราคา
    $_SESSION[$CItemCount][3]='';//ความต้องการเพิ่มเติม เซตให้เป็นค่าว่างก่อน เพราะเป็นค่าเริ่มต้น
    $_SESSION["cartNumber"][$cartcount]=$CItemCount;#ตำแหน่งของแต่ละเรคคอร์ดของสินค้า
}
getjson_cart();
mysql_free_result($rs_showpd);
mysql_close($conn);
}
if(isset($_GET["cartdel"])){
    $RecDel=$_GET["cartdel"];
    foreach($_SESSION["cartNumber"] as $RecCart){#วนไปจนกว่าจะเจอแถวของสินค้าที่เลือกลบ
        if($RecCart==$RecDel){
        $CNum =preg_replace("/[^0-9]/", '', $RecCart); // คัดเอาเฉพาะตัวเลข เช่น cart1 จะได้ ค่า 1 เป็นต้น
        unset($_SESSION['cartNumber'][$CNum]); // unset แถวที่เก็บสินค้าที่ต้องการลบ
        }
    unset($_SESSION[$RecDel]);#unset ข้อมูลสินค้าที่เก็บไว้ทั้งหมด
    }
    getjson_cart();
}
if(isset($_POST["updatecart"])){#ต้องการแก้ไขจำนวนสินค้า
    $pdid=$_POST["product_id"];#รหัสของสินค้าทั้งหมด(จัดเก็บไว้ในรูป Array)
    $cartRows =$_POST["updatecart"];#จำนวน Record ของแถวทั้งหมดของสินค้า(จัดเก็บไว้ในรูป Array)
    $pamount=$_POST["quantity"];#จำนวน Record ของสินค้า(จัดเก็บไว้ในรูป Array)
        if($pamount>0){#เอาเฉพาะจำนวนสินค้าที่มากกว่า0
        $rs_record=mysql_fetch_array(mysql_query("SELECT pd_amount,pd_amount FROM product WHERE pd_id=".$pdid.""));
            if($pamount>$rs_record[1]){#หากจำนวนที่ลูกค้าระบุมากกว่าจำนวนที่มีอยู่ในร้าน
            $_SESSION[$cartRows][1] = $rs_record[1];#เซตจำนวนสินค้าใหม่ให้มีค่าเืท่ากับจำนวนสินค้าในร้าน
            }else{#หากจำนวนสินค้าที่ลูกค้าระบุน้อยกว่าหรือเืท่ากับจำนวนสินค้าที่มีอยู่ในร้าน
            $_SESSION[$cartRows][1] = $pamount ; #เซตจำนวนสินค้าใหม่ให้มีค่าเท่ากับจำนวนที่ลูกค้าระบุ
            }
        }
    getjson_cart();
}
?>