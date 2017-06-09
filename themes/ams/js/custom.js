// JavaScript Document

$(document).ready(function () {

    $('#calendar').fullCalendar({
        editable: true,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: "index.php?r=admin/hospitalUnit/events&hospital_unit_id=" + $("#hospital_unit_id").val(),
        aspectRatio: 2.2,
        timeFormat: 'H:mm',
        contentHeight: 600,
        theme: true,
        nextDayThreshold: "00:00:00"
    });

//    $(".fc-next-button").trigger('click')
//    {
//        $('#calendar').fullCalendar({
//            editable: true,
//            header: {
//                left: 'prev,next today',
//                center: 'title',
//                right: 'month,agendaWeek,agendaDay'
//            },
//            events: "index.php?r=admin/hospitalUnit/events&hospital_unit_id=" + $("#hospital_unit_id").val(),
//            aspectRatio: 2.2,
//            timeFormat: 'H:mm',
//            contentHeight: 600,
//            theme: true,
//            nextDayThreshold: "00:00:00"
//        });
//    }

    var frontEndUrl = 'http://localhost/hospital-shift-schedule/';
    $("#hospital-registration-form").submit(function () {
        var hospital_group_name = $("#HospitalRegistration_hospital_name").val();
        var errorFlag = false;
        var pattern = /^([A-Z])+(([a-zA-Z0-9\s])+)+$/;
        if (hospital_group_name == '') {
            $("#hospital_group_name_err").html("Please enter hospital group name!").show();
            ;
            errorFlag = true;
        } else if (hospital_group_name.length >= 1 && hospital_group_name.length < 4) {
            $("#hospital_group_name_err").html('Hospital group name should be greater than 4 characters!').show();
            ;
            errorFlag = true;
        } else if (!pattern.test(hospital_group_name)) {
            $("#hospital_group_name_err").html('First character should be capital!').show();
            ;
            errorFlag = true;
        }

        if (errorFlag == true) {
            return false;
        } else {
            $("#hospital-registration-form").submit();
        }
    });
    var count = 1;
    $("#add-more").on('click', function () {
        count++;
        $('.shiftRow:last').clone(false)
                .find("input:text").val("").end()
                .appendTo('#shiftDiv');

        $('.shiftRow:last').find('input.datefieldfirst')
                .attr("id", "shift_start_datetime_" + count)
                .removeClass('hasDatepicker')
                .unbind()
                .datetimepicker({'timeFormat': 'hh:mm',
                    'dateFormat': 'dd-mm-yy',
                    'changeMonth': true,
                    'changeYear': false,
                    'minDate': 'today'});
        $('[name^=shift_start_datetime_]:last').attr('name', 'shift_start_datetime_' + count);

        $('.shiftRow:last').find('input.datefieldend')
                .attr("id", "shift_end_datetime_" + count)
                .removeClass('hasDatepicker')
                .unbind()
                .datetimepicker({'timeFormat': 'hh:mm',
                    'dateFormat': 'dd-mm-yy',
                    'changeMonth': true,
                    'changeYear': false,
                    'minDate': 'today'});
        $('[name^=shift_end_datetime_]:last').attr('name', 'shift_end_datetime_' + count);
        $('[id^=ward_]:last').attr('id', 'ward_' + count);
        $('[id^=quantity_]:last').attr('id', 'quantity_' + count);
        $('[id^=notes_]:last').attr('id', 'notes_' + count);
        $('[id^=jobType_]:last').attr('id', 'jobType_' + count);

        if (count == 2) {
            $('#notes_' + count).parent().after('<td><span id="remove_shift_2"> <a href="javascript:void(*=0)">Remove</a></td>')
        }

        $('[id^=remove_shift_]:last').attr('id', 'remove_shift_' + count).bind('click', function () {
            $(this).parent().parent().remove();
        });
        $('.shiftRow:last').find("span.errorMessage").html("").end()
    });
    $("#shift-management-for-hospital-form").submit(function () {
        var hospital_unit = $("#hospital_unit_id").val();
        var ward = $("#ShiftManagementForHospital_ward_id").val();
        var job_type = $("#ShiftManagementForHospital_job_type_id").val();
        var quantity = $("#ShiftManagementForHospital_quantity").val();
        var shift_start_datetime = $("#shift_start_datetime").val();
        var shift_end_datetime = $("#shift_end_datetime").val();
        var requested_date = $("#requested_date").val();
        var requested_time = $("#requested_time").val();
        var requested_person = $("#requested_person").val();
        var request_accepted_by = $("#request_accepted_by").val();
        var requested_person_mobile_number = $("#requested_person_mobile_number").val();

        var errorFlag = false;
        $("#hospital_name_error").html('');
        $("#ward_error").html('');
        $("#job_type_error").html('');
        $("#quantity_error").html('');
        $("#shift_start_datetime_error").html('');
        $("#shift_end_datetime_error").html('');
        $("#requested_date_error").html('');
        $("#requested_time_error").html('');
        $("#requested_person_error").html('');
        $("#request_accepted_by_error").html('');
        $("#requested_person_mobile_number_error").html('');

        if (hospital_unit == '') {
            $("#hospital_name_error").html("Please enter hospital name!").show();
            ;
            errorFlag = true;
        }
        if (ward == '') {
            $("#ward_error").html("Please select ward!").show();
            ;
            errorFlag = true;
        }
        if (job_type == '') {
            $("#job_type_error").html("Please select job type!").show();
            ;
            errorFlag = true;
        }
        if (quantity == '' || quantity == '0') {
            $("#quantity_error").html("Please enter quantity!").show();
            ;
            errorFlag = true;
        } else if (quantity != '') {
            var pat = /^[1-9][0-9]*$/;
            if (!pat.test(quantity)) {
                $("#quantity_error").html("Please enter valid quantity!").show();
            }
        }
        if (shift_start_datetime == '') {
            $("#shift_start_datetime_error").html("Please enter shift start date!").show();
            ;
            errorFlag = true;
        } else if (shift_start_datetime != '' && $("#isNewRec").val() == '') {
            var today1 = new Date();
            var toDateSecs1 = today1.getTime();
            var shiftStartDatetimeArr1 = shift_start_datetime.split(' ');
            var shiftStartDate1 = shiftStartDatetimeArr1[0];
            var shiftStartDateArr1 = shiftStartDate1.split('-')
            var shiftStartDateSecs1 = new Date(shiftStartDateArr1[2] + '/' + shiftStartDateArr1[1] + '/' + shiftStartDateArr1[0] + ' ' + shiftStartDatetimeArr1[1]).getTime();
            if (shiftStartDateSecs1 < toDateSecs1) {
                $("#shift_start_datetime_error").html("Shift start date should be greater than or equal to today!").show();
                ;
                errorFlag = true;
            }
        }

        if (shift_end_datetime == '') {
            $("#shift_end_datetime_error").html("Please enter shift end date!").show();
            ;
            errorFlag = true;
        } else if (shift_end_datetime != '' && $("#isNewRec").val() == '') {

            var today = new Date();
            var toDateSecs = today.getTime();
            var shiftStartDatetimeVal = shift_start_datetime;
            var shiftStartDatetimeArr = shiftStartDatetimeVal.split(' ');
            var shiftStartDate = shiftStartDatetimeArr[0];
            var shiftStartTime = shiftStartDatetimeArr[1];
            var shiftStartDateArr = shiftStartDate.split('-');
            var shiftStartTimeArr = shiftStartTime.split(':');
            var shiftStDt = shiftStartDateArr[2] + '/' + shiftStartDateArr[1] + '/' + shiftStartDateArr[0] + ' ' + shiftStartTime;
            var shiftStartDateSecs = new Date(shiftStDt).getTime();

            var shiftEndDatetimeVal = shift_end_datetime;
            var shiftEndDatetimeArr = shiftEndDatetimeVal.split(' ');
            var shiftEndDate = shiftEndDatetimeArr[0];
            var shiftEndTime = shiftEndDatetimeArr[1];
            var shiftEndDateArr = shiftEndDate.split('-');
            var shiftEndTimeArr = shiftEndTime.split(':');
            var shiftEndDt = shiftEndDateArr[2] + '/' + shiftEndDateArr[1] + '/' + shiftEndDateArr[0] + ' ' + shiftEndTime;
            var shiftEndDateSecs = new Date(shiftEndDt).getTime();
            if (shiftStartDateSecs > shiftEndDateSecs) {
                $("#shift_end_datetime_error").html('Shift end time should greater than shift start time');
                errorFlag = true;
            } else if (shiftEndDateSecs < toDateSecs) {

                $("#shift_end_datetime_error").html("Shift end date should be greater than or equal to today!").show();
                ;
                errorFlag = true;
            } else {
                $("#shift_end_datetime_error").html('');
            }
        }

        if (requested_date == '') {
            $("#requested_date_error").html("Please enter requested date!").show();
            ;
            errorFlag = true;
        }

        if (requested_time == '') {
            $("#requested_time_error").html("Please enter requested time!").show();
            errorFlag = true;
        }
        if (requested_person == '') {
            $("#requested_person_error").html("Please enter requested person name!").show();
            errorFlag = true;
        }
        if (request_accepted_by == '') {
            $("#request_accepted_by_error").html("Please select request accepted person name!").show();
            errorFlag = true;
        }
        if (requested_person_mobile_number == '') {
            $("#requested_person_mobile_number_error").html("Please enter mobile number!").show();
            errorFlag = true;
        }
        if ($("#isNewRec").val() == '1') {
            var shiftStartDatetimeCnt = 0;
            $(".datefieldfirst").each(function () {
                shiftStartDatetimeCnt++;
                var shiftStartDatetimeId = $("#shift_start_datetime_" + shiftStartDatetimeCnt);
                if (shiftStartDatetimeId.val() == '') {
                    shiftStartDatetimeId.next('.shiftStartTime').html('Please enter shift start time');
                    errorFlag = true;
                } else if (shiftStartDatetimeId.val() != '') {
                    var today = new Date();

                    var toDateSecs = today.getTime();
                    var shiftStartDatetimeArr = shiftStartDatetimeId.val().split(' ');
                    var shiftStartDate = shiftStartDatetimeArr[0];
                    var shiftStartDateArr = shiftStartDate.split('-')
                    var shiftStartDateSecs = new Date(shiftStartDateArr[2] + '/' + shiftStartDateArr[1] + '/' + shiftStartDateArr[0] + ' ' + shiftStartDatetimeArr[1]).getTime();

                    if (shiftStartDateSecs < toDateSecs) {
                        alert(shiftStartDateSecs + '=' + toDateSecs);
                        shiftStartDatetimeId.next('.shiftStartTime').html("Shift start date should be greater than or equal to today!").show();
                        errorFlag = true;
                    } else {
                        shiftStartDatetimeId.next('.shiftStartTime').html("");

                    }
                } else {
                    shiftStartDatetimeId.next('.shiftStartTime').html('');
                }
            });

            var shiftEndDatetimeCnt = 0;
            $(".datefieldend").each(function () {
                shiftEndDatetimeCnt++;
                var shiftStartDatetimeId = $("#shift_start_datetime_" + shiftEndDatetimeCnt);
                var shiftEndDatetimeId = $("#shift_end_datetime_" + shiftEndDatetimeCnt);

                if (shiftEndDatetimeId.val() == '') {
                    shiftEndDatetimeId.next('.shiftEndTime').html('Please enter shift end time');
                    errorFlag = true;
                } else if (shiftEndDatetimeId.val() != '') {

                    var today = new Date();
                    var toDateSecs = today.getTime();
                    var shiftStartDatetimeVal = shiftStartDatetimeId.val();
                    var shiftStartDatetimeArr = shiftStartDatetimeVal.split(' ');
                    var shiftStartDate = shiftStartDatetimeArr[0];
                    var shiftStartTime = shiftStartDatetimeArr[1];
                    var shiftStartDateArr = shiftStartDate.split('-');
                    var shiftStartTimeArr = shiftStartTime.split(':');
                    var shiftStDt = shiftStartDateArr[2] + '/' + shiftStartDateArr[1] + '/' + shiftStartDateArr[0] + ' ' + shiftStartTime;
                    var shiftStDts = shiftStartDateArr[2] + '-' + shiftStartDateArr[1] + '-' + shiftStartDateArr[0] + ' ' + shiftStartTime;
                    var shiftStartDateSecs = new Date(shiftStDt).getTime();

                    var shiftEndDatetimeVal = shiftEndDatetimeId.val();
                    var shiftEndDatetimeArr = shiftEndDatetimeVal.split(' ');
                    var shiftEndDate = shiftEndDatetimeArr[0];
                    var shiftEndTime = shiftEndDatetimeArr[1];
                    var shiftEndDateArr = shiftEndDate.split('-');
                    var shiftEndTimeArr = shiftEndTime.split(':');
                    var shiftEndDt = shiftEndDateArr[2] + '/' + shiftEndDateArr[1] + '/' + shiftEndDateArr[0] + ' ' + shiftEndTime;
                    var shiftEndDts = shiftEndDateArr[2] + '-' + shiftEndDateArr[1] + '-' + shiftEndDateArr[0] + ' ' + shiftEndTime;
                    var shiftEndDateSecs = new Date(shiftEndDt).getTime();
                    /*
                     * 
                     * @ Code for time diff of start and end time
                     */
                    var getshiftStartDateTime = new Date(shiftStDts);
                    var getshiftEndDateTime = new Date(shiftEndDts);

                    var hours = (((getshiftEndDateTime - getshiftStartDateTime) / 1000) / 3600);
                    /*
                     * end of code
                     */
                    if (shiftStartDateSecs > shiftEndDateSecs) {
                        shiftEndDatetimeId.next('.shiftEndTime').html('Shift end time should greater than shift start time');
                        errorFlag = true;
                    } else if (shiftEndDateSecs < toDateSecs) {
                        shiftEndDatetimeId.next('.shiftEndTime').html("Shift end date should be greater than or equal to today!").show();
                        errorFlag = true;
                    } else if (hours > 13) {
                        shiftEndDatetimeId.next('.shiftEndTime').html("Shift end time should be less than or equal to 13 hours from start time!").show();
                        errorFlag = true;
                    } else {
                        shiftEndDatetimeId.next('.shiftEndTime').html('');
                    }

                } else {
                    shiftEndDatetimeId.next('.shiftEndTime').html('');
                }

            });
            var wardCnt = 0;
            $(".wardcls").each(function () {
                wardCnt++;
                var wardId = $("#ward_" + wardCnt);
                if (wardId.val() == '') {
                    wardId.next('.ward').html('Please select ward');
                    errorFlag = true;
                } else {
                    //errorFlag = false;
                    wardId.next('.ward').html('');
                }

            });
            var jobTypeCnt = 0;
            $(".jobtypecls").each(function () {
                jobTypeCnt++;
                var jobTypeId = $("#jobType_" + jobTypeCnt);
                if (jobTypeId.val() == '') {
                    jobTypeId.next('.job-type').html('Please select job type');
                    errorFlag = true;
                } else {
                    jobTypeId.next('.job-type').html('');
                }
            });
            var quantityCnt = 0;
            $(".quantitycls").each(function () {
                quantityCnt++;
                var quantityId = $("#quantity_" + quantityCnt);
                if (quantityId.val() == '') {
                    quantityId.next('.quantity').html('Please enter quantity');
                    errorFlag = true;
                } else if (quantityId.val() != '') {
                    var pat = /^[1-9][0-9]*$/;
                    if (!pat.test(parseInt(quantityId.val()))) {
                        quantityId.next('.quantity').html('Please enter valid quantity');
                        errorFlag = true;
                    } else {
                        quantityId.next('.quantity').html('');
                    }
                } else {
                    quantityId.next('.quantity').html('');
                }
            });
        }

        if (errorFlag == true) {
            return false;
        } else {
            $("#hospital-registration-form").submit();
        }
    });


    $("#hospital_unit_id").change(function () {
        $.ajax({url: "index.php?r=admin/shiftManagementForHospital/getContactNumberForHospital",
            data: {hospital_unit_id: $("#hospital_unit_id").val()},
            type: 'POST',
            success: function (result) {
                console.log(result);
                $("#requested_person_mobile_number").val(result);
            }});

        $.ajax({url: "index.php?r=admin/shiftManagementForHospital/getWardForHospital",
            data: {hospital_unit_id: $("#hospital_unit_id").val()},
            type: 'POST',
            success: function (result) {
                console.log(result);
                $("#ward_id option").remove();
                $("#ward_id").append(result);
            }});
    });
    $("#booking-management-for-hospital-form").submit(function () {
        var checked = false;
        $("#error").html("");
        $("input.staffIdChk").each(function (index, element) {
            if (element.checked) {
                checked = true;
            }
        });
        if (checked == false) {
            $("#error").html("Please check a staff first");
            return false;
        }
    });

    $("#booking-management-for-hospital").submit(function () {
        var checked = false;
        $("#error").html("");
        var count = 0;
        $("input.staffIdChk").each(function (index, element) {
            if (element.checked) {
                count++;
                checked = true;
            }
        });
        if (checked == false) {
            $("#error").html("Please check a shift first!!");
            return false;
        }
        if ((checked == true) && (count > 5)) {
            $("#error").html("Please check maximum 5 shift!!");
            return false;
        }
    });
    //$("#checkUncheckAll").change(function () {
    $(document).on('click', '#checkUncheckAll', function () {
        $(".staffIdChk").prop('checked', $(this).prop("checked"));
    });

    /*$("[name=send_enquery]").on('click', function() {
     if($(this).parent().parent().find('td:eq(0) input').prop("checked") == true){
     $(".staffIdChk").attr('checked', false);
     $(this).parent().parent().find('td:eq(0) input').prop("checked", true);       
     $("#booking-management-for-hospital-form").submit();
     } else {
     $("#error").html("Please check related staff to send enquiry");
     return false;
     }
     })*/

    /*
     * Show/hide for report section
     */

    $("#dbs").show();
    $("#visa").hide();
    $("#shiftAllocation").hide();
    $("#staffAvailability").hide();
    $("#staffCancelReport").hide();
    $("#notAllocatedStaffReport").hide();
    $("#rotaReport").hide();
    $("#serviceDetailsForAnyHospital").hide();
    $("#staffRota").hide();
    $("#cExpiry").click(function () {
        $("#dbs").show();
        $("#visa").hide();
        $("#shiftAllocation").hide();
        $("#staffAvailability").hide();
        $("#staffCancelReport").hide();
        $("#notAllocatedStaffReport").hide();
        $("#rotaReport").hide();
        $("#serviceDetailsForAnyHospital").hide();
        $("#staffRota").hide();
    });
    $("#cVisa").click(function () {
        $("#dbs").hide();
        $("#visa").show();
        $("#shiftAllocation").hide();
        $("#staffAvailability").hide();
        $("#staffCancelReport").hide();
        $("#notAllocatedStaffReport").hide();
        $("#rotaReport").hide();
        $("#serviceDetailsForAnyHospital").hide();
        $("#staffRota").hide();
    });
    $("#cShiftAllocation").click(function () {
        $("#dbs").hide();
        $("#visa").hide();
        $("#shiftAllocation").show();
        $("#staffAvailability").hide();
        $("#staffCancelReport").hide();
        $("#notAllocatedStaffReport").hide();
        $("#rotaReport").hide();
        $("#serviceDetailsForAnyHospital").hide();
        $("#staffRota").hide();
    });
    $("#cStaffAvailability").click(function () {
        $("#dbs").hide();
        $("#visa").hide();
        $("#shiftAllocation").hide();
        $("#staffAvailability").show();
        $("#staffCancelReport").hide();
        $("#notAllocatedStaffReport").hide();
        $("#rotaReport").hide();
        $("#serviceDetailsForAnyHospital").hide();
        $("#staffRota").hide();
    });
    $("#cStaffCancelReport").click(function () {
        $("#dbs").hide();
        $("#visa").hide();
        $("#shiftAllocation").hide();
        $("#staffAvailability").hide();
        $("#staffCancelReport").show();
        $("#notAllocatedStaffReport").hide();
        $("#rotaReport").hide();
        $("#serviceDetailsForAnyHospital").hide();
        $("#staffRota").hide();
    });
    $("#cNotAllocatedStaffReport").click(function () {
        $("#dbs").hide();
        $("#visa").hide();
        $("#shiftAllocation").hide();
        $("#staffAvailability").hide();
        $("#staffCancelReport").hide();
        $("#notAllocatedStaffReport").show();
        $("#rotaReport").hide();
        $("#serviceDetailsForAnyHospital").hide();
        $("#staffRota").hide();
    });
    $("#cRotaReport").click(function () {
        $("#dbs").hide();
        $("#visa").hide();
        $("#shiftAllocation").hide();
        $("#staffAvailability").hide();
        $("#staffCancelReport").hide();
        $("#notAllocatedStaffReport").hide();
        $("#rotaReport").show();
        $("#serviceDetailsForAnyHospital").hide();
        $("#staffRota").hide();
    });
    $("#cServiceDetailsForAnyHospital").click(function () {
        $("#dbs").hide();
        $("#visa").hide();
        $("#shiftAllocation").hide();
        $("#staffAvailability").hide();
        $("#staffCancelReport").hide();
        $("#notAllocatedStaffReport").hide();
        $("#rotaReport").hide();
        $("#serviceDetailsForAnyHospital").show();
        $("#staffRota").hide();
    });
    $("#cStaffRotaReport").click(function () {
        $("#dbs").hide();
        $("#visa").hide();
        $("#shiftAllocation").hide();
        $("#staffAvailability").hide();
        $("#staffCancelReport").hide();
        $("#notAllocatedStaffReport").hide();
        $("#rotaReport").hide();
        $("#serviceDetailsForAnyHospital").hide();
        $("#staffRota").show();
    });


    /*
     * Validations for report section 1
     */
    $("#u_contact").submit(function (e) {
        var errorFlagReport = false;
        $("#msgStartDate").empty();
        $("#msgEndDate").empty();

        if ($("#startDateDbs").val().length == 0) {
            $("#msgStartDate").empty().append("Please enter start date");
            errorFlagReport = true;
        }
        if ($("#endDateDbs").val().length == 0) {
            $("#msgEndDate").empty().append("Please enter end date");
            errorFlagReport = true;
        }
        if ($("#startDateDbs").val().length > 0 && $("#endDateDbs").val().length > 0) {
            var startDateDbsSecs = getSecsOfDate($("#startDateDbs").val());
            var endDateDbsSecs = getSecsOfDate($("#endDateDbs").val());
            if (startDateDbsSecs > endDateDbsSecs) {
                $("#msgEndDate").empty().append("End date should be greater than or equal to Start date!");
                errorFlagReport = true;
            }
        }
        if (errorFlagReport == true) {
            e.preventDefault();
        } else if (errorFlagReport == false) {
            $("#u_contact").submit();
        }
    });

    /*
     * Validations for report shift allocation
     */
    $("#u_contact2").submit(function (e) {
        var errorFlagReport = false;
        $("#msgStartDateShiftAllocation").html('').hide();
        $("#msgEndDateShiftAllocation").html('').hide();

        if ($("#startDateShiftAllocation").val().length == 0) {
            $("#msgStartDateShiftAllocation").html("Please enter start date").show();
            errorFlagReport = true;
        }
        if ($("#endDateShiftAllocation").val().length == 0) {
            $("#msgEndDateShiftAllocation").html("Please enter end date").show();
            errorFlagReport = true;
        }
        if ($("#startDateShiftAllocation").val().length > 0 && $("#endDateShiftAllocation").val().length > 0) {
            var startDateSecs = getSecsOfDate($("#startDateShiftAllocation").val());
            var endDateSecs = getSecsOfDate($("#endDateShiftAllocation").val());
            if (startDateSecs > endDateSecs) {
                $("#msgEndDateShiftAllocation").html("End date should be greater than or equal to Start date!").show();
                ;
                errorFlagReport = true;
            }

        }
        if (errorFlagReport == true) {
            e.preventDefault();
        } else if (errorFlagReport == false) {
            $("#u_contact2").submit();
        }
    });
    /*
     * Validations for report staff availability
     */
    $("#u_contact3").submit(function (e) {
        var errorFlagReport = false;
        $("#msgStaffForAvailability").html('').hide();
        $("#msgStartDateStaffAvailability").html('').hide();
        $("#msgStartTimeStaffAvailability").html('').hide();
        $("#msgEndDateStaffAvailability").html('').hide();
        $("#msgEndTimeStaffAvailability").html('').hide();
//        if ($('#selectStaffForAvailability').val() == "") {
//            $("#msgStaffForAvailability").html("Please select staff").show();
//            errorFlagReport = true;
//        }
        if ($("#startDateStaffAvailability").val().length == 0) {
            $("#msgStartDateStaffAvailability").html("Please enter start date").show();
            errorFlagReport = true;
        }
//        if ($("#startTimeStaffAvailability").val().length == 0) {
//            $("#msgStartTimeStaffAvailability").html("Please enter start time").show();
//            errorFlagReport = true;
//        }
        if ($("#endDateStaffAvailability").val().length == 0) {
            $("#msgEndDateStaffAvailability").html("Please enter end date").show();
            errorFlagReport = true;
        }
//        if ($("#endTimeStaffAvailability").val().length == 0) {
//            $("#msgEndTimeStaffAvailability").html("Please enter end time").show();
//            errorFlagReport = true;
//        }
        if ($("#startDateStaffAvailability").val().length > 0 && $("#endDateStaffAvailability").val().length > 0) {
            var startDateSecs = getSecsOfDate($("#startDateStaffAvailability").val());
            var endDateSecs = getSecsOfDate($("#endDateStaffAvailability").val());
            if (startDateSecs > endDateSecs) {
                $("#msgEndDateStaffAvailability").html("End date should be greater than or equal to Start date!").show();
                ;
                errorFlagReport = true;
            }

        }
        if (errorFlagReport == true) {
            e.preventDefault();
        } else if (errorFlagReport == false) {
            $("#u_contact3").submit();
        }
    });
    /*
     * Validations for report staff cancel by staff wise
     */
    $("#u_contact4").submit(function (e) {
        var errorFlagReport = false;
        $("#msgStaffForReport").html('').hide();
        $("#msgStartDateStaffCancelReport").html('').hide();
        $("#msgEndDateStaffCancelReport").html('').hide();

        if ($('#selectStaffForReport').val() == "") {
            $("#msgStaffForReport").html("Please select staff").show();
            errorFlagReport = true;
        }
        if ($("#startDateStaffCancelReport").val().length == 0) {
            $("#msgStartDateStaffCancelReport").html("Please enter start date").show();
            errorFlagReport = true;
        }
        if ($("#endDateStaffCancelReport").val().length == 0) {
            $("#msgEndDateStaffCancelReport").html("Please enter end date").show();
            errorFlagReport = true;
        }
        if ($("#startDateStaffCancelReport").val().length > 0 && $("#endDateStaffCancelReport").val().length > 0) {
            var startDateSecs = getSecsOfDate($("#startDateStaffCancelReport").val());
            var endDateSecs = getSecsOfDate($("#endDateStaffCancelReport").val());
            if (startDateSecs > endDateSecs) {
                $("#msgEndDateStaffCancelReport").html("End date should be greater than or equal to Start date!").show();
                ;
                errorFlagReport = true;
            }

        }
        if (errorFlagReport == true) {
            e.preventDefault();
        } else if (errorFlagReport == false) {
            $("#u_contact4").submit();
        }
    });

    /*
     * Validations for report staff non allocated
     */
    $("#u_contact5").submit(function (e) {
        var errorFlagReport = false;
        $("#msgStaffForNonAlloc").html('').hide();
        $("#msgStartDateNotAllocatedStaffReport").html('').hide();
        $("#msgEndDateNotAllocatedStaffReport").html('').hide();

        if ($('#selectStaff').val() == "") {
            $("#msgStaffForNonAlloc").html("Please select staff").show();
            errorFlagReport = true;
        }
        if ($("#startDateNotAllocatedStaffReport").val().length == 0) {
            $("#msgStartDateNotAllocatedStaffReport").html("Please enter start date").show();
            errorFlagReport = true;
        }
        if ($("#endDateNotAllocatedStaffReport").val().length == 0) {
            $("#msgEndDateNotAllocatedStaffReport").html("Please enter end date").show();
            errorFlagReport = true;
        }
        if ($("#startDateNotAllocatedStaffReport").val().length > 0 && $("#endDateNotAllocatedStaffReport").val().length > 0) {
            var startDateSecs = getSecsOfDate($("#startDateNotAllocatedStaffReport").val());
            var endDateSecs = getSecsOfDate($("#endDateNotAllocatedStaffReport").val());
            if (startDateSecs > endDateSecs) {
                $("#msgEndDateNotAllocatedStaffReport").html("End date should be greater than or equal to Start date!").show();
                ;
                errorFlagReport = true;
            }

        }
        if (errorFlagReport == true) {
            e.preventDefault();
        } else if (errorFlagReport == false) {
            $("#u_contact5").submit();
        }
    });

    /*
     * Validations for report staff cancel by staff wise
     */
    $("#u_contact6").submit(function (e) {
        var errorFlagReport = false;
        $("#msgHospitalForRota").html('').hide();
        $("#msgStartDateRotaReport").html('').hide();
        $("#msgEndDateRotaReport").html('').hide();

        if ($('#selectHospital').val() == null) {
            $("#msgHospitalForRota").html("Please select hospital").show();
            errorFlagReport = true;
        }
        if ($("#startDateRotaReport").val().length == 0) {
            $("#msgStartDateRotaReport").html("Please enter start date").show();
            errorFlagReport = true;
        }
        if ($("#endDateRotaReport").val().length == 0) {
            $("#msgEndDateRotaReport").html("Please enter end date").show();
            errorFlagReport = true;
        }
        if ($("#startDateRotaReport").val().length > 0 && $("#endDateRotaReport").val().length > 0) {
            var startDateSecs = getSecsOfDate($("#startDateRotaReport").val());
            var endDateSecs = getSecsOfDate($("#endDateRotaReport").val());
            if (startDateSecs > endDateSecs) {
                $("#msgEndDateRotaReport").html("End date should be greater than or equal to Start date!").show();
                ;
                errorFlagReport = true;
            }
        }
        if (errorFlagReport == true) {
            e.preventDefault();
        } else if (errorFlagReport == false) {
            $("#u_contact6").submit();
        }
    });

    /*
     * Validations for report staff cancel by staff wise
     */
    $("#u_contact7").submit(function (e) {
        var errorFlagReport = false;
        $("#msgHospitalForService").html('').hide();
        $("#msgStartDateServiceDetailsForAnyHospital").html('').hide();
        $("#msgEndDateServiceDetailsForAnyHospital").html('').hide();

        if ($('#selectHospitalForService').val() == "") {
            $("#msgHospitalForService").html("Please select hospital").show();
            errorFlagReport = true;
        }
        if ($("#startDateServiceDetailsForAnyHospital").val().length == 0) {
            $("#msgStartDateServiceDetailsForAnyHospital").html("Please enter start date").show();
            errorFlagReport = true;
        }
        if ($("#endDateServiceDetailsForAnyHospital").val().length == 0) {
            $("#msgEndDateServiceDetailsForAnyHospital").html("Please enter end date").show();
            errorFlagReport = true;
        }
        if ($("#startDateServiceDetailsForAnyHospital").val().length > 0 && $("#endDateServiceDetailsForAnyHospital").val().length > 0) {
            var startDateSecs = getSecsOfDate($("#startDateServiceDetailsForAnyHospital").val());
            var endDateSecs = getSecsOfDate($("#endDateServiceDetailsForAnyHospital").val());
            if (startDateSecs > endDateSecs) {
                $("#msgEndDateServiceDetailsForAnyHospital").html("End date should be greater than or equal to Start date!").show();
                ;
                errorFlagReport = true;
            }

        }
        if (errorFlagReport == true) {
            e.preventDefault();
        } else if (errorFlagReport == false) {
            $("#u_contact7").submit();
        }
    });

    /*
     * Validations for report staff cancel by staff wise
     */
    $("#u_contact8").submit(function (e) {
        var errorFlagReport = false;
        $("#msgStaffEmail").html('').hide();
        $("#msgStartDateServiceDetailsForAnyStaff").html('').hide();
        $("#msgEndDateServiceDetailsForAnyStaff").html('').hide();
        var email = $('#selectStaffEmail').val();
        if ($('#selectStaffEmail').val() == "") {
            $("#msgStaffEmail").html("Please enter staff email").show();
            errorFlagReport = true;
        }
//        else {
//            $.ajax({url: "index.php?r=admin/default/checkemail&emailid=" + email, success: function (result) {
//                    $("#msgStaffEmail").html(result).show();                   
//                }});
//        }
        if ($("#startDateForStaffRota").val().length == 0) {
            $("#msgStartDateServiceDetailsForAnyStaff").html("Please enter start date").show();
            errorFlagReport = true;
        }
        if ($("#endDateForStaffRota").val().length == 0) {
            $("#msgEndDateServiceDetailsForAnyStaff").html("Please enter end date").show();
            errorFlagReport = true;
        }
        if ($("#startDateForStaffRota").val().length > 0 && $("#endDateForStaffRota").val().length > 0) {
            var startDateSecs = getSecsOfDate($("#startDateForStaffRota").val());
            var endDateSecs = getSecsOfDate($("#endDateForStaffRota").val());
            if (startDateSecs > endDateSecs) {
                $("#msgEndDateServiceDetailsForAnyStaff").html("End date should be greater than or equal to Start date!").show();
                ;
                errorFlagReport = true;
            }

        }
        if (errorFlagReport == true) {
            e.preventDefault();
        } else if (errorFlagReport == false) {
            $("#u_contact8").submit();
        }
    });

    /*
     * Starting function for Drag and drop on Hospital Unit page
     */

    $('.box div').draggable({
        helper: 'clone'
    });

    $('.fc-day').droppable({
        tolerance: 'pointer',
        drop: function (event, ui) {
            var id = $(ui.draggable).attr('id');
            var date = $(this).attr('data-date');
            /*
             * 
             * @param {type} sParam
             * @returns {custom_L3.customAnonym$6.drop.getUrlParameter.sParameterName|Boolean}
             */
            var getUrlParameter = function getUrlParameter(sParam) {
                var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                        sURLVariables = sPageURL.split('&'),
                        sParameterName,
                        i;

                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split('=');

                    if (sParameterName[0] === sParam) {
                        return sParameterName[1] === undefined ? true : sParameterName[1];
                    }
                }
            };
            var getHospitalId = getUrlParameter('id');

            /*
             * End of function
             */

            $.ajax({
                url: 'index.php?r=admin/shiftManagementForHospital/getDragStaffDetails',
                type: 'GET',
                data: {
                    'id': id,
                    'date': date,
                    'hospitalId': getHospitalId
                },
                'success': function (data) {
                    data = jQuery.parseJSON(data);
                    $("#staffDetails").html("Staff : " + data[0].staff_name + " (" + data[0].staff_email + ")");

                    var staffEmail = document.getElementById('staffDetails');
                    var staff_email = document.createElement("input");
                    staff_email.setAttribute("type", "hidden");
                    staff_email.setAttribute("name", "staff_email_id");
                    staff_email.setAttribute("value", data[0].staff_email);
                    staffEmail.appendChild(staff_email);

                    var output = document.getElementById('shiftDetails');
                    while (output.firstChild) {
                        output.removeChild(output.firstChild);
                    }
                    var arrayLength = data.length;
                    var i = 0;
                    var ele = "";
                    while (i < arrayLength)
                    {
                        var ele = document.createElement("input");
                        ele.setAttribute("type", "radio");
                        ele.setAttribute("name", "shift");
                        ele.setAttribute("class", "innerClass");
                        ele.setAttribute("value", data[i].staff_request_id);
                        output.appendChild(ele);

                        var lvl = document.createElement("label");
                        lvl.setAttribute("class", "labelClass");
                        lvl.innerHTML = "Shift start : " + data[i].shift_start_datetime + " Shift end : " + data[i].shift_end_datetime + "<br>";
                        output.appendChild(lvl);
                        i++;
                    }
                    $(function ()
                    {
                        $(".btninfo").trigger('click');
                    })
                    $('div#' + id).draggable({
                        helper: 'clone'
                    });
                    $(this).css('min-height', 'auto');

                    $(".assign").click(function (e) {
                        var email = $("form#staffDetailsForm input[type='hidden']").val();
                        var staffRequestId = $("form#staffDetailsForm input[type='radio']:checked").val();

                        $.ajax({
                            url: 'index.php?r=admin/shiftManagementForHospital/sendDragStaffDetails',
                            type: 'GET',
                            data: {
                                'staffEmail': email,
                                'staffRequestId': staffRequestId
                            },
                            'success': function (data) {
                                console.log(data);
                                alert(data);
                                window.location.reload();
                            }
                        });
                    });
                }
            });
        }
    });

    /*
     * Ending function for Drag and drop on Hospital Unit page
     */

    $("#training_id").change(function () {
        $.ajax({url: "index.php?r=admin/allTraining/getFees",
            data: {training_id: $("#training_id").val()},
            type: 'POST',
            success: function (result) {
                console.log(result);
                $("#TrainingDetails_fees").val(result);
            }});
    });

    $("#TimesheetPaymentDetailsForStaff_staff_id").change(function () {
        $.ajax({url: "index.php?r=finance/timesheetPaymentDetailsForStaff/GetTotalAmount",
            data: {
                staff_id: $("#TimesheetPaymentDetailsForStaff_staff_id").val(),
                weekEndDate: $("#TimesheetPaymentDetailsForStaff_week_end_date").val(),
            },
            type: 'POST',
            success: function (result) {
                console.log(result);
                $("#TimesheetPaymentDetailsForStaff_total_amount").val(result);
            }});

        $.ajax({url: "index.php?r=finance/timesheetPaymentDetailsForStaff/GetTrainingDeduction",
            data: {
                staff_id: $("#TimesheetPaymentDetailsForStaff_staff_id").val(),
                weekEndDate: $("#TimesheetPaymentDetailsForStaff_week_end_date").val(),
            },
            type: 'POST',
            success: function (result) {
                console.log(result);
                $("#TimesheetPaymentDetailsForStaff_for_training_deduction").val(result);
            }});
    });

    $("#TimesheetPaymentDetailsForStaff_week_end_date").change(function () {
        $.ajax({url: "index.php?r=finance/timesheetPaymentDetailsForStaff/GetTotalAmount",
            data: {
                staff_id: $("#TimesheetPaymentDetailsForStaff_staff_id").val(),
                weekEndDate: $("#TimesheetPaymentDetailsForStaff_week_end_date").val(),
            },
            type: 'POST',
            success: function (result) {
                console.log(result);
                $("#TimesheetPaymentDetailsForStaff_total_amount").val(result);
            }});

        $.ajax({url: "index.php?r=finance/timesheetPaymentDetailsForStaff/GetTrainingDeduction",
            data: {
                staff_id: $("#TimesheetPaymentDetailsForStaff_staff_id").val(),
                weekEndDate: $("#TimesheetPaymentDetailsForStaff_week_end_date").val(),
            },
            type: 'POST',
            success: function (result) {
                console.log(result);
                $("#TimesheetPaymentDetailsForStaff_for_training_deduction").val(result);
            }});
    });

    $("#TimesheetPaymentDetailsForHospital_hospital_unit_id").change(function () {
        $.ajax({url: "index.php?r=finance/TimesheetPaymentDetailsForHospital/GetTotalAmount",
            data: {
                hospital_id: $("#TimesheetPaymentDetailsForHospital_hospital_unit_id").val(),
                weekEndDate: $("#TimesheetPaymentDetailsForHospital_week_end_date").val(),
            },
            type: 'POST',
            success: function (result) {
                console.log(result);
                $("#TimesheetPaymentDetailsForHospital_total_amount").val(result);
            }});
    });

    $("#TimesheetPaymentDetailsForHospital_week_end_date").change(function () {
        $.ajax({url: "index.php?r=finance/TimesheetPaymentDetailsForHospital/GetTotalAmount",
            data: {
                hospital_id: $("#TimesheetPaymentDetailsForHospital_hospital_unit_id").val(),
                weekEndDate: $("#TimesheetPaymentDetailsForHospital_week_end_date").val(),
            },
            type: 'POST',
            success: function (result) {
                console.log(result);
                $("#TimesheetPaymentDetailsForHospital_total_amount").val(result);
            }});
    });

    $("#JobTypeForFinance_job_type_id").change(function () {
        var getValue = $("#JobTypeForFinance_job_type_id option:selected").text();
        if (getValue != 'Select Job Type') {
            var getValue = getValue + "-";
            $("#JobTypeForFinance_job_type_name").val(getValue);
        } else {
            var getValue = "";
            $("#JobTypeForFinance_job_type_name").val(getValue);
        }
    });

    /*
     * Timesheet
     */

    $("#Timesheet_staff_id").autocomplete({
        source: 'index.php?r=admin/default/autocompleteNameEmail'
    });

    $("#invoice_date").change(function () {
        $.ajax({url: "index.php?r=finance/TimesheetPaymentDetailsForStaff/getStaffPaymentDetails",
            data: {invoiceDate: $("#invoice_date").val()},
            type: 'POST',
            success: function (result) {
                console.log(result);
//                var output = document.getElementById('mainTable');
//                    output.remove();
                $('#mainTable ').remove();
                if ($("#invoice_date").val() != "") {
                    $('#mainDiv ').append($(result));
                }
            }});
    });

    $("#downloadTimesheet").change(function () {
        $.ajax({url: "index.php?r=finance/Timesheet/downloadStaffTimesheet",
            data: {weekEndDate: $("#downloadTimesheet").val()},
            type: 'POST',
            success: function (result) {
                console.log(result);
//                var output = document.getElementById('mainTable');
//                    output.remove();
                $('#mainTable ').remove();
                if ($("#downloadTimesheet").val() != "") {
                    $('#mainDiv ').append($(result));
                }
            }});
    });

    $("#selectedDateForPayment").change(function () {
        $.ajax({url: "index.php?r=finance/TimesheetPaymentDetailsForStaff/getStaffDetailsForPayment",
            data: {invoiceDate: $("#selectedDateForPayment").val()},
            type: 'POST',
            success: function (result) {
                console.log(result);
                $('#mainTable ').remove();
                if ($("#invoice_date").val() != "") {
                    $('#mainDiv ').append($(result));
                }
            }});
    });

    $('#shiftDiv').on('change', '.hospital_unit_id', function () {
        var selectThis = $(this);
        if ($("#Timesheet_staff_id").val() == "") {
            alert("Please enter staff!!");
            selectThis.closest('tr').find(".hospital_unit_id").val('');
        } else {
            $.ajax({url: "index.php?r=finance/Timesheet/CheckDuplicate",
                data: {
                    staffId: $("#Timesheet_staff_id").val(),
                    invoiceDate: $("#Timesheet_invoice_date").val(),
                },
                type: 'POST',
                success: function (result) {
                    console.log(result);

                    if (result != "") {
                        alert(result);
                        selectThis.closest('tr').find(".hospital_unit_id").val('');
                        $('#Timesheet_staff_id').val('');
                    }
                }});
        }
    });

    $("#checkDuplicate").click(function () {
        if ($("#Timesheet_staff_id").val() == "") {
            alert("Please enter staff!!");
            selectThis.closest('tr').find(".hospital_unit_id").val('');
        } else {
            $.ajax({url: "index.php?r=finance/Timesheet/CheckDuplicate",
                data: {
                    staffId: $("#Timesheet_staff_id").val(),
                    invoiceDate: $("#Timesheet_invoice_date").val(),
                },
                type: 'POST',
                success: function (result) {
                    console.log(result);

                    if (result != "") {
                        alert(result);
                        selectThis.closest('tr').find(".hospital_unit_id").val('');
                        $('#Timesheet_staff_id').val('');
                    }
                }});
        }
    });

    $('#shiftDiv').on('change', '.hospital_unit_id', function () {
//            $(this).closest('tr').find(".jobType").val(4);
//            console.log($(this));
        var selectThis = $(this);
        var hospitalId = this.value;

        $.ajax({url: "index.php?r=finance/HospitalJobTypeRate/getJobTypeForHospital",
            data: {'hospital_unit_id': hospitalId},
            type: 'POST',
            success: function (result) {
                selectThis.closest('tr').find(".jobType option").remove();
                selectThis.closest('tr').find(".jobType").append(result);
            }});

    });

    $('#shiftDiv').on('change', '.weekEndDate', function () {
        var selectThis = $(this);
        selectThis.closest('tr').find(".jobType").val('');
    });


    $('#shiftDiv').on('change', '.jobType', function () {
        var selectThis = $(this);
//        alert(selectThis.closest('tr').find(".weekEndDate").val());
        if ($("#Timesheet_staff_id").val() == "") {
            alert("Please enter staff!!");
            $('#Timesheet_hospital_unit_id').val('');
        } else if (selectThis.closest('tr').find(".hospital_unit_id").val() == "") {
            selectThis.closest('tr').find(".jobType").val('');
            alert("Please select Hospital!!");
        } else {
            $.ajax({url: "index.php?r=finance/Timesheet/CheckDuplicateShift",
                data: {
                    staffId: $("#Timesheet_staff_id").val(),
                    weekEndDate: selectThis.closest('tr').find(".weekEndDate").val(),
                    jobType: selectThis.closest('tr').find(".jobType").val()
                },
                type: 'POST',
                success: function (result) {
                    result = jQuery.parseJSON(result);
                    console.log(result);
                    if (result.monday == 1) {
                        selectThis.closest('tr').find(".monday").attr('readonly', true);
                        selectThis.closest('tr').find(".monday").val(0);
                    } else
                    {
                        selectThis.closest('tr').find(".monday").attr('readonly', false);
                        selectThis.closest('tr').find(".monday").val('');
                    }

                    if (result.tuesday == 1) {
                        selectThis.closest('tr').find(".tuesday").attr('readonly', true);
                        selectThis.closest('tr').find(".tuesday").val(0);
                    } else
                    {
                        selectThis.closest('tr').find(".tuesday").attr('readonly', false);
                        selectThis.closest('tr').find(".tuesday").val('');
                    }

                    if (result.wednesday == 1) {
                        selectThis.closest('tr').find(".wednesday").attr('readonly', true);
                        selectThis.closest('tr').find(".wednesday").val(0);
                    } else
                    {
                        selectThis.closest('tr').find(".wednesday").attr('readonly', false);
                        selectThis.closest('tr').find(".wednesday").val('');
                    }

                    if (result.thursday == 1) {
                        selectThis.closest('tr').find(".thursday").attr('readonly', true);
                        selectThis.closest('tr').find(".thursday").val(0);
                    } else
                    {
                        selectThis.closest('tr').find(".thursday").attr('readonly', false);
                        selectThis.closest('tr').find(".thursday").val('');
                    }

                    if (result.friday == 1) {
                        selectThis.closest('tr').find(".friday").attr('readonly', true);
                        selectThis.closest('tr').find(".friday").val(0);
                    } else
                    {
                        selectThis.closest('tr').find(".friday").attr('readonly', false);
                        selectThis.closest('tr').find(".friday").val('');
                    }

                    if (result.saturday == 1) {
                        selectThis.closest('tr').find(".saturday").attr('readonly', true);
                        selectThis.closest('tr').find(".saturday").val(0);
                    } else
                    {
                        selectThis.closest('tr').find(".saturday").attr('readonly', false);
                        selectThis.closest('tr').find(".saturday").val('');
                    }

                    if (result.sunday == 1) {
                        selectThis.closest('tr').find(".sunday").attr('readonly', true);
                        selectThis.closest('tr').find(".sunday").val(0);
                    } else
                    {
                        selectThis.closest('tr').find(".sunday").attr('readonly', false);
                        selectThis.closest('tr').find(".sunday").val('');
                    }
                }});
        }
    });
});

function getSecsOfDate(dateVal) {
    var dateDbsArr = dateVal.split('-');
    return (new Date(dateDbsArr[2] + '/' + dateDbsArr[1] + '/' + dateDbsArr[0]).getTime());

}

function printDiv() {
    var divToPrint = document.getElementById('printableArea');
    newWin = window.open("");
    newWin.document.write(divToPrint.outerHTML);
    newWin.print();
    newWin.close();
}