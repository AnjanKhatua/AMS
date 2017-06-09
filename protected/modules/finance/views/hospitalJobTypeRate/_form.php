<?php
/* @var $this HospitalJobTypeRateController */
/* @var $model HospitalJobTypeRate */
/* @var $form CActiveForm */
?>

<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ?>/css/jquery.multiselect.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/js/jquery.multiselect.js"></script>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'hospital-job-type-rate-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'hospital_unit_id'); ?>
        <?php
        if (!$model->isNewRecord) {
            $getName = HospitalUnit::model()->allHospital($model->hospital_unit_id);
            $SelectedGetName = $model->hospital_unit_id;
            echo CHtml::dropDownList('HospitalJobTypeRate[hospital_unit_id]', $SelectedGetName, $getName, array('single' => 'single', 'disabled' => true));
        } elseif ($model->isNewRecord) {
            $getName = HospitalUnit::model()->allHospital($model->hospital_unit_id);
            $SelectedGetName = $model->hospital_unit_id;
            echo CHtml::dropDownList('HospitalJobTypeRate[hospital_unit_id]', $SelectedGetName, $getName, array('multiple' => 'multiple'));
        }
        ?>
        <?php // echo $form->textField($model,'hospital_unit_id',array('size'=>10,'maxlength'=>10));  ?>
        <?php echo $form->error($model, 'hospital_unit_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'finance_job_type_id'); ?>
        <?php
        $allJobType = JobTypeForFinance::model()->jobTypeOfFinance();
        $selectedJobType = $model->finance_job_type_id;
        ?>
        <?php
        if ($model->isNewRecord)
            echo CHtml::dropDownList('HospitalJobTypeRate[finance_job_type_id]', $selectedJobType, $allJobType, array('multiple' => 'multiple'));
        ?>
        <?php
        if (!$model->isNewRecord)
            echo CHtml::dropDownList('HospitalJobTypeRate[finance_job_type_id]', $selectedJobType, $allJobType, array('single' => 'single', 'disabled' => true));
        ?>
        <?php // echo $form->textField($model,'finance_job_type_id',array('size'=>10,'maxlength'=>10));  ?>
        <?php echo $form->error($model, 'finance_job_type_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'rate'); ?>
        <?php echo $form->textField($model, 'rate'); ?>
        <?php echo $form->error($model, 'rate'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'pay_rate_for_staffs'); ?>
        <?php echo $form->textField($model, 'pay_rate_for_staffs'); ?>
        <?php echo $form->error($model, 'pay_rate_for_staffs'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<?php
if ($model->isNewRecord) {
    ?>
    <script>
        $(function ()
        {
            $("select#HospitalJobTypeRate_finance_job_type_id").multiselect();
            $("select#HospitalJobTypeRate_hospital_unit_id").multiselect();
        })
    </script> 
    <?php
}
?>