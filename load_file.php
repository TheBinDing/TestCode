<?php

    $file = iconv('UTF-8', 'TIS-620', 'รายชื่อนักเตะ.pdf');

    $destination_path = pathinfo(getcwd(), 3).DIRECTORY_SEPARATOR.'File'.DIRECTORY_SEPARATOR.'News'.DIRECTORY_SEPARATOR;
    $target_path = $destination_path . basename($file);

    $target_name = '555'.$file; //ชื่อไฟล์ที่จะให้ดาวน์โหลด สามารถเปลี่ยนได้ตามใจชอบนะครับ

    if (file_exists($target_path)) { // ตรวจสอบก่อนว่าไฟล์มีอยู่จริงหรือเปล่า
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.urldecode($target_name)); //ตรงนี้ก็ใส่ชื่อไฟล์ตามข้างบนไป
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($target_path)); // อันนี้ก็ไม่มีอะไร แจ้งให้ระบบทราบว่าไฟล์ของเราขนาดเท่าไร
        ob_clean();
        flush();
        readfile($target_path); // และสั่งให้ดาวน์โหลดไฟล์ จบข่าว
    }
?>