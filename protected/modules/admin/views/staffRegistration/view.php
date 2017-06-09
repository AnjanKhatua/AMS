<?php
/* @var $this StaffRegistrationController */
/* @var $model StaffRegistration */

$this->breadcrumbs=array(
	'Staff Registrations'=>array('index'),
	$model->staff_id,
);

$this->menu=array(
//	array('label'=>'List Staff Registration', 'url'=>array('index')),
	array('label'=>'Create Staff Registration', 'url'=>array('create'),'visible'=>Utility::checkLoginPerson($_SESSION[logged_user][type])),
	array('label'=>'Update Staff Registration', 'url'=>array('update', 'id'=>$model->staff_id),'visible'=>Utility::checkLoginPerson($_SESSION[logged_user][type])),
	array('label'=>'Delete Staff Registration', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->staff_id),'confirm'=>'Are you sure you want to delete this item?'),'visible'=>Utility::checkLoginPerson($_SESSION[logged_user][type])),
	array('label'=>'Manage Staff Registration', 'url'=>array('admin')),
);
?>

<h1>View Staff Registration #<?php echo $model->staff_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'staff_id',
		'start_date',
		'first_name',
		'last_name',
		'gender',
		'date_of_birth',
		'ni_no',
		'nationality',
		'passport_no',
		'passport_issue_date',
		'passport_expiry_date',
		'visa_type',
		'visa_no',
		'visa_issue_date',
		'visa_expiry_date',
                                        array(
                                            'name'=>'pay_type',
                                            'value'=>$model->payType->pay_type,
                                        ),
		'company_name',
		'company_no',
		'date_of_incorporation',
		'bank_details',
		'sort_code',
		'account_no',
		'email',
		'mobile_no',
		'telephone',
		'address_1',
                                        'address_2',
                                        'city',
                                        'town',
		'post_code',
		'country',
                                        array(
                                                'name'=>'job_type',
                                                'value'=>$jobAll,
                                            ),
                                        array(
                                                'name'=>'preferred_work_area',
                                                'value'=>$areaAll,
                                            ),
		'dbs_number',
		'dbs_issue_date',
		'dbs_expiry',
                                    'last_dbs_check',
		'mandatory_training_expiry_date',
		'pmva_expiry_date',
		'maybo_training_expiry',
                                    'mapa_expiry_date',
                                    'pin_number',
		'pin_expiry_date',
                                    're_validation_renewal_date',
                                    'medication_assessment_completed_date',
		'max_allowed_hour',
		'staff_status',
                                    'references',
                                    'notes',
	),
)); ?>
