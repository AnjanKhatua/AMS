<?php
/* @var $this StaffRegistrationPreferredWorkAreaMapTableController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Staff Registration Preferred Work Area Map Tables',
);

$this->menu=array(
	array('label'=>'Create StaffRegistrationPreferredWorkAreaMapTable', 'url'=>array('create')),
	array('label'=>'Manage StaffRegistrationPreferredWorkAreaMapTable', 'url'=>array('admin')),
);
?>

<h1>Staff Registration Preferred Work Area Map Tables</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
