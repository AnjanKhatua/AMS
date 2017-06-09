<?php
/* @var $this HospitalRegistrationController */
/* @var $model HospitalRegistration */
/* @var $modelUnit HospitalUnit */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'hospital-registration-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'hospital_name'); ?>
		<?php echo $form->textField($model,'hospital_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'hospital_name');?>
		<div id="hospital_name_error" class="errorMessage" style="display:none"></div>
    </div>
	<div class="row">
		<?php echo $form->labelEx($model,'hospital_status'); ?>
		<?php echo $form->dropDownList($model,'hospital_status',array("A"=>"Active", "I"=>"Inactive", "S"=>"Suspended")); ?>
		<?php echo $form->error($model,'hospital_status'); ?>
	</div>
        <?php
        if($model->isNewRecord) {
        ?>
    <h4>Create Hospital Unit</h4>
	<div id="accordian">
		<div class="hospital_unit">
			
			<h4 class="header" title="Click to collapse/expand" style="cursor:pointer">New Unit</h4>
			<!--<span class="remove_unit">Remove unit</span>-->
			<div class="container">
				
				<div class="row">
					<?php echo $form->labelEx($modelunit,'hospital_unit'); ?>
					<?php echo $form->textField($modelunit,'hospital_unit[]',array('size'=>60,'maxlength'=>255,'class'=>"hospital_unit_text")); ?>
					<?php //echo $form->error($modelunit,'hospital_unit'); ?>
					<div id="hospital_unit_error" class="errorMessage" style="display:none"></div>
				</div>
			
				<div class="row">
					<?php echo $form->labelEx($modelunit,'address'); ?>
					<?php echo $form->textArea($modelunit,'address[]',array('rows'=>6, 'cols'=>50)); ?>
					<?php echo $form->error($modelunit,'address'); ?>
					<div id="hospital_address_error" class="errorMessage" style="display:none"></div>
				</div>
				 <?php $selectedWorkPlace='';?>
				<div class="row">
					<?php
					if(!$modelunit->isNewRecord) {
						$selectedWorkPlace = $modelunit->local_area_id;
						}
					?>
					<?php echo $form->labelEx($modelunit,'local_area_id'); ?>
					<?php $allWorkPlace = WorkArea::model()->workPlaceAll(); ?>                                        
					<?php echo CHtml::dropDownList('HospitalUnit[local_area_id][]', $selectedWorkPlace, $allWorkPlace, array('single'=>'single'));?>
					<?php echo $form->error($modelunit,'local_area_id'); ?>
					<div id="hospital_local_area_id_error" class="errorMessage" style="display:none"></div>
				</div>
			
				<div class="row">
					<?php echo $form->labelEx($modelunit,'email'); ?>
					<?php echo $form->emailField($modelunit,'email[]',array('size'=>60,'maxlength'=>150)); ?>
					<?php echo $form->error($modelunit,'email'); ?>
					<div id="hospital_email_error" class="errorMessage" style="display:none"></div>
				</div>
			
				<div class="row">
					<?php echo $form->labelEx($modelunit,'contact_number'); ?>
					<?php echo $form->textField($modelunit,'contact_number[]',array('size'=>10,'maxlength'=>10)); ?>
					<?php echo $form->error($modelunit,'contact_number'); ?>
					<div id="hospital_contact_error" class="errorMessage" style="display:none"></div>
				</div>
			
				<div class="row">
					<?php echo $form->labelEx($modelunit,'hospital_unit_active_status'); ?>
					<?php echo $form->dropDownList($modelunit,'hospital_unit_active_status[]',array("Y"=>"Yes", "N"=>"No")); ?>
					<?php echo $form->error($modelunit,'hospital_unit_active_status'); ?>
				</div>
			</div>
			<hr />
		</div>
		<div><a href="javascript:void(0);" id="add-more">Add More Unit</a></div>
	</div>

    <?php
    
        }
        if(!$model->isNewRecord){
        ?>
		<h4>Manage Hospital Units</h4>
		<div id="hospital-registration-grid" class="grid-view">
		<table>
			<tr><th>Hospital Unit</th><th>Address</th><th>Area Name</th><th>Email</th><th>Contact Number</th><th>Status</th><th>Action</th></tr>
			<?php
			foreach($modelunit as $row){
				echo "<tr><td>".$row['hospital_unit']."</td><td>".$row['address']."</td><td>".$row['local_area_id']."</td><td>".$row['email']."</td><td>".$row['contact_number']."</td><td>".$row['hospital_unit_active_status']."</td><td><a href='/agencyManagementSystem/index.php?r=admin/hospitalRegistration/delete&id=".$row['hospital_unit_id']."'><img alt='Delete' src='/agencyManagementSystem/assets/191ecbea/gridview/delete.png'></a></td></tr>";
			}
			?>
		</table>
		</div>
		<?php }?>
    <div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->