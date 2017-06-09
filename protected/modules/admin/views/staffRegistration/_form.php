<?php
/* @var $this StaffRegistrationController */
/* @var $model StaffRegistration */
/* @var $form CActiveForm */
?>

<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/css/jquery.multiselect.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery.multiselect.js"></script>

<?php $la_allError = $model->getErrors(); ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'staff-registration-form',
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	  <?php echo $form->errorSummary($model); ?>
                    <?php $workModel = new StaffRegistrationPreferredWorkAreaMapTable ?>
                    <?php $selectedPayType=''; $selectedJobType=''; $selectedArea='';?>
        <div class="span4">
	<div class="row">
		<?php echo $form->labelEx($model,'start_date'); ?>
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'StaffRegistration[start_date]',
                                                'value'=>$model->start_date,
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
		<?php echo $form->error($model,'start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>75)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>75)); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->dropDownList($model,'gender',array(""=>"Select gender","Male"=>"Male", "Female"=>"Female")); ?>
		<?php echo $form->error($model,'gender'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_of_birth'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'StaffRegistration[date_of_birth]',
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
		<?php echo $form->labelEx($model,'ni_no'); ?>
		<?php echo $form->textField($model,'ni_no',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'ni_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nationality'); ?>
		<?php echo $form->textField($model,'nationality',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'nationality'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'passport_no'); ?>
		<?php echo $form->textField($model,'passport_no',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'passport_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'passport_issue_date'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'StaffRegistration[passport_issue_date]',
                                                'value'=>$model->passport_issue_date,
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
		<?php echo $form->error($model,'passport_issue_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'passport_expiry_date'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'StaffRegistration[passport_expiry_date]',
                                                'value'=>$model->passport_expiry_date,
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
		<?php echo $form->error($model,'passport_expiry_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visa_type'); ?>
		<?php echo $form->textField($model,'visa_type',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'visa_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visa_no'); ?>
		<?php echo $form->textField($model,'visa_no',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'visa_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visa_issue_date'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'StaffRegistration[visa_issue_date]',
                                                'value'=>$model->visa_issue_date,
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
		<?php echo $form->error($model,'visa_issue_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visa_expiry_date'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'StaffRegistration[visa_expiry_date]',
                                                'value'=>$model->visa_expiry_date,
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
		<?php echo $form->error($model,'visa_expiry_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pay_type_id'); ?>
		<?php $allPayType = PayType::model()->payTypeAll(); 
                                            $selectedPayType=$model->pay_type_id;
                                    ?>                                        
                                    <?php echo CHtml::dropDownList('StaffRegistration[pay_type_id]', $selectedPayType, $allPayType, array('single'=>'single'));?>
		<?php echo $form->error($model,'pay_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'company_name'); ?>
		<?php echo $form->textField($model,'company_name',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'company_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'company_no'); ?>
		<?php echo $form->textField($model,'company_no',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'company_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_of_incorporation'); ?>
                                        
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'StaffRegistration[date_of_incorporation]',
                                                'value'=>$model->date_of_incorporation,
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
		<?php echo $form->error($model,'date_of_incorporation'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bank_details'); ?>
		<?php echo $form->textField($model,'bank_details',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'bank_details'); ?>
	</div>
                       
	<div class="row">
		<?php echo $form->labelEx($model,'sort_code'); ?>
		<?php echo $form->textField($model,'sort_code',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'sort_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'account_no'); ?>
		<?php echo $form->textField($model,'account_no',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'account_no'); ?>
	</div>
            
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
            
                  <div class="row">
		<?php echo $form->labelEx($model,'mobile_no'); ?>
		<?php echo $form->textField($model,'mobile_no',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'mobile_no'); ?>
	</div>
            
                  <div class="row">
		<?php echo $form->labelEx($model,'telephone'); ?>
		<?php echo $form->textField($model,'telephone',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'telephone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address_1'); ?>
		<?php echo $form->textField($model,'address_1',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'address_1'); ?>
	</div>
            
        </div>
        <div class="span1"></div>
        <div class="span4">     
            <?php
            $userImage = User::model()->selectedUsers($model->staff_id); 
            if ($userImage[$model->staff_id] != "") {
                ?>
                <div class="row">
                    <span id="imag" style="width: 100px; height: 100px; border: 5px solid #b3b3b3">
                            <?php
                        echo CHtml::image(Yii::app()->request->baseUrl . '/userImage/' . $userImage[$model->staff_id], "image", array("width" => 150));
                        ?>
                   </span>
                </div>
            
                    <div class="row">
                        <hr>
                        <span style="font-size: 14px;">Change Image</span><input type="file" name="image">
                    </div>
                <?php
                }else{
                    ?>
                    <div class="row">
                        <hr>
                        <span style="font-size: 14px;">Change Image</span><input type="file" name="image">
                    </div>
            <?php
                }
                ?>
                  <div class="row">
		<?php echo $form->labelEx($model,'address_2'); ?>
		<?php echo $form->textField($model,'address_2',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'address_2'); ?>
	</div>
            
                  <div class="row">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>
        
                    <div class="row">
		<?php echo $form->labelEx($model,'town'); ?>
		<?php echo $form->textField($model,'town',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'town'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'post_code'); ?>
		<?php echo $form->textField($model,'post_code',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'post_code'); ?>
	</div>

	<div class="row">
                                        <?php
                                                if ($model->country == "") {
                                                    $name = "United Kingdom";
                                                } else {
                                                    $name = $model->country;
                                                }
                                            ?>
		<?php echo $form->labelEx($model,'country'); ?>
		<?php echo $form->textField($model,'country',array('size'=>60, 'value' => $name, 'maxlength'=>150)); ?>
		<?php echo $form->error($model,'country'); ?>
	</div>
        
                    <div class="row">
                                        <label>Job Type</label>
                                        <?php $allJobType = JobType::model()->jobTypeAll(); 
                                              if(isset($la_allError['job_type']) )
                                                  $selectedJobType = '';
                                              else
                                                $selectedJobType=$model->job_type;
                                            ?>  
                                        <?php echo CHtml::dropDownList('staffJobTypeMap[job_type][]', $selectedJobType, $allJobType, array('multiple'=>'multiple'));?>
                                        <?php echo $form->error($model,'job_type'); ?>
                    </div>
        
                    <div class="row">
                                        <label>Preferred Work Area</label>
                                        <?php $allWorkArea = WorkArea::model()->workPlaceCheckAll(); 
                                                    
                                                     if(isset($la_allError['area']) )
                                                         $selectedArea = '';
                                                     else
                                                         $selectedArea=$model->area;
                                            ?>
                                        <?php echo CHtml::dropDownList('workAreaMap[area][]', $selectedArea, $allWorkArea, array('multiple'=>'multiple'));?>
                                        <?php echo $form->error($model,'area'); ?>
                    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'dbs_number'); ?>
		<?php echo $form->textField($model,'dbs_number',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'dbs_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dbs_issue_date'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'StaffRegistration[dbs_issue_date]',
                                                'value'=>$model->dbs_issue_date,
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
		<?php echo $form->error($model,'dbs_issue_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dbs_expiry'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'StaffRegistration[dbs_expiry]',
                                                'value'=>$model->dbs_expiry,
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
		<?php echo $form->error($model,'dbs_expiry'); ?>
	</div>
            
            	<div class="row">
		<?php echo $form->labelEx($model,'last_dbs_check'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'StaffRegistration[last_dbs_check]',
                                                'value'=>$model->last_dbs_check,
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
		<?php echo $form->error($model,'last_dbs_check'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mandatory_training_expiry_date'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'StaffRegistration[mandatory_training_expiry_date]',
                                                'value'=>$model->mandatory_training_expiry_date,
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
		<?php echo $form->error($model,'mandatory_training_expiry_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pmva_expiry_date'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'StaffRegistration[pmva_expiry_date]',
                                                'value'=>$model->pmva_expiry_date,
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
		<?php echo $form->error($model,'pmva_expiry_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mapa_expiry_date'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'StaffRegistration[mapa_expiry_date]',
                                                'value'=>$model->mapa_expiry_date,
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
		<?php echo $form->error($model,'mapa_expiry_date'); ?>
	</div>
        
                  <div class="row">
		<?php echo $form->labelEx($model,'maybo_training_expiry'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'StaffRegistration[maybo_training_expiry]',
                                                'value'=>$model->maybo_training_expiry,
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
		<?php echo $form->error($model,'maybo_training_expiry'); ?>
	</div>
        
        	<div class="row">
		<?php echo $form->labelEx($model,'pin_number'); ?>
		<?php echo $form->textField($model,'pin_number',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'pin_number'); ?>
	</div>

                  <div class="row">
		<?php echo $form->labelEx($model,'pin_expiry_date'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'StaffRegistration[pin_expiry_date]',
                                                'value'=>$model->pin_expiry_date,
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
		<?php echo $form->error($model,'pin_expiry_date'); ?>
	</div>
            
                  <div class="row">
		<?php // echo $form->labelEx($model,'re-validation_renewal_date'); ?>
                                    <label>Re-validation Renewal Date</label>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'StaffRegistration[re_validation_renewal_date]',
                                                'value'=>$model->re_validation_renewal_date,
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
		<?php echo $form->error($model,'re_validation_renewal_date'); ?>
	</div>
            
                  <div class="row">
		<?php echo $form->labelEx($model,'medication_assessment_completed_date'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'StaffRegistration[medication_assessment_completed_date]',
                                                'value'=>$model->medication_assessment_completed_date,
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
		<?php echo $form->error($model,'medication_assessment_completed_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'max_allowed_hour'); ?>
		<?php echo $form->textField($model,'max_allowed_hour'); ?>
		<?php echo $form->error($model,'max_allowed_hour'); ?>
	</div>
            
                  <div class="row">
		<?php echo $form->labelEx($model,'references'); ?>
		<?php echo $form->textField($model,'references',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'references'); ?>
	</div> 
            
                  <div class="row">
		<?php echo $form->labelEx($model,'notes'); ?>
		<?php echo $form->textField($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'notes'); ?>
	</div> 

<!--	<div class="row">
		<?php // echo $form->labelEx($model,'image'); ?>
		<?php // echo $form->textField($model,'image',array('size'=>60,'maxlength'=>255)); ?>
		<?php // echo $form->error($model,'image'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'shift_confirmation_count'); ?>
		<?php // echo $form->textField($model,'shift_confirmation_count',array('size'=>5,'maxlength'=>5)); ?>
		<?php // echo $form->error($model,'shift_confirmation_count'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'shift_cancellation_count'); ?>
		<?php // echo $form->textField($model,'shift_cancellation_count',array('size'=>5,'maxlength'=>5)); ?>
		<?php // echo $form->error($model,'shift_cancellation_count'); ?>
	</div>-->
                    <?php 
                    if(isset($allFiles)){
                        $length = count($allFiles);
                        if($length!=0){ 
                        ?>
                    <table border="1" width="100%">
                        <tr>
                            <th>Type</th>
                            <th>Link</th>
                            <th>Action</th>
                        </tr>
                    <?php
                                            echo 'Uploaded files are : ';
                        foreach ($allFiles as $lv_doc) {
                            ?>
                        <tr>
                            <td><?php 
                            foreach($docTypes as $lv_type){
                                if($lv_type['document_header_id']==$lv_doc['document_header_id']){
                                    echo $lv_type['header_name'];
                                    break;
                                }
                            }
                            ?></td>
                            <td><a href="<?php $destdir = Yii::app()->baseUrl . '/staffDocuments/'; echo $destdir.$lv_doc['document_name']; ?>" download>Download</a></td>
                            <td><a href="<?php $params = array('documentId'=>$lv_doc['document_id']); $myUrl = Yii::app()->createUrl('admin/StaffRegistration/docDelete', $params); echo $myUrl;?>">Remove</a></td>
                        </tr>
                        
                        <?php
                    }
                    ?>
                    </table>
                    <?php
                    }else{
                        echo 'No files are uploaded';
                    }
                    }
                    ?>
                    
                    <div id="document"></div>
                    <?php $allDocType = DocumentHeader::model()->docTypeAll(); ?> 
                    <input type="button" name="addDocs" id="addDoc" value="Click to add Document" onClick='$( "#document" ).append("<tr><td><select name=\"docType[]\"><?php  foreach ($allDocType as $k => $lo_user) { ?><option value=\"<?php echo $k; ?>\"><?php echo $lo_user; ?></option><?php } ?></select></td><td><input type=\"file\" name=\"fileName[]\"/></td><td><input  type=button value=Remove class=\"ticket_text\" onClick=\" $(this).parent().parent().remove();\"></td></tr>" );'>

	<div class="row">
		<?php echo $form->labelEx($model,'staff_status'); ?>
		<?php echo $form->dropDownList($model,'staff_status',array("D"=>"Draft", "A"=>"Active","I"=>"Inactive", "S"=>"Suspended","Ar"=>"Archive")); ?>
		<?php echo $form->error($model,'staff_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
        </div>
<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
$(function() {
$("select#workAreaMap_area").multiselect();

//$( "#staff-registration-form" ).submit(function( event ) {
//    var count = $("select#workAreaMap_area :selected").length;
//    if(count==0)
//    {
//        $("#workAreaMap_area_msg").html('Please select area');
//        var errorDiv = $('#StaffRegistration_post_code').first();  /* Focusing this element to overcome relative position issue */
//        var scrollPos = errorDiv.offset().top;
//        $(window).scrollTop(scrollPos);
//        return false;
//    }
//    else
//        return true;
//})

$("select#staffJobTypeMap_job_type").multiselect();

//$( "#staff-registration-form" ).submit(function( event ) {
//    var count = $("select#staffJobTypeMap_job_type :selected").length;
//    if(count==0)
//    {
//        $("#jobTypeMap_msg").html('Please select job type');
//        var errorDiv = $('#StaffRegistration_post_code').first();  /* Focusing this element to overcome relative position issue */
//        var scrollPos = errorDiv.offset().top;
//        $(window).scrollTop(scrollPos);
//        return false;
//    }
//    else
//        return true;
//})

})
</script>