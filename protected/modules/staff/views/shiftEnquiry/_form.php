<?php
/* @var $this ShiftEnquiryController */
/* @var $model ShiftEnquiry */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'shift-enquiry-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <!--	<div class="row">
    <?php // echo $form->labelEx($model,'staff_request_id'); ?>
    <?php // echo $form->textField($model,'staff_request_id',array('size'=>10,'maxlength'=>10));  ?>
    <?php // echo $form->error($model,'staff_request_id');  ?>
            </div>
    
            <div class="row">
    <?php // echo $form->labelEx($model,'staff_id'); ?>
    <?php // echo $form->textField($model,'staff_id',array('size'=>10,'maxlength'=>10));  ?>
    <?php // echo $form->error($model,'staff_id');  ?>
            </div>
    
            <div class="row">
    <?php // echo $form->labelEx($model,'enquired_by'); ?>
    <?php // echo $form->textField($model,'enquired_by',array('size'=>10,'maxlength'=>10));  ?>
    <?php // echo $form->error($model,'enquired_by');  ?>
            </div>-->

    <div class="row">
        <?php
        if ($model->availability_confirmed_via == "") {
            $name = "Dashboard";
        } else {
            $name = $model->availability_confirmed_via;
        }
        ?>
        <?php echo $form->labelEx($model, 'availability_confirmed_via'); ?>
        <?php echo $form->textField($model, 'availability_confirmed_via', array('size' => 20, 'value' => $name, 'maxlength' => 20, 'disabled' => true)); ?>
        <?php echo $form->error($model, 'availability_confirmed_via'); ?>
    </div>

    <div class="row">
<?php echo $form->labelEx($model, 'availability_confirmed_by_staff'); ?>
<?php echo $form->dropDownList($model, 'availability_confirmed_by_staff', array("Y" => "Yes", "N" => "No")); ?>
        <?php echo $form->error($model, 'availability_confirmed_by_staff'); ?>
    </div>

    <!--	<div class="row">
<?php // echo $form->labelEx($model,'confirmed_by');   ?>
<?php // echo $form->textField($model,'confirmed_by',array('size'=>1,'maxlength'=>1));   ?>
    <?php // echo $form->error($model,'confirmed_by');   ?>
            </div>
    
            <div class="row">
<?php // echo $form->labelEx($model,'agent_user_id');   ?>
<?php // echo $form->textField($model,'agent_user_id',array('size'=>10,'maxlength'=>10));   ?>
    <?php // echo $form->error($model,'agent_user_id');   ?>
            </div>
    
            <div class="row">
<?php // echo $form->labelEx($model,'is_confirmed');   ?>
<?php // echo $form->textField($model,'is_confirmed',array('size'=>1,'maxlength'=>1));   ?>
    <?php // echo $form->error($model,'is_confirmed');   ?>
            </div>-->

    <div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

        <?php $this->endWidget(); ?>

</div><!-- form -->