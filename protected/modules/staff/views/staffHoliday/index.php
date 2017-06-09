<?php
/* @var $this StaffHolidayController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Staff Holidays',
);

$this->menu=array(
	array('label'=>'Create Staff Holiday', 'url'=>array('create')),
	array('label'=>'Manage Staff Holiday', 'url'=>array('admin')),
);
?>

<h1>Staff Holidays</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
