<?php
/* @var $this UploadedTimesheetByStaffController */
/* @var $model UploadedTimesheetByStaff */
/* @var $form CActiveForm */
?>
<style>
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


        @media 
        only screen and (max-width: 1279px),
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
    </style>
    <div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'uploaded-timesheet-by-staff-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
        ?>
        <?php
        $selectedDate = "";
        ?>
        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($model); ?>

        <div class="row" id="addDiv">
            <table id='shiftDiv' class="shift-create">
                <tr class="shiftRow">
                    <td>
                        <?php echo $form->labelEx($model, 'week_end_date'); ?>
                        <?php
                        $allDate = Utility::getWeekDate();
                        $selectedDate = $model->week_end_date;
                        ?>                                        
                        <?php echo CHtml::dropDownList('UploadedTimesheetByStaff[week_end_date][]', $selectedDate, $allDate, array('single' => 'single', 'class' => 'classSizes weekEndDate', 'required' => true)); ?>
                        <?php // echo $form->textField($model,'week_end_date');    ?>
                        <?php echo $form->error($model, 'week_end_date'); ?>
                    </td>
                    <td>
                        <?php echo $form->labelEx($model, 'timesheet_name'); ?>
                        <?php // echo $form->fileField($model, 'timesheet_name[]', array('size' => 60, 'maxlength' => 255, 'required' => true));   ?>
                        <input type="file" name="timesheet_name[]" required> 
                        <?php echo $form->error($model, 'timesheet_name'); ?>
                    </td>
                </tr>
            </table>
            <div style="align:right"><a href="javascript:void(0)" id="add-more">Add More Time-sheet</a></div>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->