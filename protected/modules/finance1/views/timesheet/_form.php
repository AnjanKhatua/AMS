<?php
/* @var $this TimesheetController */
/* @var $model Timesheet */
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
        padding: 4px; 
        border: 1px solid #ccc; 
        text-align: left; 
    }

    @media 
    only screen and (max-width: 1279px),
    (min-device-width: 320px) and (max-device-width: 480px) and (-webkit-min-device-pixel-ratio: 2) {

        .classSize{
            width: 170px;
        }

        .classSizes{
            width: 170px;
        }
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
</style>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'timesheet-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php
    $selectedDate = "";
    $selectedJobType = "";
    $selectedHospitalUnit = ""
    ?>
    <?php echo $form->errorSummary($model); ?>

    <?php if (!$model->isNewRecord) { ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'staff_id'); ?>
            <?php
            if (!$model->isNewRecord) {
                $getName = User::model()->getStaffName($model->staff_id);
                $model->staff_id = $getName;
            } elseif ($model->staff_id != "") {
                $getName = User::model()->getStaffName($model->staff_id);
                $model->staff_id = $getName;
            }
            ?>
            <?php echo $form->textField($model, 'staff_id', array('size' => 10, 'maxlength' => 10)); ?>
            <?php echo $form->error($model, 'staff_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'hospital_unit_id'); ?>
            <?php
            $la_allHospitalUnits = HospitalJobTypeRate::model()->allHospital();
            $selectedHospitalUnit = $model->hospital_unit_id;
            ?>
            <?php echo CHtml::dropDownList('Timesheet[hospital_unit_id]', $selectedHospitalUnit, $la_allHospitalUnits, array('single' => 'single', 'class' => 'hospital_unit_id')); ?>
            <?php // echo $form->textField($model,'hospital_unit_id[]',array('class' => 'classSizes'));  ?>
            <?php echo $form->error($model, 'hospital_unit_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'invoice_date'); ?>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'name' => 'Timesheet[invoice_date]',
                'value' => $model->invoice_date,
                'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => 'dd-mm-yy',
                    'changeMonth' => true,
                    'changeYear' => true,
                    'yearRange' => '1940:2100',
                    'minDate' => '01-01-1940',
                    'maxDate' => '31-12-2100',
                ),
                'htmlOptions' => array(
                    'style' => 'height:20px;'
                ),
            ));
            ?>
    <?php echo $form->error($model, 'invoice_date'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'week_end_date'); ?>
            <?php
            $allDate = Utility::getWeekDate();
            $selectedDate = $model->week_end_date;
            ?>                                        
            <?php echo CHtml::dropDownList('Timesheet[week_end_date]', $selectedDate, $allDate, array('single' => 'single')); ?>
            <?php // echo $form->textField($model,'week_end_date');  ?>
    <?php echo $form->error($model, 'week_end_date'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'finance_job_type_id'); ?>
            <?php
            $allJobType = JobTypeForFinance::model()->jobTypeOfFinance();
            $selectedJobType = $model->finance_job_type_id;
            ?> 
            <?php echo CHtml::dropDownList('Timesheet[finance_job_type_id]', $selectedJobType, $allJobType, array('single' => 'single')); ?>

            <?php // echo $form->textField($model,'finance_job_type_id',array('size'=>10,'maxlength'=>10));  ?>
    <?php echo $form->error($model, 'finance_job_type_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'monday'); ?>
            <?php echo $form->textField($model, 'monday'); ?>
    <?php echo $form->error($model, 'monday'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'tuesday'); ?>
            <?php echo $form->textField($model, 'tuesday'); ?>
    <?php echo $form->error($model, 'tuesday'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'wednesday'); ?>
            <?php echo $form->textField($model, 'wednesday'); ?>
    <?php echo $form->error($model, 'wednesday'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'thursday'); ?>
            <?php echo $form->textField($model, 'thursday'); ?>
    <?php echo $form->error($model, 'thursday'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'friday'); ?>
            <?php echo $form->textField($model, 'friday'); ?>
    <?php echo $form->error($model, 'friday'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'saturday'); ?>
            <?php echo $form->textField($model, 'saturday'); ?>
    <?php echo $form->error($model, 'saturday'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'sunday'); ?>
            <?php echo $form->textField($model, 'sunday'); ?>
    <?php echo $form->error($model, 'sunday'); ?>
        </div>

        <div class="row">
            <?php // echo $form->labelEx($model,'total_worked_hours'); ?>
            <?php // echo $form->textField($model,'total_worked_hours');  ?>
    <?php // echo $form->error($model,'total_worked_hours');   ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'exp'); ?>
            <?php echo $form->textField($model, 'exp'); ?>
    <?php echo $form->error($model, 'exp'); ?>
        </div>

        <div class="row">
            <?php // echo $form->labelEx($model,'total_amount_of_staff'); ?>
            <?php // echo $form->textField($model,'total_amount_of_staff');  ?>
    <?php // echo $form->error($model,'total_amount_of_staff');   ?>
        </div>

        <div class="row">
            <?php // echo $form->labelEx($model,'total_amount_of_hospital'); ?>
            <?php // echo $form->textField($model,'total_amount_of_hospital');  ?>
    <?php // echo $form->error($model,'total_amount_of_hospital');   ?>
        </div>        

        <div class="row">
            <?php echo $form->labelEx($model, 'note'); ?>
            <?php echo $form->textField($model, 'note', array('rows' => 6, 'cols' => 50)); ?>
    <?php echo $form->error($model, 'note'); ?>
        </div>

        <div class="row">
            <?php // echo $form->labelEx($model,'paid_to_staff'); ?>
            <?php // echo $form->textField($model,'paid_to_staff',array('size'=>1,'maxlength'=>1));  ?>
    <?php // echo $form->error($model,'paid_to_staff');   ?>
        </div>

        <div class="row">
            <?php // echo $form->labelEx($model,'paid_by_hospital');  ?>
            <?php // echo $form->textField($model,'paid_by_hospital',array('size'=>1,'maxlength'=>1));  ?>
        <?php // echo $form->error($model,'paid_by_hospital');   ?>
        </div>
<?php } ?>


