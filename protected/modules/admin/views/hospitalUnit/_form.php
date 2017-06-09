<?php
/* @var $this HospitalUnitController */
/* @var $model HospitalUnit */
/* @var $form CActiveForm */
?>
<style>
    /*.row label:after { content:" *"; color:red;}*/
</style>
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/css/jquery.multiselect.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery.multiselect.js"></script>

<div class="form">
<?php $relevantCoordinator='';?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'hospital-unit-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        <?php $selectedTraining = '';?>
        <?php
        $selectedHospital=''; 
        $selectedWorkPlace='';
        $la_selectedUnit = array();
        if (!$model->isNewRecord) {
                $ls_selectedUnit = Ward::model()->selectedWards($model->hospital_unit_id);
                $la_selectedUnit = explode(',', $ls_selectedUnit);
        }
        ?>
	<div class="row">
		
		<?php echo $form->labelEx($model,'hospital_id'); ?>
		<?php $allHospital = HospitalRegistration::model()->hospitalAll(); ?>  
		<?php $selectedHospital = $model->hospital_id;?>                                      
		<?php echo CHtml::dropDownList('HospitalUnit[hospital_id]', $selectedHospital, $allHospital, array('single'=>'single'));?>
		<?php echo $form->error($model,'hospital_id'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'hospital_unit'); ?>
		<?php echo $form->textField($model,'hospital_unit',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'hospital_unit'); ?>
	</div>
                  <div class="row">
		
		<?php echo $form->labelEx($model,'wards'); ?>
		<?php $allWards = CHtml::listdata(Ward::model()->findAll(),'ward_id','ward_name'); ?> 
		
		<?php $selectedWard = $model->wards;?> 
                                    <?php echo CHtml::dropDownList('HospitalUnit[wards]', $selectedWard, $allWards, array('multiple'=>'multiple'));?>
                                    <?php echo $form->error($model,'wards'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'local_area_id'); ?>
		<?php $allWorkPlace = WorkArea::model()->workPlaceAll(); ?> 
		<?php $selectedWorkPlace = $model->local_area_id;?>                                       
		<?php echo CHtml::dropDownList('HospitalUnit[local_area_id]', $selectedWorkPlace, $allWorkPlace, array('single'=>'single'));?>
		<?php echo $form->error($model,'local_area_id'); ?>
	</div>

                  <div class="row">
		<?php echo $form->labelEx($model,'training_needed'); ?>
                                    
                                    <?php // $allTrainingType = AllTraining::model()->trainingTypeAll(); 
                                    if($model->training_needed != "")
                                            $selectedTraining=$model->training_needed;
                                            $allTraining = array("Mandatory Training"=>"Mandatory Training", "MAYBO"=>"MAYBO","PMVA"=>"PMVA", "MAPA"=>"MAPA");
                                    ?>
                                    <?php // echo CHtml::dropDownList('HospitalUnit[training_needed]', $selectedTraining, $allTrainingType, array('multiple' => 'multiple', 'id' => 'training_needed'));?>
                                    <?php echo $form->dropDownList($model, 'training_needed', $allTraining, array('multiple'=>'multiple')); ?>
		<?php echo $form->error($model,'training_needed'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'hospital_email'); ?>
		<?php echo $form->textField($model,'hospital_email',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'hospital_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_number'); ?>
		<?php echo $form->textField($model,'contact_number',array('size'=>10,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'contact_number'); ?>
	</div>
               
                  <div class="row">
		<?php echo $form->labelEx($model,'relevant_coordinator_id'); ?>
		<?php $allCoordinator = User::model()->allCoordinator(); 
                                            $relevantCoordinator=$model->relevant_coordinator_id;
                                                ?>                                        
                                        <?php echo CHtml::dropDownList('HospitalUnit[relevant_coordinator_id]', $relevantCoordinator, $allCoordinator, array('single'=>'single'));?>
		<?php echo $form->error($model,'relevant_coordinator_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hospital_unit_active_status'); ?>
		<?php echo $form->dropDownList($model,'hospital_unit_active_status',array("Y"=>"Yes", "N"=>"No")); ?>
		<?php echo $form->error($model,'hospital_unit_active_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
$(function() {
$("select#HospitalUnit_wards").multiselect();
$("select#HospitalUnit_training_needed").multiselect();
})
</script>
