<?php
    function sendMail($arr) {
        $mail = new PHPMailer();
        $mail->Body = $arr['detail'];
        $mail->CharSet = "utf-8";
        $mail->IsSMTP();// Set mailer to use SMTP
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        // $mail->Host = "192.168.1.78"; // SMTP server
        // $mail->Host = "mail.csloxinfo.com"; // SMTP server
        $mail->Host = "58.137.61.220"; // SMTP server
        // $mail->Host = "smtp.gmail.com"; // Gmail
        // $mail->Host = "smtp.live.com"; // hotmail.com
        $mail->Port = 25; // พอร์ท 25, 465 or 587=
        // $mail->Port = 25; // พอร์ท 25, 465 or 587
        // $mypath = 'img/excel.png';
        // $mypath_name = 'รูปตัวอย่าง';
        $mail->Username = "thanakrit.bh@thaipolycons.co.th"; // SMTP username
        $mail->Password = "tpolypassword"; // SMTP password
        //from
        $mail->SetFrom($arr['from'], $arr['name']);   
        $mail->IsHTML(true);
        //send mail
         if($arr['send'] == 1){
            $mail->AddAddress("apichat.si@thaipolycons.co.th", "apichat");
            // $mail->AddAddress("thanakrit.bh@thaipolycons.co.th", "apichat");
            // $mail->AddCC("thanakrit.bh@thaipolycons.co.th");
         }else{
            $mail->AddAddress($arr['send']);
         }
        
        //$mail->AddReplyTo("email@yourdomain.com", "yourname");
        $mail->Subject = $arr['subject'];  
        
        if(!$mail->send()){
            // $msg = $mail->ErrorInfo;
            $msg = 0;
        }else{
            $msg = 1;
        }
        return $msg;
        // return $arr['detail'].'-'.$arr['subject'].'-'.$arr['from'].'-'.$arr['send'];
    }
    
    function loadTest($arr) {<?php
    function sendMail($arr) {
        $mail = new PHPMailer();
        $mail->Body = $arr['detail'];
        $mail->CharSet = "utf-8";
        $mail->IsSMTP();// Set mailer to use SMTP
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        // $mail->Host = "192.168.1.78"; // SMTP server
        // $mail->Host = "mail.csloxinfo.com"; // SMTP server
        $mail->Host = "58.137.61.220"; // SMTP server
        // $mail->Host = "smtp.gmail.com"; // Gmail
        // $mail->Host = "smtp.live.com"; // hotmail.com
        $mail->Port = 25; // พอร์ท 25, 465 or 587=
        // $mail->Port = 25; // พอร์ท 25, 465 or 587
        // $mypath = 'img/excel.png';
        // $mypath_name = 'รูปตัวอย่าง';
        $mail->Username = "thanakrit.bh@thaipolycons.co.th"; // SMTP username
        $mail->Password = "tpolypassword"; // SMTP password
        //from
        $mail->SetFrom($arr['from'], $arr['name']);   
        $mail->IsHTML(true);
        //send mail
         if($arr['send'] == 1){
            $mail->AddAddress("apichat.si@thaipolycons.co.th", "apichat");
            // $mail->AddAddress("thanakrit.bh@thaipolycons.co.th", "apichat");
            // $mail->AddCC("thanakrit.bh@thaipolycons.co.th");
         }else{
            $mail->AddAddress($arr['send']);
         }
        
        //$mail->AddReplyTo("email@yourdomain.com", "yourname");
        $mail->Subject = $arr['subject'];  
        
        if(!$mail->send()){
            // $msg = $mail->ErrorInfo;
            $msg = 0;
        }else{
            $msg = 1;
        }
        return $msg;
        // return $arr['detail'].'-'.$arr['subject'].'-'.$arr['from'].'-'.$arr['send'];
    }
    
    function loadTest($arr) {
        $limitPage = $arr['page'];
        $limitStart = ($arr['num'] > 1) ? ($arr['num']-1)*($limitPage) : 0 ;
        $limitEnd = ($arr['num'] > 1) ? ($limitPage * $arr['num']) : $limitPage;

        $sql = "SELECT
                    Em_ID,
                    Em_Pic,
                    Em_Titel,
                    Em_Status,
                    Socie,
                    CAST(Em_Fullname AS Text) AS Fullname,
                    CAST(Em_Lastname AS Text) AS Lastname,
                    CAST(Em_Card AS Text) AS Card,
                    CAST(Site_Name AS Text) AS Site_Name,
                    CAST(Group_Name AS Text) AS Group_Name,
                    CAST(Pos_Name AS Text) AS Pos_Name
                FROM
                (
                    SELECT
                        ROW_NUMBER() OVER (ORDER BY Em_ID DESC) AS rownum,
                        Em_ID,
                        Em_Pic,
                        Em_Titel,
                        Em_Status,
                        Socie,
                        Em_Fullname,
                        Em_Lastname,
                        Em_Card,
                        Site_Name,
                        Group_Name,
                        Pos_Name
                    FROM
                        [HRP].[dbo].[Employees] AS E,
                        [HRP].[dbo].[Sites] AS S,
                        [HRP].[dbo].[Group] AS G,
                        [HRP].[dbo].[Position] AS P
                    WHERE
                        E.Site_ID = S.Site_ID
                        AND E.Group_ID = G.Group_ID
                        AND E.Pos_ID = P.Pos_ID
                        AND E.Em_Status = '". $arr['status'] ."' ";
                        if($arr['site'] != '') {
                            $sql .= "AND S.Site_ID = '". $arr['site'] ."' ";
                        }
                $sql .= ") as e
                WHERE
                    rownum >= '". $limitStart ."' AND rownum <= '". $limitEnd ."' ";
                if($arr['id'] != '') {
                    $sql .= "AND Em_ID = '". $arr['id'] ."' ";
                }
                if($arr['name'] != '') {
                    $name = $Fullname = iconv('UTF-8','TIS-620', $arr['name']);
                    $sql .= "AND (Em_Fullname like '%". $name ."%' or Em_Lastname like '%". $name ."%' or Pos_Name like '%". $name ."%' or Group_Name like '%". $name ."%') ";
                }

        $query = mssql_query($sql);
        $response = array();
        while ($row = mssql_fetch_array($query))
        {
            $response[] = $row;
        }
        mssql_free_result($query);
        return js_thai_encode($response);
        // return $sql;
    }

    function load_num_employee($arr) {
        $sql = "SELECT
                        ROW_NUMBER() OVER (ORDER BY Em_ID DESC) AS rownum,
                        Em_ID,
                        Em_Pic,
                        Em_Titel,
                        Em_Status,
                        Socie,
                        CAST(Em_Fullname AS Text) AS Fullname,
                        CAST(Em_Lastname AS Text) AS Lastname,
                        CAST(Em_Card AS Text) AS Card,
                        CAST(Site_Name AS Text) AS Site_Name,
                        CAST(Group_Name AS Text) AS Group_Name,
                        CAST(Pos_Name AS Text) AS Pos_Name
                    FROM
                        [HRP].[dbo].[Employees] AS E,
                        [HRP].[dbo].[Sites] AS S,
                        [HRP].[dbo].[Group] AS G,
                        [HRP].[dbo].[Position] AS P
                    WHERE
                        E.Site_ID = S.Site_ID
                        AND E.Group_ID = G.Group_ID
                        AND E.Pos_ID = P.Pos_ID
                        AND E.Em_Status = '". $arr['status'] ."' ";
                if($arr['site'] != '') {
                    $sql .= "AND S.Site_ID = '". $arr['site'] ."' ";
                }
                if($arr['id'] != '') {
                    $sql .= "AND Em_ID = '". $arr['id'] ."' ";
                }
                if($arr['name'] != '') {
                    $name = $Fullname = iconv('UTF-8','TIS-620', $arr['name']);
                    $sql .= "AND (Em_Fullname like '%". $name ."%' or Em_Lastname like '%". $name ."%' or Pos_Name like '%". $name ."%' or Group_Name like '%". $name ."%') ";
                }

        $query = mssql_query($sql);
        $num = mssql_num_rows($query);
        return $num;
        // return $sql;
    }

    function js_thai_encode($data) {   // fix all thai elements
        if (is_array($data))
        {
            foreach($data as $a => $b)
            {
                if (is_array($data[$a]))
                {
                    $data[$a] = js_thai_encode($data[$a]);
                }
                else
                {
                    $data[$a] = iconv("tis-620","utf-8",$b);
                }
            }
        }
        else
        {
            $data =iconv("tis-620","utf-8",$data);
        }
        return $data;
    }
?>  Socie,
                    CAST(Em_Fullname AS Text) AS Fullname,
                    CAST(Em_Lastname AS Text) AS Lastname,
                    CAST(Em_Card AS Text) AS Card,
                    CAST(Site_Name AS Text) AS Site_Name,
                    CAST(Group_Name AS Text) AS Group_Name,
                    CAST(Pos_Name AS Text) AS Pos_Name
                FROM
                (
                    SELECT
                        ROW_NUMBER() OVER (ORDER BY Em_ID DESC) AS rownum,
                        Em_ID,
                        Em_Pic,
                        Em_Titel,
                        Em_Status,
                        Socie,
                        Em_Fullname,
                        Em_Lastname,
                        Em_Card,
                        Site_Name,
                        Group_Name,
                        Pos_Name
                    FROM
                        [HRP].[dbo].[Employees] AS E,
                        [HRP].[dbo].[Sites] AS S,
                        [HRP].[dbo].[Group] AS G,
                        [HRP].[dbo].[Position] AS P
                    WHERE
                        E.Site_ID = S.Site_ID
                        AND E.Group_ID = G.Group_ID
                        AND E.Pos_ID = P.Pos_ID
                        AND E.Em_Status = 'W'
                        AND S.Site_ID = '13'
                ) as e
                WHERE
                    rownum >= 0 AND rownum <= '". $limitPage ."' ";
                if($arr['id'] != '') {
                    $sql .= "AND Em_ID = '". $arr['id'] ."' ";
                }
                if($arr['name'] != '') {
                    $name = $Fullname = iconv('UTF-8','TIS-620', $arr['name']);
                    $sql .= "AND (Em_Fullname like '%". $name ."%' or Em_Lastname like '%". $name ."%' or Pos_Name like '%". $name ."%' or Group_Name like '%". $name ."%') ";
                }

        $query = mssql_query($sql);
        $response = array();
        while ($row = mssql_fetch_array($query))
        {
            $response[] = $row;
        }
        mssql_free_result($query);
        return js_thai_encode($response);
        // return $sql;
    }

    function load_num_employee($arr) {
        $sql = "SELECT
                        ROW_NUMBER() OVER (ORDER BY Em_ID DESC) AS rownum,
                        Em_ID,
                        Em_Pic,
                        Em_Titel,
                        Em_Status,
                        Socie,
                        CAST(Em_Fullname AS Text) AS Fullname,
                        CAST(Em_Lastname AS Text) AS Lastname,
                        CAST(Em_Card AS Text) AS Card,
                        CAST(Site_Name AS Text) AS Site_Name,
                        CAST(Group_Name AS Text) AS Group_Name,
                        CAST(Pos_Name AS Text) AS Pos_Name
                    FROM
                        [HRP].[dbo].[Employees] AS E,
                        [HRP].[dbo].[Sites] AS S,
                        [HRP].[dbo].[Group] AS G,
                        [HRP].[dbo].[Position] AS P
                    WHERE
                        E.Site_ID = S.Site_ID
                        AND E.Group_ID = G.Group_ID
                        AND E.Pos_ID = P.Pos_ID
                        AND E.Em_Status = 'W'
                        AND S.Site_ID = '13' ";
                if(!empty($arr['id'])) {
                    $sql .= "AND Em_ID = '". $arr['id'] ."' ";
                }
                if(!empty($arr['name'])) {
                    $name = $Fullname = iconv('UTF-8','TIS-620', $arr['name']);
                    $sql .= "AND (Em_Fullname like '%". $name ."%' or Em_Lastname like '%". $name ."%' or Pos_Name like '%". $name ."%' or Group_Name like '%". $name ."%') ";
                }

        $query = mssql_query($sql);
        $num = mssql_num_rows($query);
        return $num;
        // return $sql;
    }

    function js_thai_encode($data) {   // fix all thai elements
        if (is_array($data))
        {
            foreach($data as $a => $b)
            {
                if (is_array($data[$a]))
                {
                    $data[$a] = js_thai_encode($data[$a]);
                }
                else
                {
                    $data[$a] = iconv("tis-620","utf-8",$b);
                }
            }
        }
        else
        {
            $data =iconv("tis-620","utf-8",$data);
        }
        return $data;
    }
?>