<?php if ($model->isNewRecord) { ?>
        <table>
            <tr>
                <td>
                    <?php echo $form->labelEx($model, 'staff_id'); ?>
                    <?php echo $form->textField($model, 'staff_id', array('size' => 10, 'maxlength' => 10)); ?>
    <?php echo $form->error($model, 'staff_id'); ?>
                </td>
                <td>
                    <?php echo $form->labelEx($model, 'invoice_date'); ?>
                    <?php
                    $ld_toDay = date("d-m-Y");
                    $model->invoice_date = $ld_toDay;
                    ?>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'name' => 'Timesheet[invoice_date]',
                        'value' => $model->invoice_date,
                        'options' => array(
                            'showAnim' => 'fold',
                            'dateFormat' => 'dd-mm-yy',
                            'changeMonth' => true,
                            'changeYear' => true,
                            'yearRange' => '1940:2100',
                            'minDate' => '01-01-1940',
                            'maxDate' => '31-12-2100',
                        ),
                        'htmlOptions' => array(
                            'style' => 'height:20px;'
                        ),
                    ));
                    ?>
    <?php echo $form->error($model, 'invoice_date'); ?>
                </td>
            </tr>
        </table>
        <div class="row" id="addDiv">
            <table id='shiftDiv' class="shift-create">
                <tr class="shiftRow">
                    <td>
                        <?php echo $form->labelEx($model, 'hospital_unit_id'); ?>
                        <?php
                        $la_allHospitalUnits = HospitalJobTypeRate::model()->allHospital();
                        $selectedHospitalUnit = $model->hospital_unit_id;
                        ?>
                        <?php echo CHtml::dropDownList('Timesheet[hospital_unit_id][]', $selectedHospitalUnit, $la_allHospitalUnits, array('single' => 'single', 'class' => 'hospital_unit_id')); ?>
    <?php // echo $form->textField($model,'hospital_unit_id[]',array('class' => 'classSizes'));   ?>
                        <?php echo $form->error($model, 'hospital_unit_id'); ?>
                    </td>
                    <td>
                        <?php echo $form->labelEx($model, 'week_end_date'); ?>
                        <?php
                        $allDate = Utility::getWeekDate();
                        $selectedDate = $model->week_end_date;
                        ?>                                        
                        <?php echo CHtml::dropDownList('Timesheet[week_end_date][]', $selectedDate, $allDate, array('single' => 'single', 'class' => 'classSizes')); ?>
    <?php // echo $form->textField($model,'week_end_date');   ?>
                        <?php echo $form->error($model, 'week_end_date'); ?>
                    </td>
                    <td>
                        <?php echo $form->labelEx($model, 'finance_job_type_id'); ?>
                        <?php
