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

    tpoly.employee.page = function() {
        p = $('#employeePage').val();

        id1 = $("#tab1").attr("class");
        id2 = $("#tab2").attr("class");
        id3 = $("#tab3").attr("class");

        if(id1 == 'active'){
            status = 'W';
        }
        if(id2 == 'active'){
            status = 'O';
        }
        if(id3 == 'active'){
            status = 'B';
        }

        tpoly.employee.loadEmployee('', p, status);
    }

    tpoly.employee.setStatus = function(status) {
        if(status == 'W') {
            $('#employeePage').val(10);
        }
        if(status == 'O') {
            $('#employeePage').val(10);
        }
        if(status == 'B') {
            $('#employeePage').val(10);
        }

        tpoly.employee.loadEmployee('', 10, status);
    }

    tpoly.employee.setSearch = function(obj) {
        vv = $(obj).val();

        p = $('#employeePage').val();

        id1 = $("#tab1").attr("class");
        id2 = $("#tab2").attr("class");
        id3 = $("#tab3").attr("class");

        if(id1 == 'active'){
            status = 'W';
        }
        if(id2 == 'active'){
            status = 'O';
        }
        if(id3 == 'active'){
            status = 'B';
        }

        tpoly.employee.loadEmployee(vv, p, status);
    }

    tpoly.employee.setPageSline = function(value) {

        p = $('#employeePage').val();

        id1 = $("#tab1").attr("class");
        id2 = $("#tab2").attr("class");
        id3 = $("#tab3").attr("class");

        if(id1 == 'active'){
            status = 'W';
        }
        if(id2 == 'active'){
            status = 'O';
        }
        if(id3 == 'active'){
            status = 'B';
        }

        tpoly.employee.loadEmployee('', p, status, value);
    }

    tpoly.employee.loadEmployee = function(obj, page, status, value) {
        // console.log(obj+'--'+page+'--'+status+'--'+value);
        vv = obj;
        tpoly.employee.Criteria['name'] = '';
        tpoly.employee.Criteria['id'] = '';

        if(status == undefined) {
            status = 'W';
        }

        if(page == undefined || page == '') {
            page = $('#employeePage').val();
        }

        if(vv != undefined || vv != '') {
            if(isNaN(vv)) {
                tpoly.employee.Criteria['name'] = vv;
            } else {
                tpoly.employee.Criteria['id'] = vv;
            }

        }

        tpoly.employee.Criteria['mode'] = 'loadTest';
        tpoly.employee.Criteria['page'] = page;
        tpoly.employee.Criteria['status'] = status;
        tpoly.employee.Criteria['site'] = '';
        tpoly.employee.Criteria['num'] = value;
        
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
            if(resultSearch == '') {
                html += '<tr>';
                html += '<td colspan="6" style="text-align: center;">Data Not Found</td>';
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
            beforeSend: function() {
                tpoly.popup('loading');
            }
        };

        var get_ajax = $.ajax(ajax_config);
        get_ajax.done(function(response) {
            tpoly.num = response;
            resultNum = tpoly.num;

            num = tpoly.employee.Criteria['num'];
            limitP = tpoly.employee.Criteria['page'];

            start = (num > 1) ? (((num - 1) * limitP) + 1) : 1;
            if(resultNum < 10) {
                end = resultNum;
            } else {
                end = (num > 1) ? (limitP * num) : limitP;
            }

            var ListPage = $('#ListPage');
            var p = 1;
            var s = 1;

            totalPage = Math.ceil(resultNum / limitP);

            if(num == undefined) {
                num = 1;
            }

            var html = '';
            html += '<br>';
            html += '<span>ข้อมูลจาก '+ start +' ถึง '+ end +' จากทั้งหมด '+ resultNum +' รายการ</span>';
            html += '<div class="dataTables_paginate paging_simple_numbers">';
            html += '<ul class="pagination">';
            if(totalPage <= 10) {
                if(num > 1) {
                    html += '<li id="employsearch-page-pre" class="paginate_button previous" onClick="tpoly.employee.setPageSline('+(num-1)+');">';
                } else {
                    html += '<li id="employsearch-page-pre" class="paginate_button previous disabled" onClick="tpoly.employee.setPageSline();">';
                }
                html += '<a href="#">Previous</a>';
                html += '</li>';
                for(p;p<=totalPage;p++){
                    if(p == num) {
                        html += '<li class="paginate_button active" onClick="tpoly.employee.setPageSline('+p+');">';
                    } else {
                        html += '<li class="paginate_button" onClick="tpoly.employee.setPageSline('+p+');">';
                    }
                    html += '<a href="#">'+ p +'</a>';
                    html += '</li>';
                }
                if(num < (p-1)) {
                    html += '<li id="employsearch-page-next" class="paginate_button next" onClick="tpoly.employee.setPageSline('+(num+1)+');">';
                } else {
                    html += '<li id="employsearch-page-next" class="paginate_button next disabled">';
                }
                html += '<a href="#">Next</a>';
                html += '</li>';
            } else {
                if(num > 1) {
                    html += '<li id="employsearch-page-pre" class="paginate_button previous" onClick="tpoly.employee.setPageSline('+(num-1)+');">';
                } else {
                    html += '<li id="employsearch-page-pre" class="paginate_button previous disabled">';
                }
                html += '<a href="#">Previous</a>';
                html += '</li>';
                if(num < 5) {
                    for(s;s<=5;s++) {
                        if(s == num) {
                            html += '<li class="paginate_button active" onClick="tpoly.employee.setPageSline('+s+');">';
                        } else {
                            html += '<li class="paginate_button" onClick="tpoly.employee.setPageSline('+s+');">';
                        }
                        html += '<a href="#">'+ s +'</a>';
                        html += '</li>';
                    }
                    html += '<li class="paginate_button disabled">';
                    html += '<a href="#">...</a>';
                    html += '</li>';
                    html += '<li class="paginate_button" onClick="tpoly.employee.setPageSline('+totalPage+');">';
                    html += '<a href="#">'+totalPage+'</a>';
                    html += '</li>';
                    html += '<li id="employsearch-page-next" class="paginate_button next" onClick="tpoly.employee.setPageSline('+(num+1)+');">';
                    html += '<a href="#">Next</a>';
                    html += '</li>';
                }
                if(num >= 5 && num <= (totalPage - 5)) {
                    html += '<li class="paginate_button" onClick="tpoly.employee.setPageSline(1);">';
                    html += '<a href="#">1</a>';
                    html += '</li>';
                    html += '<li class="paginate_button disabled" onClick="tpoly.employee.setPageSline('+s+');">';
                    html += '<a href="#">...</a>';
                    html += '</li>';

                    html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num-1)+');">';
                    html += '<a href="#">'+(num-1)+'</a>';
                    html += '</li>';
                    html += '<li class="paginate_button active" onClick="tpoly.employee.setPageSline('+(num)+');">';
                    html += '<a href="#">'+(num)+'</a>';
                    html += '</li>';
                    html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num+1)+');">';
                    html += '<a href="#">'+(num+1)+'</a>';
                    html += '</li>';

                    html += '<li class="paginate_button disabled" onClick="tpoly.employee.setPageSline('+s+');">';
                    html += '<a href="#">...</a>';
                    html += '</li>';
                    html += '<li class="paginate_button" onClick="tpoly.employee.setPageSline('+totalPage+');">';
                    html += '<a href="#">'+totalPage+'</a>';
                    html += '</li>';
                    html += '<li id="employsearch-page-next" class="paginate_button next" onClick="tpoly.employee.setPageSline('+(num+1)+');">';
                    html += '<a href="#">Next</a>';
                    html += '</li>';
                }
                if(num > (totalPage - 5)) {
                    html += '<li class="paginate_button" onClick="tpoly.employee.setPageSline(1);">';
                    html += '<a href="#">1</a>';
                    html += '</li>';
                    html += '<li class="paginate_button disabled" onClick="tpoly.employee.setPageSline('+s+');">';
                    html += '<a href="#">...</a>';
                    html += '</li>';
                    if(num == (totalPage - 5)) {
                        html += '<li class="paginate_button active" onClick="tpoly.employee.setPageSline('+num+');">';
                        html += '<a href="#">'+num+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num+1)+');">';
                        html += '<a href="#">'+(num+1)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num+2)+');">';
                        html += '<a href="#">'+(num+2)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num+3)+');">';
                        html += '<a href="#">'+(num+3)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num+4)+');">';
                        html += '<a href="#">'+(num+4)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num+5)+');">';
                        html += '<a href="#">'+(num+5)+'</a>';
                        html += '</li>';
                        html += '<li id="employsearch-page-next" class="paginate_button next" onClick="tpoly.employee.setPageSline('+(num+1)+');">';
                        html += '<a href="#">Next</a>';
                        html += '</li>';
                    }
                    if(num == (totalPage - 4)) {
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num-1)+');">';
                        html += '<a href="#">'+(num-1)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button active" onClick="tpoly.employee.setPageSline('+num+');">';
                        html += '<a href="#">'+num+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num+1)+');">';
                        html += '<a href="#">'+(num+1)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num+2)+');">';
                        html += '<a href="#">'+(num+2)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num+3)+');">';
                        html += '<a href="#">'+(num+3)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num+4)+');">';
                        html += '<a href="#">'+(num+4)+'</a>';
                        html += '</li>';
                        html += '<li id="employsearch-page-next" class="paginate_button next" onClick="tpoly.employee.setPageSline('+(num+1)+');">';
                        html += '<a href="#">Next</a>';
                        html += '</li>';
                    }
                    if(num == (totalPage - 3)) {
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num-2)+');">';
                        html += '<a href="#">'+(num-2)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num-1)+');">';
                        html += '<a href="#">'+(num-1)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button active" onClick="tpoly.employee.setPageSline('+num+');">';
                        html += '<a href="#">'+num+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num+1)+');">';
                        html += '<a href="#">'+(num+1)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num+2)+');">';
                        html += '<a href="#">'+(num+2)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num+3)+');">';
                        html += '<a href="#">'+(num+3)+'</a>';
                        html += '</li>';
                        html += '<li id="employsearch-page-next" class="paginate_button next" onClick="tpoly.employee.setPageSline('+(num+1)+');">';
                        html += '<a href="#">Next</a>';
                        html += '</li>';
                    }
                    if(num == (totalPage - 2)) {
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num-3)+');">';
                        html += '<a href="#">'+(num-3)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num-2)+');">';
                        html += '<a href="#">'+(num-2)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num-1)+');">';
                        html += '<a href="#">'+(num-1)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button active" onClick="tpoly.employee.setPageSline('+num+');">';
                        html += '<a href="#">'+num+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num+1)+');">';
                        html += '<a href="#">'+(num+1)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num+2)+');">';
                        html += '<a href="#">'+(num+2)+'</a>';
                        html += '</li>';
                        html += '<li id="employsearch-page-next" class="paginate_button next" onClick="tpoly.employee.setPageSline('+(num+1)+');">';
                        html += '<a href="#">Next</a>';
                        html += '</li>';
                    }
                    if(num == (totalPage - 1)) {
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num-4)+');">';
                        html += '<a href="#">'+(num-4)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num-3)+');">';
                        html += '<a href="#">'+(num-3)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num-2)+');">';
                        html += '<a href="#">'+(num-2)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num-1)+');">';
                        html += '<a href="#">'+(num-1)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button active" onClick="tpoly.employee.setPageSline('+num+');">';
                        html += '<a href="#">'+num+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num+1)+');">';
                        html += '<a href="#">'+(num+1)+'</a>';
                        html += '</li>';
                        html += '<li id="employsearch-page-next" class="paginate_button next" onClick="tpoly.employee.setPageSline('+(num+1)+');">';
                        html += '<a href="#">Next</a>';
                        html += '</li>';
                    }
                    if(num == totalPage) {
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num-5)+');">';
                        html += '<a href="#">'+(num-5)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num-4)+');">';
                        html += '<a href="#">'+(num-4)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num-3)+');">';
                        html += '<a href="#">'+(num-3)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num-2)+');">';
                        html += '<a href="#">'+(num-2)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button " onClick="tpoly.employee.setPageSline('+(num-1)+');">';
                        html += '<a href="#">'+(num-1)+'</a>';
                        html += '</li>';
                        html += '<li class="paginate_button active" onClick="tpoly.employee.setPageSline('+num+');">';
                        html += '<a href="#">'+num+'</a>';
                        html += '</li>';
                        html += '<li id="employsearch-page-next" class="paginate_button next disabled">';
                        html += '<a href="#">Next</a>';
                        html += '</li>';
                    }
                }
            }
            html += '</ul>';
            html += '</div>';

            ListPage.html(html);
            tpoly.popup('close');
        });
    }

    tpoly.StartClock24 = function() {
        TheTime = new Date;

        d = TheTime.getDate();
        m = TheTime.getMonth();
        y = TheTime.getFullYear();
        h = tpoly.showFilled(TheTime.getHours());
        i = tpoly.showFilled(TheTime.getMinutes());
        s = tpoly.showFilled(TheTime.getSeconds());

        m = (parseInt(m)+1);
        y = (parseInt(y)+543);

        document.getElementById("showTime").innerHTML = d+' / '+m+' / '+y+'  '+h+ ":" + i + ":" + s;
        setTimeout("tpoly.StartClock24()",1000);
    }

    tpoly.showFilled = function(Value) {
        return (Value > 9) ? "" + Value : "0" + Value;
    }
}( jQuery ));