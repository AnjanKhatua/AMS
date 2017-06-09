<?php
/* @var $this StaffRegistrationController */
/* @var $model StaffRegistration */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'staff_id'); ?>
		<?php echo $form->textField($model,'staff_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_date'); ?>
		<?php echo $form->textField($model,'start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>75)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>75)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gender'); ?>
		<?php echo $form->textField($model,'gender',array('size'=>6,'maxlength'=>6)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_of_birth'); ?>
		<?php echo $form->textField($model,'date_of_birth'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ni_no'); ?>
		<?php echo $form->textField($model,'ni_no',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nationality'); ?>
		<?php echo $form->textField($model,'nationality',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'passport_no'); ?>
		<?php echo $form->textField($model,'passport_no',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'passport_issue_date'); ?>
		<?php echo $form->textField($model,'passport_issue_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'passport_expiry_date'); ?>
		<?php echo $form->textField($model,'passport_expiry_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'visa_type'); ?>
		<?php echo $form->textField($model,'visa_type',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'visa_no'); ?>
		<?php echo $form->textField($model,'visa_no',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'visa_issue_date'); ?>
		<?php echo $form->textField($model,'visa_issue_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'visa_expiry_date'); ?>
		<?php echo $form->textField($model,'visa_expiry_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pay_type_id'); ?>
		<?php echo $form->textField($model,'pay_type_id',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'company_name'); ?>
		<?php echo $form->textArea($model,'company_name',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'company_no'); ?>
		<?php echo $form->textField($model,'company_no',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_of_incorporation'); ?>
		<?php echo $form->textField($model,'date_of_incorporation'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bank_details'); ?>
		<?php echo $form->textArea($model,'bank_details',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sort_code'); ?>
		<?php echo $form->textField($model,'sort_code',array('size'=>6,'maxlength'=>6)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_no'); ?>
		<?php echo $form->textField($model,'account_no',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mobile_no'); ?>
		<?php echo $form->textField($model,'mobile_no',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'telephone'); ?>
		<?php echo $form->textField($model,'telephone',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'address_1'); ?>
		<?php echo $form->textArea($model,'address_1',array('rows'=>6, 'cols'=>50)); ?>
	</div>
    
    	<div class="row">
		<?php echo $form->label($model,'address_2'); ?>
		<?php echo $form->textArea($model,'address_2',array('rows'=>6, 'cols'=>50)); ?>
	</div>
    
    	<div class="row">
		<?php echo $form->label($model,'city'); ?>
		<?php echo $form->textArea($model,'city',array('rows'=>6, 'cols'=>50)); ?>
	</div>
    
    	<div class="row">
		<?php echo $form->label($model,'town'); ?>
		<?php echo $form->textArea($model,'town',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'post_code'); ?>
		<?php echo $form->textField($model,'post_code',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'country'); ?>
		<?php echo $form->textField($model,'country',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dbs_number'); ?>
		<?php echo $form->textField($model,'dbs_number',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dbs_issue_date'); ?>
		<?php echo $form->textField($model,'dbs_issue_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dbs_expiry'); ?>
		<?php echo $form->textField($model,'dbs_expiry'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mandatory_training_expiry_date'); ?>
		<?php echo $form->textField($model,'mandatory_training_expiry_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pmva_expiry_date'); ?>
		<?php echo $form->textField($model,'pmva_expiry_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'maybo_training_expiry'); ?>
		<?php echo $form->textField($model,'maybo_training_expiry'); ?>
	</div>
    
                  <div class="row">
		<?php echo $form->label($model,'mapa_expiry_date'); ?>
		<?php echo $form->textField($model,'mapa_expiry_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pin_expiry_date'); ?>
		<?php echo $form->textField($model,'pin_expiry_date'); ?>
	</div>
    
                  <div class="row">
		<?php echo $form->label($model,'re_validation_renewal_date'); ?>
		<?php echo $form->textField($model,'re_validation_renewal_date'); ?>
	</div>
    
                  <div class="row">
		<?php echo $form->label($model,'medication_assessment_completed_date'); ?>
		<?php echo $form->textField($model,'medication_assessment_completed_date'); ?>
	</div>
    
    	<div class="row">
		<?php echo $form->label($model,'pin_number'); ?>
		<?php echo $form->textField($model,'pin_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'max_allowed_hour'); ?>
		<?php echo $form->textField($model,'max_allowed_hour'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shift_confirmation_count'); ?>
		<?php echo $form->textField($model,'shift_confirmation_count',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shift_cancellation_count'); ?>
		<?php echo $form->textField($model,'shift_cancellation_count',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'staff_status'); ?>
		<?php echo $form->textField($model,'staff_status',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->