<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-success " href="#"><i class="fa fa-bars"></i> </a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <a data-toggle="modal" data-target="#myModals100" class="fa fa-list">  ทำงานวันนนี้</a>
            </li>
            <?php
                $sqlq = "SELECT CAST(Site_Name AS Text) AS Site_Name, Site_ID AS Site_ID FROM [HRP].[dbo].[Sites] WHERE Site_ID = '". $_SESSION['SuperSite'] ."' ";
                $querySS = mssql_query($sqlq);
                $rowSS = mssql_fetch_array($querySS);
            ?>
            <?php if($_SESSION['Rule'] == 3) { ?>
                <li>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="text-muted text-xs block">โครงการ : <?php echo iconv('TIS-620', 'UTF-8', $rowSS['Site_Name']); ?> <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <?php
                            $sqlU = "SELECT CAST(m_site as Text) as Site FROM [HRP].[dbo].[Users] WHERE m_id = '". $_SESSION['user_id'] ."' ";
                            $queryU = mssql_query($sqlU);
                            $rowU = mssql_fetch_assoc($queryU);

                            $a = explode(',', $rowU['Site']);

                            foreach ($a as $key => $value) {
                                if($value != $_SESSION['SuperSite']) {
                                    $status = "SELECT
                                                    ss.Site_ID
                                                FROM
                                                    [HRP].[dbo].[Site] s inner join
                                                    [HRP].[dbo].[Sites] ss on s.Sites_ID = ss.Sites_ID
                                                WHERE
                                                    s.Sites_Status = '0'
                                                AND
                                                    ss.Site_ID = '". $value ."' ";
                                    $queryst = mssql_query($status);
                                    $rowst = mssql_fetch_assoc($queryst);

                                    if($value != $rowst['Site_ID']) {
                                        $site = "SELECT
                                                    ss.Site_ID,
                                                    CAST(ss.Site_Name as Text) as Site_Name,
                                                    s.Sites_Status
                                                FROM
                                                    [HRP].[dbo].[Site] s inner join
                                                    [HRP].[dbo].[Sites] ss on s.Sites_ID = ss.Sites_ID
                                                WHERE
                                                    s.Sites_Status = '1'
                                                    AND ss.Site_ID = '". $value ."' ";
                                        $querys = mssql_query($site);
                                        $rows = mssql_fetch_assoc($querys);
                        ?>
                           <li><a href="func/Check.php?Site=<?php echo $rows['Site_ID'];?>"><?php echo iconv('TIS-620', 'UTF-8', $rows['Site_Name']);?></a></li>
                        <?php } } } ?>
                    </ul>
                </li>
            <?php } else { ?>
                <li>
                    <a class="right-sidebar-toggle">
                        โครงการ : <?php echo iconv('TIS-620', 'UTF-8', $rowSS['Site_Name']); ?>
                    </a>
                </li>
            <?php } ?>
            <li>
                <a href="Logout.php">
                    <i class="fa fa-sign-out"></i> ออกจากระบบ
                </a>
            </li>
        </ul>
    </nav>
    <div id="right-sidebar">
        <div class="sidebar-container">
            <ul class="nav nav-tabs navs-10">
                <li class="active"><a data-toggle="tab" href="#tab-1">
                    โครงการ : <?php echo iconv('TIS-620', 'UTF-8', $rowSS['Site_Name']); ?>
                </a></li>
            </ul>

            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">

                    <div class="sidebar-title">
                        <?php $sqls = "SELECT
                                        CAST(ss.Site_Name AS Text) AS Name,
                                        ss.Site_ID AS ID
                                    FROM
                                        [HRP].[dbo].[Site] s inner join
                                        [HRP].[dbo].[Sites] ss on s.Sites_ID = ss.Sites_ID
                                    WHERE
                                        ss.Site_ID != '".$_SESSION['SuperSite']."'
                                        AND ss.Site_Status = '1'
                                    ORDER BY
                                        ss.Site_Name ASC ";

                            $querys = mssql_query($sqls);
                            $nums = mssql_num_rows($querys);
                            for($i=1;$i<=$nums;$i++) {
                                $rows = mssql_fetch_array($querys); ?>
                                <li>
                                    <a href="func/Check.php?Site=<?php echo $rows['ID'];?>">
                                        <?php echo iconv('TIS-620', 'UTF-8', $rows['Name']);?>
                                    </a>
                                </li>
                            <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal" id="myModals100" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <h2>รายชื่อพนักงานที่มาทำงานวันนี้</h2>
                </div>
                <?php
                    $Datss = new Datetime();
                    $Datss = $Datss->format('Y-m-d');

                    $sqlw = "SELECT
                                CAST(e.Em_Fullname as Text) as Namef,
                                CAST(e.Em_Lastname as Text) as Lastf,
                                CAST(e.Em_Titel as Text) as Titel,
                                CAST(s.Site_Name as Text) as Names,
                                CAST(p.Pos_Name as Text) as Namep,
                                CAST(g.Group_Name as Text) as Nameg,
                                t.LogTime,
                                t.CK_in,
                                t.Ck_Out1,
                                t.CK_in2,
                                t.Ck_Out2
                            FROM
                                [HRP].[dbo].[Employees] e inner join
                                [HRP].[dbo].[Time_Plan] t on e.Em_ID = t.Em_ID inner join
                                [HRP].[dbo].[Sites] s on e.Site_ID = s.Site_ID inner join
                                [HRP].[dbo].[Position] p on e.Pos_ID = p.Pos_ID inner join
                                [HRP].[dbo].[Group] g on e.Group_ID = g.Group_ID
                            WHERE
                                t.LogTime = '". $Datss ."'
                                AND (t.CK_in != '' or t.Ck_Out1 != '' or t.CK_in2 != '' or t.Ck_Out2 != '') ";
                    if($_SESSION['SuperSite'] != 1) {
                        $sqlw .= " AND e.Site_ID = '". $_SESSION['SuperSite'] ."' ";
                    }
                    $sqlw .= "
                            ORDER BY
                                e.Site_ID ASC,
                                e.Em_Fullname ASC ";

                    $queryw = mssql_query($sqlw);
                    $numw = mssql_num_rows($queryw);
                ?>
                <div class="modal-body">
                    <table class="table table-striped table-bordered table-hover" id="editable">
                        <thead>
                            <tr>
                                <th style="text-align: center;">#</th>
                                <th style="text-align: center;">ชื่อ/นามสกุล</th>
                                <th style="text-align: center;">โครงการ</th>
                                <th style="text-align: center;width: 150px;">ตำแหน่ง</th>
                                <th style="text-align: center;width: 150px;">ชุด/สังกัด</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                for($w=1 ; $w <= $numw ; $w ++) {
                                    $roww = mssql_fetch_array($queryw);

                                    if($roww['Titel'] == 'Mr') {
                                        $Titel_b = 'นาย ';
                                    }
                                    if($roww['Titel'] == 'Ms') {
                                        $Titel_b = 'นางสาว ';
                                    }
                                    if($roww['Titel'] == 'Mrs') {
                                        $Titel_b = 'นาง ';
                                    }

                                    $Namew = $Titel_b.' '.iconv('TIS-620','UTF-8',$roww['Namef']).' '.iconv('TIS-620','UTF-8',$roww['Lastf']);;
                                    $Sitew = iconv('TIS-620','UTF-8',$roww['Names']);
                                    $Positionw = iconv('TIS-620','UTF-8',$roww['Namep']);
                                    $Groupw = iconv('TIS-620','UTF-8',$roww['Nameg']);
                            ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $w; ?></td>
                                <td><?php echo $Namew; ?></td>
                                <td><?php echo $Sitew; ?></td>
                                <td><?php echo $Positionw; ?></td>
                                <td><?php echo $Groupw; ?></td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>