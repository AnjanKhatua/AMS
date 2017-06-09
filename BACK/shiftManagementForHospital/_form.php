<?php
/* @var $this ShiftManagementForHospitalController */
/* @var $model ShiftManagementForHospital */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'shift-management-for-hospital-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    <?php $selectedHospitalUnit=''; $selectedJobType=''; $selectedUser='';?>
	<div class="row">
		<?php
		if(!$model->isNewRecord) {
			$selectedHospitalUnit = $model->hospital_unit_id;
			}
		?>
		<?php echo $form->labelEx($model,'hospital_unit_id'); ?>
		<?php $allHospitalUnits = HospitalUnit::model()->allHospitalUnits(); ?>                                        
		<?php echo CHtml::dropDownList('ShiftManagementForHospital[hospital_unit_id]', $selectedHospitalUnit, $allHospitalUnits, array('single'=>'single'));?>
		<?php echo $form->error($model,'hospital_unit_id'); ?>
	</div>
	<div class="row">
		<?php
		if(!$model->isNewRecord) {
			$selectedJobType = $model->job_type_id;
			}
		?>
		<?php echo $form->labelEx($model,'job_type_id'); ?>
		<?php $allJobTypes = JobType::model()->jobTypeAll(); ?>                                        
		<?php echo CHtml::dropDownList('ShiftManagementForHospital[job_type_id]', $selectedJobType, $allJobTypes, array('single'=>'single'));?>
		<?php echo $form->error($model,'job_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'ShiftManagementForHospital[date]',
                                                'value'=>$model->date,
                                                'options'=>array(
                                                            'showAnim'=>'fold',
                                                            'dateFormat'=>'dd-mm-yy',
                                                            'changeMonth'=>true,
                                                            'changeYear'=>true,
                                                            'yearRange'=>'1940:2016',
                                                            'minDate' => '01-01-1940',     
                                                            'maxDate' => '31-12-2016',
			),
                                                'htmlOptions'=>array(
                                                'style'=>'height:20px;'
                                                ),
                                            ));
                                        ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shift_start_time'); ?>
		<?php echo $form->textField($model,'shift_start_time'); ?>
		<?php 
			/*$this->widget('widgets.timepicker.timepicker', array(
				'model'=>$model,
				'name'=>'ShiftManagementForHospital[shift_start_time]',
				'value'=>$model->shift_start_time,
				'options'=> array(
					'dateFormat'=>null,
					'timeFormat'=>'hh:mm:ss',
					'showOn'=>'button',
					'showSecond'=>true,
					'changeMonth'=>false,
					'changeYear'=>false,
					'tabularLevel'=>null,
					)
			));*/
?>
		<?php echo $form->error($model,'shift_start_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shift_end_time'); ?>
		<?php echo $form->textField($model,'shift_end_time'); ?>
		<?php echo $form->error($model,'shift_end_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'requested_date'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'ShiftManagementForHospital[requested_date]',
                                                'value'=>$model->requested_date,
                                                    'options'=>array(
                                                            'showAnim'=>'fold',
                                                            'dateFormat'=>'dd-mm-yy',
                                                            'changeMonth'=>true,
                                                            'changeYear'=>true,
                                                            'yearRange'=>'1940:2016',
                                                            'minDate' => '01-01-1940',     
                                                            'maxDate' => '31-12-2016',
			),
                                                'htmlOptions'=>array(
                                                'style'=>'height:20px;'
                                                ),
                                            ));
                                        ?>
		<?php echo $form->error($model,'requested_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'requested_time'); ?>
		<?php echo $form->textField($model,'requested_time'); ?>
		<?php echo $form->error($model,'requested_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'requested_person'); ?>
		<?php echo $form->textField($model,'requested_person',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'requested_person'); ?>
	</div>
    <div class="row">
		<?php
		if(!$model->isNewRecord) {
			$selectedUser = $model->request_accepted_by;
			}
		?>
		<?php echo $form->labelEx($model,'request_accepted_by'); ?>
		<?php $allUsers = User::model()->allUsers(); ?>                                        
		<?php echo CHtml::dropDownList('ShiftManagementForHospital[request_accepted_by]', $selectedUser, $allUsers, array('single'=>'single'));?>
		<?php echo $form->error($model,'request_accepted_by'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'requested_person_mobile_number'); ?>
		<?php echo $form->textField($model,'requested_person_mobile_number',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'requested_person_mobile_number'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->