
<?php
$la_allWard = CHtml::listData(Ward::model()->findAll(),'ward_id','ward_name');
$la_allJobType = CHtml::listData(JobType::model()->findAll("`job_type_active_status`='Y'"),'job_type_id','job_type'); 
?>
<tr class="shiftRow">

    <td>
        <label for="ShiftManagementForHospital_ward">Shift Start Date Time</label>
         <?php 
                $this->widget('application.extensions.timepicker.EJuiDateTimePicker',array(
                'model'=>$model,
                'attribute'=>'shift_start_datetime',
                'options'=>array(
                   
                    'dateFormat' => 'dd-mm-yy',
                    'timeFormat' => 'h:m',
                    'changeMonth' => true,
                    'changeYear' => false,
                	'minDate' => 'today'
                    ),
                'htmlOptions'=>array(
                	'style'=>'height:20px;;background-color:#ffffff',
                	'readonly'=>'readonly',
                	'id'=>'shift_start_datetime'
                ),
                		
                ));  
            ?>
    </td>  
     <td>
         <label for="ShiftManagementForHospital_ward">Shift End Date Time</label>
        <?php 
                $this->widget('application.extensions.timepicker.EJuiDateTimePicker',array(
                'model'=>$model,
                'attribute'=>'shift_end_datetime',
                'options'=>array(
                    'timeFormat' => 'h:m',
                    'dateFormat' => 'dd-mm-yy',
                    'changeMonth' => true,
                    'changeYear' => false,
                	'minDate' => 'today'	
                    ),
                'htmlOptions'=>array(
                	'style'=>'height:20px;;background-color:#ffffff',
                	'readonly'=>'readonly',
                	'id'=>'shift_end_datetime'
                	),
                ));  
            ?>
    </td>  
    
    <td>
        <label for="ShiftManagementForHospital_ward">Ward</label>						                                        
        <?php echo CHtml::dropDownList('ward_id[]','', $la_allWard, array('single' => 'single', 'prompt' => 'Select Ward')); ?>							<br><span class="errorMessage ward"></span>
    </td>
    <td>	
        <label for="ShiftManagementForHospital_job_type_id">Job Type</label>						                                        
       <?php echo CHtml::dropDownList('job_type_id[]', '', $la_allJobType, array('single'=>'single','prompt'=>'Select Job Type'));?>					
        <br><span class="errorMessage job-type"></span>
    </td>	
    <td>
        <label for="ShiftManagementForHospital_quantity">Quantity</label>
        <input type="text" id="quantity[]" name="ShiftManagementForHospital[quantity][]" class="quantitycls" maxlength="3" size="3">							
        <br><span class="errorMessage quantity"></span>
    </td>
    <td><span onClick="$(this).parent().parent().remove();"> <a href="javascript:void(*=0)">Remove</a></td>
</tr>