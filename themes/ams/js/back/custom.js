// JavaScript Document

$(document).ready(function(){

	$("#hospital-registration-form").submit(function(){
		var hospital_group_name = $("#HospitalRegistration_hospital_name").val();
		var errorFlag = false;
		var pattern = /^([A-Z])+(([a-zA-Z0-9\s])+)+$/;
		if(hospital_group_name== ''){
			$("#hospital_group_name_err").html("Please enter hospital group name!").show();;
			errorFlag = true;
		} else if(hospital_group_name.length >=1 && hospital_group_name.length < 4 ) {
			$("#hospital_group_name_err").html('Hospital group name should be greater than 4 characters!').show();;
			errorFlag = true;
		} else if ( !pattern.test(hospital_group_name) ){
			$("#hospital_group_name_err").html('First character should be capital!').show();;
			errorFlag = true;
		}
		
		if(errorFlag == true){
			return false;
		} else {
			$("#hospital-registration-form").submit();
		}
	});
	var count = 1;
	$("#add-more").on('click', function() {
		count++;
		$('.shiftRow:last').clone(false)
        .find("input:text").val("").end()
        .appendTo('#shiftDiv');	
		
		$('.shiftRow:last').find('input.datefieldfirst')
	    .attr("id", "shift_start_datetime_"+count)
	    .removeClass('hasDatepicker') 
	    .unbind()
	    .datetimepicker({'timeFormat' : 'hh:mm',
            'dateFormat' : 'dd-mm-yy',
            'changeMonth': true,
            'changeYear' : false,
        	'minDate' : 'today'	});
		 $('[name^=shift_start_datetime_]:last').attr('name', 'shift_start_datetime_'+count);
		 
		 $('.shiftRow:last').find('input.datefieldend')
	    .attr("id", "shift_end_datetime_"+count)
	    .removeClass('hasDatepicker') 
	    .unbind()
	    .datetimepicker({'timeFormat' : 'hh:mm',
            'dateFormat' : 'dd-mm-yy',
            'changeMonth' : true,
            'changeYear' : false,
        	'minDate' : 'today'	});
		 $('[name^=shift_end_datetime_]:last').attr('name', 'shift_end_datetime_'+count);
		 $('[id^=ward_]:last').attr('id', 'ward_'+count);
		 $('[id^=quantity_]:last').attr('id', 'quantity_'+count);
		 $('[id^=notes_]:last').attr('id', 'notes_'+count);
		 $('[id^=jobType_]:last').attr('id', 'jobType_'+count);
		 $('.shiftRow:last').find("span.errorMessage").html("").end()
	});
	$("#shift-management-for-hospital-form").submit(function(){
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
		$("#requested_person_mobile_number_error").html();
		
		if(hospital_unit == ''){
			$("#hospital_name_error").html("Please enter hospital name!").show();;
			errorFlag = true;
		} 
		if(ward == ''){
			$("#ward_error").html("Please select ward!").show();;
			errorFlag = true;
		} 
		if(job_type == ''){
			$("#job_type_error").html("Please select job type!").show();;
			errorFlag = true;
		} 
		if(quantity == '' || quantity == '0'){
			$("#quantity_error").html("Please enter quantity!").show();;
			errorFlag = true;
		} else if(quantity != '') {
			var pat = /^[1-9][0-9]*$/;
			if(!pat.test(quantity)) {
				$("#quantity_error").html("Please enter valid quantity!").show();
			}
		}
		if(shift_start_datetime == ''){
			$("#shift_start_datetime_error").html("Please enter shift start date!").show();;
			errorFlag = true;
		} else if(shift_start_datetime != '' && $("#isNewRec").val() == ''){				
			var today1 = new Date();			
			var toDateSecs1 = today1.getTime(); 
			var shiftStartDatetimeArr1 = shift_start_datetime.split(' ');
			var shiftStartDate1 = shiftStartDatetimeArr1[0];
			var shiftStartDateArr1 = shiftStartDate1.split('-')
			var shiftStartDateSecs1 = new Date(shiftStartDateArr1[2]+'/'+shiftStartDateArr1[1]+'/'+shiftStartDateArr1[0]+' '+shiftStartDatetimeArr1[1]).getTime();
			if(shiftStartDateSecs1 <  toDateSecs1) {
				$("#shift_start_datetime_error").html("Shift start date should be greater than or equal to today!").show();;
				errorFlag = true;
			} 
		} 
		
		if(shift_end_datetime == ''){
			$("#shift_end_datetime_error").html("Please enter shift end date!").show();;
			errorFlag = true;
		}else if(shift_end_datetime != '' && $("#isNewRec").val() == ''){
			
			var today = new Date();			
			var toDateSecs =today.getTime();
			var shiftStartDatetimeVal = shift_start_datetime;
			var shiftStartDatetimeArr = shiftStartDatetimeVal.split(' ');
			var shiftStartDate = shiftStartDatetimeArr[0];
			var shiftStartTime = shiftStartDatetimeArr[1];
			var shiftStartDateArr = shiftStartDate.split('-');
			var shiftStartTimeArr = shiftStartTime.split(':');
			var shiftStDt =  shiftStartDateArr[2]+'/'+shiftStartDateArr[1]+'/'+shiftStartDateArr[0]+' '+shiftStartTime;
			var shiftStartDateSecs = new Date(shiftStDt).getTime();
			
			var shiftEndDatetimeVal = shift_end_datetime;
			var shiftEndDatetimeArr = shiftEndDatetimeVal.split(' ');
			var shiftEndDate = shiftEndDatetimeArr[0];
			var shiftEndTime = shiftEndDatetimeArr[1];
			var shiftEndDateArr = shiftEndDate.split('-');
			var shiftEndTimeArr = shiftEndTime.split(':');
			var shiftEndDt =  shiftEndDateArr[2]+'/'+shiftEndDateArr[1]+'/'+shiftEndDateArr[0]+' '+shiftEndTime;
			var shiftEndDateSecs = new Date(shiftEndDt).getTime();
			if(shiftStartDateSecs > shiftEndDateSecs) {					
				$("#shift_end_datetime_error").html('Shift end time should greater than shift start time');
				errorFlag = true;
			} else if(shiftEndDateSecs <  toDateSecs) {
				
				$("#shift_end_datetime_error").html("Shift end date should be greater than or equal to today!").show();;
				errorFlag = true;
			}else {
				$("#shift_end_datetime_error").html('');
			}
		}
		
		if(requested_date == ''){
			$("#requested_date_error").html("Please enter requested date!").show();;
			errorFlag = true;
		} else if(requested_date != '') {
			var today = new Date();			
			var toDateSecs =today.getTime();
			var requestDateArr = requested_date.split('-');
			var requestDateSecs = new Date(requestDateArr[2]+'/'+requestDateArr[1]+'/'+requestDateArr[0]+ ' '+requested_time).getTime();
			if(requestDateSecs < toDateSecs) {
				$("#requested_date_error").html("Requested date should be greater than or equal to today and time!").show();;
				errorFlag = true;
			} else {
				$("#requested_date_error").html("");
				
			}
		}
		if(requested_time == ''){
			$("#requested_time_error").html("Please enter requested time!").show();
			errorFlag = true;
		} 
		if(requested_person == ''){
			$("#requested_person_error").html("Please enter requested person name!").show();
			errorFlag = true;
		} 
		if(request_accepted_by == ''){
			$("#request_accepted_by_error").html("Please select request accepted person name!").show();
			errorFlag = true;
		} 
		if(requested_person_mobile_number == ''){
			$("#requested_person_mobile_number_error").html("Please enter mobile number!").show();;
			errorFlag = true;
		} 
		if($("#isNewRec").val() == '1') {
			var shiftStartDatetimeCnt = 0;              
			$(".datefieldfirst").each(function(){
				shiftStartDatetimeCnt++;
				var shiftStartDatetimeId = $("#shift_start_datetime_"+shiftStartDatetimeCnt);
				if(shiftStartDatetimeId.val()=='') {				
					shiftStartDatetimeId.next('.shiftStartTime').html('Please enter shift start time');
					errorFlag = true;
				} else if(shiftStartDatetimeId.val() != ''){				
					var today = new Date();		
					
					var toDateSecs = today.getTime(); 
					var shiftStartDatetimeArr = shiftStartDatetimeId.val().split(' ');
					var shiftStartDate = shiftStartDatetimeArr[0];
					var shiftStartDateArr = shiftStartDate.split('-')
					var shiftStartDateSecs = new Date(shiftStartDateArr[2]+'/'+shiftStartDateArr[1]+'/'+shiftStartDateArr[0]+' '+shiftStartDatetimeArr[1]).getTime();
					
					if(shiftStartDateSecs <  toDateSecs) {
						alert(shiftStartDateSecs+'='+toDateSecs);
						shiftStartDatetimeId.next('.shiftStartTime').html("Shift start date should be greater than or equal to today!").show();;
						errorFlag = true;
					} else {
						shiftStartDatetimeId.next('.shiftStartTime').html("");
						
					}
				} else {
					shiftStartDatetimeId.next('.shiftStartTime').html('');	
				}			
			});
			
			var shiftEndDatetimeCnt = 0;              
			$(".datefieldend").each(function(){
				shiftEndDatetimeCnt++;
				var shiftStartDatetimeId = $("#shift_start_datetime_"+shiftEndDatetimeCnt);
				var shiftEndDatetimeId = $("#shift_end_datetime_"+shiftEndDatetimeCnt);
				
				if(shiftEndDatetimeId.val()=='') {	
					shiftEndDatetimeId.next('.shiftEndTime').html('Please enter shift end time');
					errorFlag = true;
				} else if(shiftEndDatetimeId.val() != ''){
					
					var today = new Date();			
					var toDateSecs =today.getTime();
					var shiftStartDatetimeVal = shiftStartDatetimeId.val();
					var shiftStartDatetimeArr = shiftStartDatetimeVal.split(' ');
					var shiftStartDate = shiftStartDatetimeArr[0];
					var shiftStartTime = shiftStartDatetimeArr[1];
					var shiftStartDateArr = shiftStartDate.split('-');
					var shiftStartTimeArr = shiftStartTime.split(':');
					var shiftStDt =  shiftStartDateArr[2]+'/'+shiftStartDateArr[1]+'/'+shiftStartDateArr[0]+' '+shiftStartTime;
					var shiftStartDateSecs = new Date(shiftStDt).getTime();
					
					var shiftEndDatetimeVal = shiftEndDatetimeId.val();
					var shiftEndDatetimeArr = shiftEndDatetimeVal.split(' ');
					var shiftEndDate = shiftEndDatetimeArr[0];
					var shiftEndTime = shiftEndDatetimeArr[1];
					var shiftEndDateArr = shiftEndDate.split('-');
					var shiftEndTimeArr = shiftEndTime.split(':');
					var shiftEndDt =  shiftEndDateArr[2]+'/'+shiftEndDateArr[1]+'/'+shiftEndDateArr[0]+' '+shiftEndTime;
					var shiftEndDateSecs = new Date(shiftEndDt).getTime();
					
					if(shiftStartDateSecs > shiftEndDateSecs) {					
						shiftEndDatetimeId.next('.shiftEndTime').html('Shift end time should greater than shift start time');
						errorFlag = true;
					} else if(shiftEndDateSecs < toDateSecs) {
						
						shiftEndDatetimeId.next('.shiftEndTime').html("Shift end date should be greater than or equal to today!").show();;
						errorFlag = true;
					}else {
						shiftEndDatetimeId.next('.shiftEndTime').html('');
					}
					
				} else {
					shiftEndDatetimeId.next('.shiftEndTime').html('');	
				}
				
			});
			var wardCnt = 0;              
			$(".wardcls").each(function(){
				wardCnt++;
				var wardId = $("#ward_"+wardCnt);
				if(wardId.val()=='') {				
					wardId.next('.ward').html('Please select ward');
					errorFlag = true;
				} else {
					//errorFlag = false;
					wardId.next('.ward').html('');	
				}
				
			});
			var jobTypeCnt = 0;
			$(".jobtypecls").each(function(){
				jobTypeCnt++;
				var jobTypeId = $("#jobType_"+jobTypeCnt);
				if(jobTypeId.val()=='') {				
					jobTypeId.next('.job-type').html('Please select job type');
					errorFlag = true;
				} else {
					jobTypeId.next('.job-type').html('');	
				}
			});
			var quantityCnt = 0;
			$(".quantitycls").each(function(){
				quantityCnt++;
				var quantityId = $("#quantity_"+quantityCnt);
				if(quantityId.val()=='') {				
					quantityId.next('.quantity').html('Please enter quantity');
					errorFlag = true;
				}else if(quantityId.val() != '') {
					var pat = /^[1-9][0-9]*$/;
					if(!pat.test(parseInt(quantityId.val()))) {
						quantityId.next('.quantity').html('Please enter valid quantity');
						errorFlag = true;
					}else {
						quantityId.next('.quantity').html('');	
					}
				} 
				else {
					quantityId.next('.quantity').html('');	
				}
			});
		}
		
		if(errorFlag == true){
			return false;
		} else {
			$("#hospital-registration-form").submit();
		}
	});
	
	
	$("#hospital_unit_id").change(function(){
		 $.ajax({url: "index.php?r=admin/shiftManagementForHospital/getContactNumberForHospital", 
	    	data: {hospital_unit_id : $("#hospital_unit_id").val()},
	    	type: 'POST',
	    	success: function(result){
	    		console.log(result);
	    		$("#requested_person_mobile_number").val(result);
	    }});
	}); 

});

