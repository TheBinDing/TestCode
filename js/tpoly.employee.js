var tpoly = {
    employee: new Object()
};

(function ( $ ) {    
    tpoly.popup = function(value) {
        if(value == 'loading'){
            $('#block').css('display','block');
            $('#loading').fadeIn();
            $('html').css('overflow','hidden');
            $('body').css('overflow','hidden');
        }
        else if(value == 'close'){
            $('#block').css('display','none');
            $('#loading').css('display','none');
            $('html').css('overflow','auto');
            $('body').css('overflow','auto');
        }
    }

    tpoly.employee.page = function(page) {
        p = $('#employeePage').val();
        tpoly.employee.loadEmployee('',p);
    }

    tpoly.employee.loadEmployee = function(obj, page) {
        vv = $(obj).val();
        tpoly.employee.Criteria['name'] = '';
        tpoly.employee.Criteria['id'] = '';

        if(page == undefined || page == '') {
            page = $('#employeePage').val();
        }

        if(vv != undefined || vv == '') {
            if(isNaN(vv)) {
                tpoly.employee.Criteria['name'] = vv;
            } else {
                tpoly.employee.Criteria['id'] = vv;
            }

        }

        tpoly.employee.Criteria['mode'] = 'loadTest';
        tpoly.employee.Criteria['page'] = page;
        
        var ajax_config = {
            url: "AjaxSearch.php",
            dataType: "json",
            type: "POST",
            data: tpoly.employee.Criteria,
            beforeSend: function() {
                tpoly.popup('loading');
            }
        };

        var get_ajax = $.ajax(ajax_config);
        get_ajax.done(function(response) {
            tpoly.test = response;
            var EmployeeList = $('#EmployeeList');
            resultSearch = tpoly.test;
            var html = '';
            html += '<table class="table table-striped table-bordered table-hover">';
            html += '<thead>';
            html += '<tr>';
            html += '<th style="text-align: center;">รหัสพนักงาน</th>';
            html += '<th style="text-align: center;">ชื่อ/นามสกุล</th>';
            html += '<th style="text-align: center;">โครงการ</th>';
            html += '<th style="text-align: center;">ตำแหน่ง</th>';
            html += '<th style="text-align: center;width: 10em;">ชุด/สังกัด</th>';
            html += '<th style="text-align: center;width: 10em;">ดูข้อมูล</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            for(var i in resultSearch) {
                s = parseInt(i);
                m = (s+1);
                html += '<tr>';
                html += '<td style="text-align: center;">'+resultSearch[i]['Em_ID']+'</td>';
                html += '<td style="">'+resultSearch[i]['Fullname']+' '+resultSearch[i]['Lastname']+'</td>';
                html += '<td style="">'+resultSearch[i]['Site_Name']+'</td>';
                html += '<td style="">'+resultSearch[i]['Pos_Name']+'</td>';
                html += '<td style="">'+resultSearch[i]['Group_Name']+'</td>';
                html += '<td style="text-align: center;">';
                html += '<a data-toggle="modal" data-target="#myModals01" class="open-sendname btn-white btn btn-xs" data-id="'+resultSearch[i]['Em_ID']+'" >ดูข้อมูล</a>';
                html += '</td>';
                html += '</tr>';
            }
            html += '</tbody>';
            html += '</table>';

            EmployeeList.html(html);
            tpoly.employee.numEmployee();
        });
    }

    tpoly.employee.numEmployee = function() {
        tpoly.employee.Criteria['mode'] = 'load_num_employee';
        
        var ajax_config = {
            url: "AjaxSearch.php",
            dataType: "json",
            type: "POST",
            data: tpoly.employee.Criteria,
            // beforeSend: function() {
            //     tpoly.popup('loading');
            // }
        };

        var get_ajax = $.ajax(ajax_config);
        get_ajax.done(function(response) {
            tpoly.num = response;
            resultNum = tpoly.num;
            end = tpoly.employee.Criteria['page'];
            start = (end - (end - 1));
            var ListPage = $('#ListPage');

            var html = '';
            html += '<br>';
            html += '<span>ข้อมูลจาก '+ start +' ถึง '+ end +' จากทั้งหมด '+ resultNum +' รายการ</span>';
            html += '<div class="dataTables_paginate paging_simple_numbers">';
            html += '<ul class="pagination">';
            html += '<li id="employsearch-page-pre" class="paginate_button previous disabled">';
            html += '<a href="#">Previous</a>';
            html += '</li>';
            html += '<li class="paginate_button">';
            html += '<a href="#">1</a>';
            html += '</li>';
            html += '<li class="paginate_button">';
            html += '<a href="#">2</a>';
            html += '</li>';
            html += '<li class="paginate_button">';
            html += '<a href="#">3</a>';
            html += '</li>';
            html += '<li id="employsearch-page-next" class="paginate_button next disabled">';
            html += '<a href="#">Next</a>';
            html += '</li>';
            html += '</ul>';
            html += '</div>';

            ListPage.html(html);
            tpoly.popup('close');
        });
    }

    // tpoly.selectEmployee = function(vars) {
    //     tpoly.employee.Criteria['mode'] = 'load_employee_ae';
    //     tpoly.employee.Criteria['code'] = vars;
    //     var ajax_config = {
    //         url: "func/AjaxSearch.php",
    //         dataType: "json",
    //         type: "POST",
    //         data: tpoly.employee.Criteria,
    //     };

    //     var get_ajax = $.ajax(ajax_config);
    //     get_ajax.done(function(response) {
    //         EmList = response;
    //         tpoly.setEm(0);
    //     });
    // }

    // tpoly.setEm = function(key) {
    //     result = EmList;

    //     var permiss = tpoly.employee.Criteria['rule'];

    //     $('#Em_IDs').val(result[0]['IDs']);

    //     if(result[0]['Titel'] == 'Mr') {
    //         Titel = 'นาย ';
    //     }
    //     if(result[0]['Titel'] == 'Ms') {
    //         Titel = 'นางสาว ';
    //     }
    //     if(result[0]['Titel'] == 'Mrs') {
    //         Titel = 'นาง ';
    //     }

    //     if(result[0]['DayCost'] == 'Month') {
    //         Cost = 'รายเดือน';
    //     }
    //     if(result[0]['DayCost'] == 'Day') {
    //         Cost = 'รายวัน';
    //     }

    //     if(result[0]['ChoiceBank'] == 'C') {
    //         Choice = 'รับเงินสด';
    //         $('#BankD').css('display', 'none');
    //     }
    //     if(result[0]['ChoiceBank'] == 'B') {
    //         Choice = 'โอนเข้าธนาคาร';
    //     }
    //     if(result[0]['Soice'] == 1) {
    //         social = 'คิด'
    //     }
    //     if(result[0]['Soice'] == 0) {
    //         social = 'ไม่คิด'
    //     }
    //     if(result[0]['LivingExpenses'] == 0) {
    //         $('#LivingExpenses').css('display', 'none');
    //     }
    //     if(result[0]['Allowance'] == 0) {
    //         $('#Allowance').css('display', 'none');
    //     }
    //     if(result[0]['AllowanceDisaster'] == 0) {
    //         $('#AllowanceDisaster').css('display', 'none');
    //     }
    //     if(result[0]['AllowanceSafety'] == 0) {
    //         $('#AllowanceSafety').css('display', 'none');
    //     }
    //     if(result[0]['SpecialAllowance'] == 0) {
    //         $('#SpecialAllowance').css('display', 'none');
    //     }
    //     if((result[0]['LivingExpenses'] == 0) && (result[0]['Allowance'] == 0)) {
    //         $('#All01').css('display', 'none');
    //     }
    //     if((result[0]['AllowanceDisaster'] == 0) && (result[0]['AllowanceSafety'] == 0) && (result[0]['SpecialAllowance'] == 0)) {
    //         $('#All02').css('display', 'none');
    //     }
    //     if(result[0]['Status'] == 'B' && permiss == '3') {
    //         $('#buttons').css('display', 'none');
    //     } else {
    //         $('#buttons').css('display', '');
    //     }

    //     aDateOpen = result[0]['DateOpen'];
    //     spTodayA = aDateOpen.split(' ');
    //     todaya = spTodayA[0] + ' ' + spTodayA[1] + ' ' + spTodayA[2];
    //     dateTodayA = formatDate(todaya);
    //     bDateBirthDay = result[0]['DateBirthDay'];
    //     spTodayB = bDateBirthDay.split(' ');
    //     todayb = spTodayB[0] + ' ' + spTodayB[1] + ' ' + spTodayB[2];
    //     dateTodayB = formatDate(todayb);

    //     tests = Date();
    //     testsD = tests.split(' ');

    //     Daied = (testsD[3] - spTodayB[2]);

    //     dWork = formatDateSeach(todaya);
    //     var res = dWork.split("-");
    //     var d = res[0] + '/' + res[1] + '/' + res[2];
    //     var c = age(new Date(d));
    //     var c = c.toString();
    //     var f = c.split("-");

    //     if(result[0]['Pic'] != '') {
    //         document.getElementById('myImage').src = 'func/EmployeePicture/' + result[0]['Pic'];
    //     }
    //     if(result[0]['Pic'] == '') {
    //         document.getElementById('myImage').src = 'img/Login.png';
    //     }
    //     document.getElementById("Cards").innerHTML = 'เลขบัตรประชาชน : '+result[0]['Cards'];
    //     document.getElementById("IDs").innerHTML = 'รหัสพนักงาน : '+result[0]['IDs'];
    //     document.getElementById("Name").innerHTML = 'ชื่อ - นามสกุล : '+Titel+' '+result[0]['Fullname']+' '+result[0]['Lastname'];
    //     document.getElementById("DateBirthDay").innerHTML = 'วัน/เดือน/ปี เกิด : '+ dateTodayB;
    //     document.getElementById("Age").innerHTML = 'อายุ : '+ Daied + ' ปี';
    //     document.getElementById("Address").innerHTML = 'ที่อยู่ : '+result[0]['Address'];
    //     document.getElementById("DateOpen").innerHTML = 'วันที่เข้าทำงาน : '+dateTodayA;
    //     document.getElementById("DateOpen2").innerHTML = f[0]+' ปี '+f[1]+' เดือน '+f[2]+' วัน';
    //     document.getElementById("Site").innerHTML = 'โครงการ : '+result[0]['Site_Name'];
    //     document.getElementById("Position").innerHTML = 'ตำแหน่ง : '+result[0]['Pos_Name'];
    //     document.getElementById("Group").innerHTML = 'ชุด/สังกัด : '+result[0]['Group_Name'];
    //     document.getElementById("Personal").innerHTML = 'พนักงาน : '+ Cost;
    //     document.getElementById("Personal2").innerHTML = 'ค่าแรง : '+result[0]['Money']+' บาท';
    //     document.getElementById("LivingExpenses").innerHTML = 'เบี้ยเลี้ยง : '+result[0]['LivingExpenses']+' บาท';
    //     document.getElementById("Allowance").innerHTML = 'เบี้ยเลี้ยง2 : '+result[0]['Allowance']+' บาท';
    //     document.getElementById("AllowanceDisaster").innerHTML = 'ค่าเลี้ยงภัย : '+result[0]['AllowanceDisaster']+' บาท';
    //     document.getElementById("AllowanceSafety").innerHTML = 'เบี้ยเลี้ยงเซตตี้ : '+result[0]['AllowanceSafety']+' บาท';
    //     document.getElementById("SpecialAllowance").innerHTML = 'เบี้ยเลี้ยงพิเศษ : '+result[0]['SpecialAllowance']+' บาท';
    //     document.getElementById("Bank").innerHTML = 'การรับเงิน : '+Choice;
    //     document.getElementById("BankDetail").innerHTML = 'ธนาคาร : '+result[0]['Bank_Name'];
    //     document.getElementById("BankDetail2").innerHTML = 'สาขา : '+result[0]['BankBranch'];
    //     document.getElementById("BankDetail3").innerHTML = 'เลขบัญชี : '+result[0]['AccountNumber'];
    //     document.getElementById("Social").innerHTML = 'ประกันสังคม : '+ social;
    //     document.getElementById("InformIn").innerHTML = 'แจ้งเข้า : '+result[0]['Inform'];
    //     document.getElementById("InformOut").innerHTML = 'แจ้งออก : '+result[0]['Notice'];
    //     document.getElementById("Hospital").innerHTML = 'สถานพยาบาล : '+result[0]['Hos_name'];
    // }

    tpoly.StartClock24 = function() {
        TheTime = new Date;
        m = TheTime.getMonth();
        y = TheTime.getFullYear();
        m = (parseInt(m)+1);
        y = (parseInt(y)+543);
        document.getElementById("showTime").innerHTML = TheTime.getDate()+' / '+m+' / '+y+'  '+tpoly.showFilled(TheTime.getHours()) + ":" +
        tpoly.showFilled(TheTime.getMinutes()) + ":" + tpoly.showFilled(TheTime.getSeconds());
        setTimeout("tpoly.StartClock24()",1000)
    }

    tpoly.showFilled = function(Value) {
        return (Value > 9) ? "" + Value : "0" + Value;
    }
}( jQuery ));