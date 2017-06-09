<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->dropDownList($model,'gender',array(""=>"Select gender","Male"=>"Male", "Female"=>"Female")); ?>
		<?php echo $form->error($model,'gender'); ?>
	</div>
        
                  
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
        
                  <div class="row">
		<?php echo $form->labelEx($model,'date_of_birth'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'User[date_of_birth]',
                                                'value'=>$model->date_of_birth,
                                                    'options'=>array(
                                                            'showAnim'=>'fold',
                                                            'dateFormat'=>'dd-mm-yy',
                                                            'changeMonth'=>true,
                                                            'changeYear'=>true,
                                                            'yearRange'=>'1940:2100',
                                                            'minDate' => '01-01-1940',     
                                                            'maxDate' => '31-12-2100',
			),
                                                'htmlOptions'=>array(
                                                'style'=>'height:20px;'
                                                ),
                                            ));
                                        ?>
		<?php echo $form->error($model,'date_of_birth'); ?>
	</div>
        
                  
                
	<div class="row">
		<?php echo $form->labelEx($model,'mobile'); ?>
		<?php echo $form->textField($model,'mobile',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'mobile'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',array(""=>"Select type", "A"=>"Admin", "C"=>"Co-ordinator",  "D"=>"Director", "F"=>"Finance", "M"=>"Manager")); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active_status'); ?>
		<?php echo $form->dropDownList($model,'active_status',array("Y"=>"Yes","N"=>"No")); ?>
		<?php echo $form->error($model,'active_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->