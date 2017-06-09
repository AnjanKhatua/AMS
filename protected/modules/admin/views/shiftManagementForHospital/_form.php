<?php
/* @var $this ShiftManagementForHospitalController */
/* @var $model ShiftManagementForHospital */
/* @var $form CActiveForm */
?>
<style>
    table.shift-create{ 
        width: 100%; 
        border-collapse: collapse; 
    }
    /* Zebra striping */
    table.shift-create tr:nth-of-type(odd) { 
        background: #eee; 
    }
    table.shift-create th { 
        background: #333; 
        color: white; 
        font-weight: bold; 
    }
    table.shift-create td, th { 
        padding: 6px; 
        border: 1px solid #ccc; 
        text-align: left; 
    }

    @media 
    only screen and (max-width: 480px),
    (min-device-width: 320px) and (max-device-width: 480px) and (-webkit-min-device-pixel-ratio: 2) {

        /* Force table to not be like tables anymore */
        table.shift-create, table.shift-create td, table.shift-create tr { 
            display: block; 
        }

        table.shift-create tr { border: 1px solid #ccc; }

        table.shift-create td { 
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee; 
            position: relative;
            /*padding-left: 50%; */
        }

        table.shift-create td:before { 
            /* Now like a table header */
            position: absolute;
            /* Top/left values mimic padding */
            top: 6px;
            left: 6px;
            width: 45%; 
            padding-right: 10px; 
            white-space: nowrap;
        }

    }
    /* Portrait */
    @media only screen 
    and (min-device-width: 320px) 
    and (max-device-width: 480px)
    and (-webkit-min-device-pixel-ratio: 2)
    and (orientation: portrait) {
        /* Force table to not be like tables anymore */
        table.shift-create, table.shift-create td, table.shift-create tr { 
            display: block; 
        }

        table.shift-create tr { border: 1px solid #ccc; }

        table.shift-create td { 
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee; 
            position: relative;
            /*padding-left: 50%; */
        }

        table.shift-create td:before { 
            /* Now like a table header */
            position: absolute;
            /* Top/left values mimic padding */
            top: 6px;
            left: 6px;
            width: 45%; 
            padding-right: 10px; 
            white-space: nowrap;
        }
    }

    /* Landscape */
    @media only screen 
    and (min-device-width: 320px) 
    and (max-device-width: 480px)
    and (-webkit-min-device-pixel-ratio: 2)
    and (orientation: landscape) {
        /* Force table to not be like tables anymore */
        table.shift-create, table.shift-create td, table.shift-create tr { 
            display: block; 
        }

        table.shift-create tr { border: 1px solid #ccc; }

        table.shift-create td { 
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee; 
            position: relative;
            /*padding-left: 50%; */
        }

        table.shift-create td:before { 
            /* Now like a table header */
            position: absolute;
            /* Top/left values mimic padding */
            top: 6px;
            left: 6px;
            width: 45%; 
            padding-right: 10px; 
            white-space: nowrap;
        }

    }

    /*@media 
    only screen and (max-width: 480px),
    (min-device-width: 320px) and (max-device-width: 480px)  {
    
            /* Force table to not be like tables anymore */
    /*table.shift-create, table.shift-create tr {
    
            display: block
    
    }
    table.shift-create td { 
           display: inline-block;
           vertical-align: top;
           width: 38%;
           -webkit-box-sizing: border-box;
           -moz-box-sizing: border-box;
           box-sizing: border-box;
           word-spacing: normal;
           letter-spacing: normal;
   }
}*/
</style>
<div class="form">
    <?php $la_allHospitalUnits = CHtml::listData(HospitalUnit::model()->findAll('hospital_unit_active_status="Y" order by hospital_unit'), 'hospital_unit_id', 'hospital_unit'); ?>        
    <?php $la_allJobType = CHtml::listData(JobType::model()->findAll(), 'job_type_id', 'job_type'); ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'shift-management-for-hospital-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
    <?php
    $selectedHospitalUnit = '';
    $selectedJobType = '';
    $selectedUser = '';
    ?>


    <div class="row">
        <?php $selectedHospitalUnit = isset($_POST['ShiftManagementForHospital']['hospital_unit_id']) ? $_POST['ShiftManagementForHospital']['hospital_unit_id'] : $model->hospital_unit_id; ?>
        <?php echo $form->labelEx($model, 'hospital_unit_id'); ?>

        <?php echo CHtml::dropDownList('ShiftManagementForHospital[hospital_unit_id]', $selectedHospitalUnit, $la_allHospitalUnits, array('single' => 'single', 'id' => 'hospital_unit_id')); ?>
        <?php echo $form->error($model, 'hospital_unit_id'); ?>
        <br><span id="hospital_name_error" class="errorMessage"></span>
    </div>

    <?php if (!$model->isNewRecord) { ?>

        <div class="row">
            <label>Ward</label>
            <?php
            $la_allWards = Ward::model()->allWards();
            if (isset($la_allError['ward_id']))
                $selectedWard = '';
            else
                $selectedWard = $model->ward_id;
            ?>  
            <?php echo CHtml::dropDownList('ShiftManagementForHospital[ward_id]', $selectedWard, $la_allWards, array('single' => 'multiple')); ?>
            <?php echo $form->error($model, 'ward_id'); ?>
        </div>


        <div class="row">
            <?php $selectedJobType = isset($_POST['ShiftManagementForHospital']['job_type_id']) ? $_POST['ShiftManagementForHospital']['job_type_id'] : $model->job_type_id; ?>
            <?php echo $form->labelEx($model, 'job_type_id'); ?>
            <?php $allJobTypes = JobType::model()->jobTypeAll(); ?>                                        
            <?php echo CHtml::dropDownList('ShiftManagementForHospital[job_type_id]', $selectedJobType, $la_allJobType, array('single' => 'single', 'prompt' => 'Select Job Type')); ?>
            <?php echo $form->error($model, 'job_type_id'); ?>
            <br><span id="job_type_error" class="errorMessage"></span>
        </div>

        <div class="row">
            <label for="ShiftManagementForHospital_ward">Shift Start Date Time</label>
            <?php
            $this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
                'model' => $model,
                'attribute' => 'shift_start_datetime',
                'options' => array(
                    'dateFormat' => 'dd-mm-yy',
                    'timeFormat' => 'hh:mm:ss',
                    'changeMonth' => true,
                    'changeYear' => true,
                    'minDate' => 'today'
                ),
                'htmlOptions' => array(
                    'style' => 'height:20px;;background-color:#ffffff',
                    'readonly' => 'readonly',
                    'id' => 'shift_start_datetime',
                    'class' => 'datefieldfirst'
                ),
            ));
            ?>
            <br><span id="shift_start_datetime_error" class="errorMessage"></span>
        </div>
        <div class="row">
            <label for="ShiftManagementForHospital_ward">Shift End Date Time</label>
            <?php
            $this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
                'model' => $model,
                'attribute' => 'shift_end_datetime',
                'options' => array(
                    'timeFormat' => 'hh:mm:ss',
                    'dateFormat' => 'dd-mm-yy',
                    'changeMonth' => true,
                    'changeYear' => true,
                    'minDate' => 'today'
                ),
                'htmlOptions' => array(
                    'style' => 'height:20px;;background-color:#ffffff',
                    'readonly' => 'readonly',
                    'id' => 'shift_end_datetime',
                    'class' => 'datefieldend'
                ),
            ));
            ?>
            <br><span id="shift_end_datetime_error" class="errorMessage"></span>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'quantity'); ?>
            <?php echo $form->textField($model, 'quantity', array('size' => 3, 'maxlength' => 3)); ?>
            <?php echo $form->error($model, 'quantity'); ?>
            <br><span id="quantity_error" class="errorMessage"></span>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'notes'); ?>
            <?php echo $form->textArea($model, 'notes'); ?>
            <?php echo $form->error($model, 'notes'); ?>
        </div>
    <?php }
    ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'requested_date'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'name' => 'ShiftManagementForHospital[requested_date]',
            'value' => $model->requested_date,
            'options' => array(
                'showAnim' => 'fold',
                'dateFormat' => 'dd-mm-yy',
                'changeMonth' => true,
                'changeYear' => true,
                'minDate' => '01-01 -2016',
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;;background-color:#ffffff;',
                'readonly' => 'readonly',
                'id' => 'requested_date'
            ),
        ));
        ?>
        <?php echo $form->error($model, 'requested_date'); ?>
        <br><span id="requested_date_error" class="errorMessage"></span>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'requested_time'); ?>
        <?php
        $this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
            'model' => $model,
            'attribute' => 'requested_time',
            'options' => array(
                'timeFormat' => 'hh:mm',
                'timeOnly' => true,
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;background-color:#ffffff;',
                'readonly' => 'readonly',
                'id' => 'requested_time'
            ),
        ));
        ?>
        <?php echo $form->error($model, 'requested_time'); ?>
        <br><span id="requested_time_error" class="errorMessage"></span>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'requested_person'); ?>
        <?php echo $form->textField($model, 'requested_person', array('size' => 60, 'maxlength' => 150, 'id' => 'requested_person')); ?>
        <?php echo $form->error($model, 'requested_person'); ?>
        <br><span id="requested_person_error" class="errorMessage"></span>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'requested_person_mobile_number'); ?>
        <?php echo $form->textField($model, 'requested_person_mobile_number', array('size' => 11, 'maxlength' => 15, 'id' => 'requested_person_mobile_number')); ?>
        <?php echo $form->error($model, 'requested_person_mobile_number'); ?>
        <br><span id="requested_person_mobile_number_error" class="errorMessage"></span>
    </div>

    <?php if ($model->isNewRecord) { ?>
        <div class="row">
            <table id='shiftDiv' class="shift-create">
                <tr class="shiftRow">

                    <td>
                        <label for="ShiftManagementForHospital_ward">Shift Start Date Time</label>
                        <?php
                        $this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
                            'model' => $model,
                            //'attribute'=>'shift_start_datetime_1',
                            'options' => array(
                                'dateFormat' => 'dd-mm-yy',
                                'timeFormat' => 'hh:mm',
                                'changeMonth' => true,
                                'changeYear' => true,
                                'minDate' => 'today'
                            ),
                            'htmlOptions' => array(
                                'style' => 'height:20px;;background-color:#ffffff',
                                'readonly' => 'readonly',
                                'id' => 'shift_start_datetime_1',
                                'name' => 'shift_start_datetime_1',
                                'class' => 'datefieldfirst'
                            ),
                        ));
                        ?>
                        <span class="errorMessage shiftStartTime"></span>
                    </td>  
                    <td>
                        <label for="ShiftManagementForHospital_ward">Shift End Date Time</label>
                        <?php
                        $this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'shift_end_datetime',
                            'options' => array(
                                'timeFormat' => 'hh:mm',
                                'dateFormat' => 'dd-mm-yy',
                                'changeMonth' => true,
                                'changeYear' => true,
                                'minDate' => 'today'
                            ),
                            'htmlOptions' => array(
                                'style' => 'height:20px;;background-color:#ffffff',
                                'readonly' => 'readonly',
                                'id' => 'shift_end_datetime_1',
                                'name' => 'shift_end_datetime_1',
                                'class' => 'datefieldend'
                            ),
                        ));
                        ?>
                        <span class="errorMessage shiftEndTime"></span>
                    </td>  

                    <td>
                        <label for="ShiftManagementForHospital_ward">Ward</label>	

                        <?php echo CHtml::dropDownList('ward_id[]', array('single' => 'single', 'prompt' => 'Select Ward', 'class' => 'wardcls', 'id' => 'ward_1')); ?>							
                        <span class="errorMessage ward"></span>
                    </td>
                    <td>	
                        <label for="ShiftManagementForHospital_job_type_id">Job Type</label>						                                        
                        <?php echo CHtml::dropDownList('job_type_id[]', '', $la_allJobType, array('single' => 'single', 'prompt' => 'Select Job Type', 'class' => 'jobtypecls', 'id' => 'jobType_1')); ?>					
                        <span class="errorMessage job-type"></span>
                    </td>	
                    <td>
                        <label for="ShiftManagementForHospital_quantity">Quantity</label>
                        <input type="text" name="quantity[]" class="quantitycls" maxlength="3" size="3" class='quantitycls' id='quantity_1'>							
                        <span class="errorMessage quantity"></span>
                    </td>
                    <td>
                        <label for="ShiftManagementForHospital_notes">Notes</label>
                        <textarea name="notes[]" class="notescls" id='notes_1'></textarea>						
                        <span class="errorMessage notes"></span>
                    </td>
                    <!--<td><span class=""> <a href="javascript:void(*=0)">Remove</a></td>-->
                </tr>

            </table>	
            <div style="align:right"><a href="javascript:void(0)" id="add-more">Add More Shift</a></div>
        </div>
        <hr>
    <?php } elseif ($_SESSION[logged_user][type] != 'M' && $_SESSION[logged_user][type] != 'C') {
        ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php echo $form->dropDownList($model, 'status', array("A" => "Active", "Ar" => "Archive")); ?>
            <?php echo $form->error($model, 'status'); ?>
        </div>
    <?php }
    ?>   

    <div class="row buttons">
        <input type="hidden" id="isNewRec" value="<?php echo $model->isNewRecord; ?>">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<!--<script>
    $(function () {
        $("#job_type_id").autocomplete({
            source: 'index.php?r=admin/ShiftManagementForHospital/autocomplete'
        });
    });
</script>-->
