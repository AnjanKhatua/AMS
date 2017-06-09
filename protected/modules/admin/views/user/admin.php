<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = array(
    'Users' => array('index'),
    'Manage',
);

$this->menu = array(
//	array('label'=>'List User', 'url'=>array('index')),
    array('label' => 'Create User', 'url' => array('create'), 'visible' => Utility::checkLoginPerson($_SESSION[logged_user][type])),
    array('label' => 'Change Password', 'url' => array('default/ChangePassword'), 'visible' => Utility::checkLoginPerson($_SESSION[logged_user][type])),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Users</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

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
    'id' => 'user-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'mobile',
        array("name" => "type", "value" => 'Utility::checkStaffType($data->type)'),
        /*
          'password',
          'mobile',
          'address',
          'type',
          'staff_id',
          'image',
          'active_status',
         */
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
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
