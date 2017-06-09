<?php
/* @var $this TrainingDetailsController */
/* @var $model TrainingDetails */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'training-details-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
                  <?php $selectedTraining = ''; $selectedStaff = '';?>
	<div class="row">
		<?php echo $form->labelEx($model,'training_id'); ?>
		<?php // echo $form->textField($model,'training_id',array('size'=>10,'maxlength'=>10)); ?>
                                    <?php $allTrainingType = AllTraining::model()->trainingTypeAll(); 
                                            $selectedTraining=$model->training_id;
                                    ?>                                        
                                    <?php echo CHtml::dropDownList('TrainingDetails[training_id]', $selectedTraining, $allTrainingType, array('single' => 'single', 'id' => 'training_id'));?>
		<?php echo $form->error($model,'training_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'staff_id'); ?>
		<?php // echo $form->textField($model,'staff_id',array('size'=>10,'maxlength'=>10)); ?>
                                    <?php $allStaff = User::model()->staffAll(); 
                                            $selectedStaff=$model->staff_id;
                                    ?>                                        
                                    <?php echo CHtml::dropDownList('TrainingDetails[staff_id]', $selectedStaff, $allStaff, array('single'=>'single'));?>
		<?php echo $form->error($model,'staff_id'); ?>
	</div>

                  <div class="row">
		<?php // echo $form->labelEx($model,'fees_paid_date'); ?>
		<?php // $this->widget('zii.widgets.jui.CJuiDatePicker',array(
//                                                'model' => $model,
//                                                'name'=>'TrainingDetails[fees_paid_date]',
//                                                'value'=>$model->fees_paid_date,
//                                                    'options'=>array(
//                                                            'showAnim'=>'fold',
//                                                            'dateFormat'=>'dd-mm-yy',
//                                                            'changeMonth'=>true,
//                                                            'changeYear'=>true,
//                                                            'yearRange'=>'1940:2100',
//                                                            'minDate' => '01-01-1940',     
//                                                            'maxDate' => '31-12-2100',
//			),
//                                                'htmlOptions'=>array(
//                                                'style'=>'height:20px;'
//                                                ),
//                                            ));
                                        ?>
		<?php // echo $form->error($model,'fees_paid_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fees'); ?>
		<?php echo $form->textField($model,'fees'); ?>
		<?php echo $form->error($model,'fees'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'deduction_amount'); ?>
		<?php echo $form->textField($model,'deduction_amount',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'deduction_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'remaining_amount'); ?>
		<?php echo $form->textField($model,'remaining_amount'); ?>
		<?php echo $form->error($model,'remaining_amount'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->