//    $allJobType = JobTypeForFinance::model()->jobTypeOfFinance();
                        $allJobType = array();
                        $selectedJobType = $model->finance_job_type_id;
                        ?> 
                        <?php echo CHtml::dropDownList('Timesheet[finance_job_type_id][]', $selectedJobType, $allJobType, array('single' => 'single', 'class' => 'classSizes jobType')); ?>

    <?php // echo $form->textField($model,'finance_job_type_id',array('size'=>10,'maxlength'=>10));    ?>
                        <?php echo $form->error($model, 'finance_job_type_id'); ?>
                    </td>
                    <td>
                        <?php echo $form->labelEx($model, 'monday'); ?>
    <?php echo $form->textField($model, 'monday[]', array('class' => 'classSize')); ?>
                        <?php echo $form->error($model, 'monday'); ?>
                    </td>
                    <td>
                        <?php echo $form->labelEx($model, 'tuesday'); ?>
    <?php echo $form->textField($model, 'tuesday[]', array('class' => 'classSize')); ?>
                        <?php echo $form->error($model, 'tuesday'); ?>
                    </td>
                    <td>
                        <?php echo $form->labelEx($model, 'wednesday'); ?>
    <?php echo $form->textField($model, 'wednesday[]', array('class' => 'classSize')); ?>
                        <?php echo $form->error($model, 'wednesday'); ?>
                    </td>
                    <td>
                        <?php echo $form->labelEx($model, 'thursday'); ?>
    <?php echo $form->textField($model, 'thursday[]', array('class' => 'classSize')); ?>
                        <?php echo $form->error($model, 'thursday'); ?>
                    </td>
                    <td>
                        <?php echo $form->labelEx($model, 'friday'); ?>
    <?php echo $form->textField($model, 'friday[]', array('class' => 'classSize')); ?>
                        <?php echo $form->error($model, 'friday'); ?>
                    </td>
                    <td>
                        <?php echo $form->labelEx($model, 'saturday'); ?>
    <?php echo $form->textField($model, 'saturday[]', array('class' => 'classSize')); ?>
                        <?php echo $form->error($model, 'saturday'); ?>
                    </td>
                    <td>
                        <?php echo $form->labelEx($model, 'sunday'); ?>
    <?php echo $form->textField($model, 'sunday[]', array('class' => 'classSize')); ?>
                        <?php echo $form->error($model, 'sunday'); ?>
                    </td>
                    <td>
                        <?php echo $form->labelEx($model, 'exp'); ?>
    <?php echo $form->textField($model, 'exp[]', array('class' => 'classSize')); ?>
                        <?php echo $form->error($model, 'exp'); ?>
                    </td>
                    <td>
                        <?php echo $form->labelEx($model, 'note'); ?>
    <?php echo $form->textField($model, 'note[]', array('class' => 'classSizes')); ?>
    <?php echo $form->error($model, 'note'); ?>
                    </td>
                </tr>
            </table>
            <div style="align:right"><a href="javascript:void(0)" id="add-more">Add More Time-sheet</a></div>
        </div>
        <?php } ?>

    <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<!--<script>
    $(function ()
    {
        $("#Timesheet_staff_id").autocomplete({
            source: 'index.php?r=admin/default/autocompleteNameEmail'
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
    })

</script> -->