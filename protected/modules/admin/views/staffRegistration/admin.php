<?php
/* @var $this StaffRegistrationController */
/* @var $model StaffRegistration */

$this->breadcrumbs = array(
    'Staff Registrations' => array('index'),
    'Manage',
);

$this->menu = array(
//	array('label'=>'List StaffRegistration', 'url'=>array('index')),
    array('label' => 'Create Staff Registration', 'url' => array('create'), 'visible' => Utility::checkLoginPerson($_SESSION[logged_user][type])),
    array('label' => 'Change Password', 'url' => array('default/ChangePassword'), 'visible' => Utility::checkLoginPerson($_SESSION[logged_user][type])),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#staff-registration-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Staff Registrations</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
<li><p>Notify all active staff for next 1 week booking info : 
        <?php
        echo CHtml::button('Send Mail', array(
            'submit' => array('StaffRegistration/SendAllSMSOrMail', 'action' => 'mail'),
            'confirm' => 'Are you sure to send mail?'
        ));
        ?> 
        or 
        <?php
        echo CHtml::button('Send SMS', array(
            'submit' => array('StaffRegistration/SendAllSMSOrMail', 'action' => 'sms'),
            'confirm' => 'Are you sure to send sms?'
        ));
        ?>
    </p></li>
<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'staff-registration-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'staff_id',
//        array("name" => "start_date", "value" => 'Utility::changeDateToUK($data->start_date)'),
        'first_name',
        'last_name',
        'email',
        'mobile_no',
        'gender',
        array("name" => "areaName", "value" => 'Utility::getAreaForStaff($data->staff_id)'),
        /*
          'ni_no',
          'nationality',
          'passport_no',
          'passport_issue_date',
          'passport_expiry_date',
          'visa_type',
          'visa_no',
          'visa_issue_date',
          'visa_expiry_date', */
//        array(
//            'name' => 'pay_type',
//            'value' => '$data->payType->pay_type',
//        ),
        /*
          'company_name',
          'company_no',
          'date_of_incorporation',
          'bank_details',
          'sort_code',
          'account_no',

          'telephone',
          'address_1',
          'address_2',
          'city',
          'town',
          'post_code',
          'country',
          'job_type_id',
          'dbs_number',
          'dbs_issue_date',
          'dbs_expiry',
          'mandatory_training_expiry_date',
          'pmva_expiry_date',
          'maybo_training_expiry',
          'mapa_expiry_date',
          'pin_expiry_date',
          'max_allowed_hour',
          'shift_confirmation_count',
          'shift_cancellation_count',
          'staff_status',
         */
        array(
            'header' => 'Booking Notification',
            'class' => 'CButtonColumn',
            'template' => '{Mail}{or}{SMS}',
            'buttons' => array
                (
                'Mail' => array
                    (
                    'label' => 'Mail',
                    'url' => 'Yii::app()->createUrl("admin/StaffRegistration/SendSMSOrMail", array("id"=>$data->staff_id, "email"=>$data->email, "mobile"=>""))',
                    'visible' => ' !Yii::app()->user->isGuest',
                    'click' => "function(){ 
                    var labelText = $(this).text();
                    var obj = $(this);
                  $.ajax({
                            url: $(this).attr('href'),
                            success: function() { 
                                alert('Mail has been successfully sent');
                        },
                            error: function() { alert('Error in mail sending'); }
                         }); return false;}"
                ),
                'or' => array
                    (
                    'label' => ' / ',
                    'url' => '',
                ),
                'SMS' => array
                    (
                    'label' => 'SMS',
                    'url' => 'Yii::app()->createUrl("admin/StaffRegistration/SendSMSOrMail", array("id"=>$data->staff_id, "email"=>"", "mobile"=>$data->mobile_no))',
                    'visible' => ' !Yii::app()->user->isGuest',
                    'click' => "function(){ 
                    var labelText = $(this).text();
                    var obj = $(this);
                  $.ajax({
                            url: $(this).attr('href'),
                            success: function() { 
                                alert('SMS has been successfully sent');
                        },
                            error: function() { alert('Error in SMS sending'); }
                         }); return false;}"
                ),
            ),
        ),
        array(
            'header' => 'Change Password',
            'class' => 'CButtonColumn',
            'template' => '{Change Password}',
            'buttons' => array
                (
                'Change Password' => array
                    (
                    'label' => 'Go',
                    'url' => 'Yii::app()->createUrl("admin/default/ChangePassword", array("email"=>$data->email))',
                ),
            ),
            'visible' => Utility::checkLoginPerson($_SESSION[logged_user][type]),
        ),
        array(
            'header' => 'Action',
            'class' => 'CButtonColumn',
            'template' => '{update}{view}{delete}',
            'buttons' => array(
                'update' => array(
                    'visible' => 'Utility::checkLoginPerson($_SESSION[logged_user][type])',
                ),
                'view' => array(
                    'visible' => 'true',
                ),
                'delete' => array(
                    'visible' => 'Utility::checkLoginPerson($_SESSION[logged_user][type])',
                ),
            ),
        ),
    ),
));
?>
