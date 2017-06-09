<?php
/* @var $this StaffJobTypeRateController */
/* @var $model StaffJobTypeRate */
/* @var $form CActiveForm */
?>

<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/css/jquery.multiselect.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery.multiselect.js"></script>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'staff-job-type-rate-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

                  <?php $selectedJobType = ''; ?>
	<div class="row">
		<?php echo $form->labelEx($model,'staff_id'); ?>
                                    <?php 
                                    if (!$model->isNewRecord) {
                                            $getName = User::model()->getStaffName($model->staff_id); 
                                            $model->staff_id = $getName;
                                    }elseif ($model->staff_id != "") {
                                            $getName = User::model()->getStaffName($model->staff_id); 
                                            $model->staff_id = $getName;
                                    }
                                    ?>
		<?php echo $form->textField($model,'staff_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'staff_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'finance_job_type_id'); ?>
                                    <?php $allJobType = JobTypeForFinance::model()->jobTypeOfFinance(); ?>
                                    <?php $selectedJobType=$model->finance_job_type_id; ?> 
                                    <?php if ($model->isNewRecord) 
                                        echo CHtml::dropDownList('StaffJobTypeRate[finance_job_type_id]', $selectedJobType, $allJobType, array('multiple'=>'multiple'));?>
                                    <?php if (!$model->isNewRecord) 
                                        echo CHtml::dropDownList('StaffJobTypeRate[finance_job_type_id]', $selectedJobType, $allJobType, array('single'=>'single'));?>
		<?php // echo $form->textField($model,'finance_job_type_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'finance_job_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rate'); ?>
		<?php echo $form->textField($model,'rate'); ?>
		<?php echo $form->error($model,'rate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
                
                  

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php 
if ($model->isNewRecord) {
?>
        <script>
                $(function ()
                {
                    $("select#StaffJobTypeRate_finance_job_type_id").multiselect();
                })
        </script> 
<?php
}
?>
    <script>
        $(function ()
        {
            $("#StaffJobTypeRate_staff_id").autocomplete({
                source: 'index.php?r=admin/default/autocompleteNameEmail'
            });
        })

    </script> 