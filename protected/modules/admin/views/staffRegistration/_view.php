<?php
/* @var $this StaffRegistrationController */
/* @var $data StaffRegistration */
?>

<div class="view listView">

	<b><?php echo CHtml::encode($data->getAttributeLabel('staff_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->staff_id), array('view', 'id'=>$data->staff_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date')); ?>:</b>
	<?php echo CHtml::encode(Utility::changeDateToUK($data->start_date)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
	<?php echo CHtml::encode($data->first_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
	<?php echo CHtml::encode($data->last_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo CHtml::encode($data->gender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_of_birth')); ?>:</b>
	<?php echo CHtml::encode(Utility::changeDateToUK($data->date_of_birth)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ni_no')); ?>:</b>
	<?php echo CHtml::encode($data->ni_no); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('nationality')); ?>:</b>
	<?php echo CHtml::encode($data->nationality); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('passport_no')); ?>:</b>
	<?php echo CHtml::encode($data->passport_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('passport_issue_date')); ?>:</b>
	<?php echo CHtml::encode($data->passport_issue_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('passport_expiry_date')); ?>:</b>
	<?php echo CHtml::encode($data->passport_expiry_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('visa_type')); ?>:</b>
	<?php echo CHtml::encode($data->visa_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('visa_no')); ?>:</b>
	<?php echo CHtml::encode($data->visa_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('visa_issue_date')); ?>:</b>
	<?php echo CHtml::encode($data->visa_issue_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('visa_expiry_date')); ?>:</b>
	<?php echo CHtml::encode($data->visa_expiry_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pay_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->pay_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_name')); ?>:</b>
	<?php echo CHtml::encode($data->company_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_no')); ?>:</b>
	<?php echo CHtml::encode($data->company_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_of_incorporation')); ?>:</b>
	<?php echo CHtml::encode($data->date_of_incorporation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bank_details')); ?>:</b>
	<?php echo CHtml::encode($data->bank_details); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sort_code')); ?>:</b>
	<?php echo CHtml::encode($data->sort_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_no')); ?>:</b>
	<?php echo CHtml::encode($data->account_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mobile_no')); ?>:</b>
	<?php echo CHtml::encode($data->mobile_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telephone')); ?>:</b>
	<?php echo CHtml::encode($data->telephone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address_1')); ?>:</b>
	<?php echo CHtml::encode($data->address_1); ?>
	<br />
          
          	<b><?php echo CHtml::encode($data->getAttributeLabel('address_2')); ?>:</b>
	<?php echo CHtml::encode($data->address_2); ?>
	<br />
         
                    <b><?php echo CHtml::encode($data->getAttributeLabel('city')); ?>:</b>
	<?php echo CHtml::encode($data->city); ?>
	<br />
         
                    <b><?php echo CHtml::encode($data->getAttributeLabel('town')); ?>:</b>
	<?php echo CHtml::encode($data->town); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('post_code')); ?>:</b>
	<?php echo CHtml::encode($data->post_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country')); ?>:</b>
	<?php echo CHtml::encode($data->country); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('job_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->job_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dbs_number')); ?>:</b>
	<?php echo CHtml::encode($data->dbs_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dbs_issue_date')); ?>:</b>
	<?php echo CHtml::encode($data->dbs_issue_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dbs_expiry')); ?>:</b>
	<?php echo CHtml::encode($data->dbs_expiry); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mandatory_training_expiry_date')); ?>:</b>
	<?php echo CHtml::encode($data->mandatory_training_expiry_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pmva_expiry_date')); ?>:</b>
	<?php echo CHtml::encode($data->pmva_expiry_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('maybo_training_expiry')); ?>:</b>
	<?php echo CHtml::encode($data->maybo_training_expiry); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pin_expiry_date')); ?>:</b>
	<?php echo CHtml::encode($data->pin_expiry_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_allowed_hour')); ?>:</b>
	<?php echo CHtml::encode($data->max_allowed_hour); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_confirmation_count')); ?>:</b>
	<?php echo CHtml::encode($data->shift_confirmation_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_cancellation_count')); ?>:</b>
	<?php echo CHtml::encode($data->shift_cancellation_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('staff_status')); ?>:</b>
	<?php echo CHtml::encode($data->staff_status); ?>
	<br />

	*/ ?>

</div>