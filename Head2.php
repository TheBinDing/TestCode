<?php
    @session_start();
    $s_user = " SELECT
                    CAST(m_name as text) as name,
                    m_email,
                    m_user,
                    m_rule,
                    m_pic
                FROM
                    [HRP].[dbo].[Users]
                WHERE
                    m_user = '". $_SESSION['user_name'] ."' ";
    $q_user = mssql_query($s_user);
    $r_user = mssql_fetch_array($q_user);
    $name = iconv('TIS-620', 'UTF-8', $r_user['name']);
    $pic = $r_user['m_pic'];
?>

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span>
                        <img alt="image" class="img-circle" src="img/<?php if($pic == ''){ echo 'Thaipolycons.jpg'; }else{ echo $pic; } ?>" style="width: 50px;height: 50px;" />
                        <br>
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                          <span class="block m-t-xs">
                              <strong class="font-bold">ผู้ใช้งาน : </strong>
                          </span>
                          <span class="block m-t-xs">
                              <strong class="font-bold"><?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$name; ?></strong>
                          </span>
                          <!-- <a class="text-muted text-xs block" href="Logout.php">ออกจากระบบ</a> -->
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="Profile.php">Profile</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    <img src="img/<?php if($pic == ''){ echo 'Thaipolycons.jpg'; }else{ echo $pic; } ?>" style="height: 40px;width: 40px;">
                </div>
            </li>
            <?php if($HeadCheck == 'index') {?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                    <a href="News.php"><i class="fa fa-pie-chart"></i> <span class="nav-label">หน้าแรก</span></a>
            </li>
            <?php if($_SESSION['Rule'] == '2') { ?>
                <?php if($HeadCheck == 'Structure' || $HeadCheck == 'Position' || $HeadCheck == 'Dependency' || $HeadCheck == 'Scan') { ?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                    <a href="#"><i class="fa fa-database"></i> <span class="nav-label">จัดการข้อมูล</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <?php if($HeadCheck == 'Position') { ?>
                            <li class="active"><a href='Position.php'>ตำแหน่ง</a></li>
                        <?php } else {?>
                            <li><a href='Position.php'>ตำแหน่ง</a></li>
                        <?php } ?>

                        <?php if($HeadCheck == 'Dependency') { ?>
                            <li class="active"><a href='Dependency.php'>ชุด/สังกัด</a></li>
                        <?php } else {?>
                            <li><a href='Dependency.php'>ชุด/สังกัด</a></li>
                        <?php } ?>
                    </ul>
                </li>

                <?php if($HeadCheck == 'Employee' || $HeadCheck == 'Monitor') { ?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                    <a href="#"><i class="fa fa-user"></i> <span class="nav-label">จัดการบุคลากร</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <?php if($HeadCheck == 'Employee') { ?>
                            <li class="active"><a href='Employee.php'>ข้อมูลพนักงาน</a></li>
                        <?php } else {?>
                            <li><a href='Employee.php'>ข้อมูลพนักงาน</a></li>
                        <?php } ?>
                        <?php if($HeadCheck == 'Monitor') { ?>
                            <li class="active"><a href='Monitor.php'>ข้อมูลการทำงาน</a></li>
                        <?php } else {?>
                            <li><a href='Monitor.php'>ข้อมูลการทำงาน</a></li>
                        <?php } ?>
                    </ul>
                </li>

                <?php if($HeadCheck == 'Plan' || $HeadCheck == 'PlanPeople') {?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                    <a href="#"><i class="fa fa-paper-plane"></i> <span class="nav-label">จัดการแผนเวลาทำงาน</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <?php if($HeadCheck == 'Plan') { ?>
                            <li class="active"><a href='Plan.php'>ตั้งค่าแผนเวลา</a></li>
                        <?php } else {?>
                            <li><a href='Plan.php'>ตั้งค่าแผนเวลา</a></li>
                        <?php } ?>

                        <?php if($HeadCheck == 'PlanPeople') { ?>
                            <li class="active"><a href='PlanPeople.php'>แผนเวลาบุคคล</a></li>
                        <?php } else {?>
                            <li><a href='PlanPeople.php'>แผนเวลาบุคคล</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php if($HeadCheck == 'Import_File' || $HeadCheck == 'TimeCal' || $HeadCheck == 'TimePlan') {?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                    <a href="#"><i class="fa fa-clock-o"></i> <span class="nav-label">จัดการเวลา</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <?php if($HeadCheck == 'Import_File') { ?>
                            <li class="active"><a href='Import_File.php'>นำเข้า ไฟล์เวลา</a></li>
                        <?php } else {?>
                            <li><a href='Import_File.php'>นำเข้า ไฟล์เวลา</a></li>
                        <?php } ?>

                        <?php if($HeadCheck == 'TimePlan') { ?>
                            <li class="active"><a href='TimePlan.php'>คำนวณค่าเวลาและ OT</a></li>
                        <?php } else {?>
                            <li><a href='TimePlan.php'>คำนวณค่าเวลาและ OT</a></li>
                        <?php } ?>
                    </ul>
                </li>

                <?php if($HeadCheck == 'Expenses' || $HeadCheck == 'CalcuMoney') {?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                    <a href="#"><i class="fa fa-credit-card"></i> <span class="nav-label">จัดการเงิน</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a data-toggle="modal" data-target="#myModal4">ประกันสังคม</a>
                            <div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog"    aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content animated flipInY">
                                        <?php
                                            $sql_s = " SELECT Social_Number FROM [HRP].[dbo].[SocialSecurity] ";
                                            $query_s = mssql_query($sql_s);
                                            $row_s = mssql_fetch_array($query_s);
                                        ?>
                                        <!-- <form action="func/SocailUpdate.php" method="POST"> -->
                                        <form action="func/SocailUpdate.php" method="POST" target="iframe_target">
                                        <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                                            <div class="modal-header">
                                                <h2>ประกันสังคม</h2>
                                            </div>
                                            <div class="modal-body">
                                                <label class="control-label">แก้ไขประกันสังคม (%)</label>
                                                <input type="number" value="<?php echo $row_s['Social_Number']; ?>" id="So" name="So" required="required" class="form-control" style="text-align: center;height: 30px;">
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary Soc">บันทึก</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php if($HeadCheck == 'Expenses') { ?>
                            <li class="active"><a href='Expenses.php'>การเบิกอุปกรณ์หรือค่าใช้จ่ายอื่นๆ</a></li>
                        <?php } else {?>
                            <li><a href='Expenses.php'>การเบิกอุปกรณ์หรือค่าใช้จ่ายอื่นๆ</a></li>
                        <?php } ?>

                        <?php if($HeadCheck == 'CalcuMoney') { ?>
                            <li class="active"><a href='CalcuMoney.php'>รายงานการเงิน</a></li>
                        <?php } else {?>
                            <li><a href='CalcuMoney.php'>รายงานการเงิน</a></li>
                        <?php } ?>
                    </ul>
                </li>

                <?php if($HeadCheck == 'Report' || $HeadCheck == 'ReportEm') { ?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                    <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">รายงาน</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <?php if($HeadCheck == 'ReportEm') { ?>
                            <li class="active"><a href='ReportEm.php'>พนักงาน เข้า - ออก</a></li>
                        <?php } else {?>
                            <li><a href='ReportEm.php'>พนักงาน เข้า - ออก</a></li>
                        <?php } ?>

                        <?php if($HeadCheck == 'Report') { ?>
                            <li class="active"><a href='Report.php'>อื่นๆ</a></li>
                        <?php } else {?>
                            <li><a href='Report.php'>อื่นๆ</a></li>
                        <?php } ?>
                    </ul>
                </li>

                <?php if($HeadCheck == 'GrapCost' || $HeadCheck == 'GrapEquipment') { ?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                    <a href="#"><i class="fa fa-bar-chart"></i> <span class="nav-label">ข้อมูล Grap</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <?php if($HeadCheck == 'GrapCost') { ?>
                            <li class="active"><a href='ReportGrapCost.php'>ค่าแรง</a></li>
                        <?php } else {?>
                            <li><a href='ReportGrapCost.php'>ค่าแรง</a></li>
                        <?php } ?>

                        <?php if($HeadCheck == 'GrapEquipment') { ?>
                            <li class="active"><a href='ReportGrapEquipment.php'>เบิก-จ่าย</a></li>
                        <?php } else {?>
                            <li><a href='ReportGrapEquipment.php'>เบิก-จ่าย</a></li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>

            <?php if($_SESSION['Rule'] == '3') { ?>
                <?php if($HeadCheck == 'Dependency') { ?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                    <a href="#"><i class="fa fa-database"></i> <span class="nav-label">จัดการข้อมูล</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <?php if($HeadCheck == 'Dependency') { ?>
                            <li class="active"><a href='Dependency.php'>ชุด/สังกัด</a></li>
                        <?php } else {?>
                            <li><a href='Dependency.php'>ชุด/สังกัด</a></li>
                        <?php } ?>
                    </ul>
                </li>

                <?php if($HeadCheck == 'Employee') { ?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                    <a href="#"><i class="fa fa-user"></i> <span class="nav-label">จัดการบุคลากร</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <?php if($HeadCheck == 'Employee') { ?>
                            <li class="active"><a href='Employee.php'>ข้อมูลพนักงาน</a></li>
                        <?php } else {?>
                            <li><a href='Employee.php'>ข้อมูลพนักงาน</a></li>
                        <?php } ?>
                    </ul>
                </li>

                <?php if($HeadCheck == 'Plan' || $HeadCheck == 'PlanPeople') {?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                    <a href="#"><i class="fa fa-paper-plane"></i> <span class="nav-label">จัดการแผนเวลาทำงาน</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <?php if($HeadCheck == 'Plan') { ?>
                            <li class="active"><a href='Plan.php'>ตั้งค่าแผนเวลา</a></li>
                        <?php } else {?>
                            <li><a href='Plan.php'>ตั้งค่าแผนเวลา</a></li>
                        <?php } ?>

                        <?php if($HeadCheck == 'PlanPeople') { ?>
                            <li class="active"><a href='PlanPeople.php'>แผนเวลาบุคคล</a></li>
                        <?php } else {?>
                            <li><a href='PlanPeople.php'>แผนเวลาบุคคล</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php if($HeadCheck == 'Import_File' || $HeadCheck == 'TimeCal' || $HeadCheck == 'TimePlan') {?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                    <a href="#"><i class="fa fa-clock-o"></i> <span class="nav-label">จัดการเวลา</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <?php if($HeadCheck == 'Import_File') { ?>
                            <li class="active"><a href='Import_File.php'>นำเข้า ไฟล์เวลา</a></li>
                        <?php } else {?>
                            <li><a href='Import_File.php'>นำเข้า ไฟล์เวลา</a></li>
                        <?php } ?>

                        <?php if($HeadCheck == 'TimePlan') { ?>
                            <li class="active"><a href='TimePlan.php'>คำนวณค่าเวลาและ OT</a></li>
                        <?php } else {?>
                            <li><a href='TimePlan.php'>คำนวณค่าเวลาและ OT</a></li>
                        <?php } ?>
                    </ul>
                </li>

                <?php if($HeadCheck == 'Expenses' || $HeadCheck == 'CalcuMoney') {?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                    <a href="#"><i class="fa fa-credit-card"></i> <span class="nav-label">จัดการเงิน</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a data-toggle="modal" data-target="#myModal4">ประกันสังคม</a>
                            <div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog"    aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content animated flipInY">
                                        <?php
                                            $sql_s = " SELECT Social_Number FROM [HRP].[dbo].[SocialSecurity] ";
                                            $query_s = mssql_query($sql_s);
                                            $row_s = mssql_fetch_array($query_s);
                                        ?>
                                        <!-- <form action="func/SocailUpdate.php" method="POST"> -->
                                        <form action="func/SocailUpdate.php" method="POST" target="iframe_target">
                                        <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                                            <div class="modal-header">
                                                <h2>ประกันสังคม</h2>
                                            </div>
                                            <div class="modal-body">
                                                <label class="control-label">แก้ไขประกันสังคม (%)</label>
                                                <input type="number" value="<?php echo $row_s['Social_Number']; ?>" id="So" name="So" required="required" class="form-control" style="text-align: center;height: 30px;">
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary Soc">บันทึก</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php if($HeadCheck == 'Expenses') { ?>
                            <li class="active"><a href='Expenses.php'>การเบิกอุปกรณ์หรือค่าใช้จ่ายอื่นๆ</a></li>
                        <?php } else {?>
                            <li><a href='Expenses.php'>การเบิกอุปกรณ์หรือค่าใช้จ่ายอื่นๆ</a></li>
                        <?php } ?>

                        <?php if($HeadCheck == 'CalcuMoney') { ?>
                            <li class="active"><a href='CalcuMoney.php'>รายงานการเงิน</a></li>
                        <?php } else {?>
                            <li><a href='CalcuMoney.php'>รายงานการเงิน</a></li>
                        <?php } ?>
                    </ul>
                </li>

                <!-- <?php if($HeadCheck == 'Report') { ?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                    <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">รายงาน</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <?php if($HeadCheck == 'Report') { ?>
                            <li class="active"><a href='Report.php'>อื่นๆ</a></li>
                        <?php } else {?>
                            <li><a href='Report.php'>อื่นๆ</a></li>
                        <?php } ?>
                    </ul>
                </li> -->

                <?php if($HeadCheck == 'Grap') { ?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                    <a href="#"><i class="fa fa-bar-chart"></i> <span class="nav-label">ข้อมูล Grap</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <?php if($HeadCheck == 'Grap') { ?>
                            <li class="active"><a href='ReportGrapCost.php'>ค่าแรง</a></li>
                        <?php } else {?>
                            <li><a href='ReportGrapCost.php'>ค่าแรง</a></li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </div>
    <!-- <?php
        $today = date('d-m-Y');
        $sql="SELECT count(ip_visit) as visit FROM [HRP].[dbo].[Counter]" ;
        $result= mssql_query($sql);
        $row = mssql_fetch_array($result);
        $visit = $row[visit];
        $id_visit = $row[id_vist];
        $openpage =  str_pad($visit,6,0,str_pad_left);

        $sql_today = "SELECT count(DISTINCT(ip_visit)) as visit FROM [HRP].[dbo].[Counter] WHERE date_visit = '". $today ."' ";
        $result_today = mssql_query($sql_today);
        $row_today = mssql_fetch_array($result_today);
        $visit_today = $row_today[visit];
        $id_visit_today = $row_today[id_vist];
        $today = str_pad($visit_today,6,0,str_pad_left);

        $sql_t = "SELECT count(DISTINCT(ip_visit)) as visit FROM [HRP].[dbo].[Counter]";
        $result_t = mssql_query($sql_t);
        $row_t = mssql_fetch_array($result_t);
        $visit_t = $row_t[visit];
        $total = str_pad($visit_t,6,0,str_pad_left);
    ?>
	<br><br><br><br><br><br><br><br><br><br>
    <div class="dropdown profile-element" style="width:220px;">
        <div style="border:1px solid #2f4050;padding:5px;background:#2f4050;">
            <div id="showcounter">
                <center style="background:#2f4050;">
                    <table>
                        <tr>
                            <td style="color: #676a6c;"><span>เปิดเข้าใช้งาน : </span></td>
                            <td id="counter" bgcolor="#2f4050" style="color: #676a6c;"><?=$openpage?></td>
                        </tr>
                        <tr>
                            <td style="color: #676a6c;"><span>จำนวนของวันนี้ : </span></td>
                            <td id="counter" bgcolor="#2f4050" style="color: #676a6c;"><?=$today?></td>
                        </tr>
                        <tr>
                            <td style="color: #676a6c;"><span>จำนวนทั้งหมด : </span></td>
                            <td id="counter" bgcolor="#2f4050" style="color: #676a6c;"><?=$total?></td>
                        </tr>
                    </table>
                </center>
            </div>
        </div>
    </div> -->
</nav>