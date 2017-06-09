<?php
/* @var $this JobTypeForFinanceController */
/* @var $model JobTypeForFinance */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'job-type-for-finance-form',
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
		<?php echo $form->labelEx($model,'job_type_id'); ?>
                                    <?php $allJobType = JobType::model()->jobTypeAllForFinance(); 
                                            $selectedJobType=$model->job_type_id;
                                    ?>                                        
                                    <?php echo CHtml::dropDownList('JobTypeForFinance[job_type_id]', $selectedJobType, $allJobType, array('single'=>'single'));?>
		<?php echo $form->error($model,'job_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'job_type_name'); ?>
		<?php echo $form->textField($model,'job_type_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'job_type_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',array(""=>"Select Status","Y"=>"Yes", "N"=>"No")); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->