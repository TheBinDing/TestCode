<?php
    @session_start();
    require("inc/connect.php");
    // require("inc/function.php");
    // checklogin($_SESSION['user_name']);
    // $HeadCheck = 'Employee';
    // $_SESSION['Link'] = 'Employee.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="css/plugins/footable/footable.core.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/blue/pace-theme-loading-bar.css" />
    <link href="css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <title>บริษัท ไทยโพลีคอนส์ จำกัด (มหาชน)</title>
</head>
<style>
    .showImg {
        width:50%;
        height:100px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        background-color: #fff;
        background-image: url('img/loader.gif');
        background-repeat: no-repeat;
        background-position:center 50%;
    }

    .shows {
        position:fixed;
        top:0px;
        left:0px;
        width:100%;
        height:100%;
        z-index:99;
        display: none;
    }
</style>
<body>
    <div class="row">
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav metismenu" id="side-menu">
                        <li>
                            <div class="dropdown profile-element">
                                <img src="img/1444982315.png" width="200" height="140" border="0" style="vertical-align:top;" alt="" title="">
                            </div>
                            <div class="logo-element">
                                <img src="img/<?php if($pic == ''){ echo 'Thaipolycons.jpg'; }else{ echo $pic; } ?>" style="height: 40px;width: 40px;">
                                <a href="News.php"><span class="nav-label">หน้าแรก</span></a>
                            </div>
                        </li>
                        <li>
                            <a href="News.php"><i class="fa fa-pie-chart"></i> <span class="nav-label">หน้าแรก</span></a>
                        </li>
                        <li>
                            <a href="News.php"><i class="fa fa-pie-chart"></i> <span class="nav-label">หน้าแรก</span></a>
                        </li>
                        <li>
                            <a href="News.php"><i class="fa fa-pie-chart"></i> <span class="nav-label">หน้าแรก</span></a>
                        </li>
                        <li>
                            <a href="News.php"><i class="fa fa-pie-chart"></i> <span class="nav-label">หน้าแรก</span></a>
                        </li>
                        <li>
                            <a href="News.php"><i class="fa fa-pie-chart"></i> <span class="nav-label">หน้าแรก</span></a>
                        </li>
                    </ul>
                </div>
            </nav>
        <div id="page-wrapper" class="gray-bg">
        <?php require("MenuSite.php"); ?>
            <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <div id="showTime" style="font-size: 10px;"></div>
            <div class="ibox-content">
                <ul class="nav nav-tabs">
                    <li class="active" id="tab1"><a data-toggle="tab" href="#" onclick="tpoly.employee.setStatus('W');">ทำงาน</a></li>
                    <li class="" id="tab2"><a data-toggle="tab" href="#" onclick="tpoly.employee.setStatus('O');">ออก</a></li>
                    <li class="" id="tab3"><a data-toggle="tab" href="#" onclick="tpoly.employee.setStatus('B');">Blacklist</a></li>
                </ul>
                <div class="tab-content">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="dataTables_length">
                                    <label>
                                        <select id="employeePage" style="display: inline-block;width: auto;height: 30px;vertical-align: middle;" onChange="tpoly.employee.page(this);">
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                        จำนวนแสดงต่อหน้า
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="dataTables_filter">
                                    <label>ค้นหา : 
                                        <input type="search" class="form-control input-sm" style="display: inline-block;width: auto;vertical-align: middle;" id="peopleEmployee" placeholder="ค้าหาพนักงาน" onChange="tpoly.employee.setSearch(this);">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="EmployeeList"></div>
                <div id="ListPage"></div>
                <div class="modal inmodal" id="myModals01" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content animated fadeIn">
                            <div class="modal-header">
                                <h2>ข้อมูลพนักงาน</h2>
                            </div>
                            <div class="modal-header">
                                <div class="form-group">
                                    <div class="radio-inline">
                                        <img alt="" src="img/Login.png" id="myImage" data-holder-rendered="true" style="height: 150px; width: 150px; display: block;">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <p>ข้อมูลส่วนตัว</p>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="Cards"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="IDs"></p>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="Name"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="DateBirthDay"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="Age"></p>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="Address"></p>
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="modal-body">
                                <p>สถานะประกันงสังคม</p>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="Social"></p>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="Hospital"></p>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="InformIn"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="InformOut"></p>
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="modal-body">
                                <p>ข้อมูลพนักงาน</p>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="DateOpen"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="DateOpen2"></p>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="Site"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="Position"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="Group"></p>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="Personal"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="Personal2"></p>
                                    </label>
                                </div>
                                <div class="form-group" id="All01">
                                    <label class="radio-inline width-text2">
                                        <p id="LivingExpenses"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="Allowance"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="AllowanceDisaster"></p>
                                    </label>
                                </div>
                                <div class="form-group" id="All02">
                                    <label class="radio-inline width-text2">
                                        <p id="AllowanceSafety"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="SpecialAllowance"></p>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="radio-inline width-text2">
                                        <p id="Bank"></p>
                                    </label>
                                </div>
                                <div class="form-group" id="BankD">
                                    <label class="radio-inline width-text2">
                                        <p id="BankDetail"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="BankDetail2"></p>
                                    </label>
                                    <label class="radio-inline width-text2">
                                        <p id="BankDetail3"></p>
                                    </label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" id="Em_IDs" />
                                <button class="btn btn-success" id="buttons" onclick="swap();">แก้ไขข้อมูล</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div id="block" class="sweet-overlay">
        <div id="loading" class="shows" style="display:none;">
            <div style="margin:20% auto;width: 250px;">
                <div class="showImg"></div>
            </div>
        </div>
    </div>
</body>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/inspinia.js"></script>
<!-- <script src="js/plugins/pace/pace.min.js"></script> -->
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>
<script src="js/plugins/switchery/switchery.js"></script>
<script src="js/plugins/iCheck/icheck.min.js"></script>
<!-- <script src="js/pace.js"></script> -->
<script src="js/tpoly.employee.js"></script>
<script type="text/javascript">
<!--

    jQuery(function( $ ) {
        tpoly.employee.Criteria =
        {
            user : '<?=$_SESSION['SuperName'];?>',
            rule : '<?php echo $_SESSION['Rule']; ?>'
        };
        tpoly.employee.loadEmployee();
        tpoly.StartClock24();
    });

//-->
</script>
<html>