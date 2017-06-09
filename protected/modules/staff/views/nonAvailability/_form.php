<?php
/* @var $this NonAvailabilityController */
/* @var $model NonAvailability */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'non-availability-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'staff_id'); ?>
                                            <?php 
                                                $name = $_SESSION['logged_user']['first_name']." ".$_SESSION['logged_user']['last_name'];
                                            ?>
		<?php echo $form->textField($model,'staff_id',array('size'=>10,'value'=>$name, 'disabled' => true)); ?>
		<?php echo $form->error($model,'staff_id'); ?>
	</div>
                    <label>Regular non-availability</label>
	<div class="row">
		<?php echo $form->labelEx($model,'start_date'); ?>
                                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'NonAvailability[start_date]',
                                                'value'=>$model->start_date,
                                                    'options'=>array(
                                                            'showAnim'=>'fold',
                                                            'dateFormat'=>'dd-mm-yy',
                                                            'changeMonth'=>true,
                                                            'changeYear'=>true,
                                                            'yearRange'=>'1940:2016',
                                                            'minDate' => 'today',     
                                                            'maxDate' => '31-12-2016',
			),
                                                'htmlOptions'=>array(
                                                'style'=>'height:20px;'
                                                ),
                                            ));
                                        ?>
		<?php echo $form->error($model,'start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date'); ?>
                                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                'model' => $model,
                                                'name'=>'NonAvailability[end_date]',
                                                'value'=>$model->end_date,
                                                    'options'=>array(
                                                            'showAnim'=>'fold',
                                                            'dateFormat'=>'dd-mm-yy',
                                                            'changeMonth'=>true,
                                                            'changeYear'=>true,
                                                            'yearRange'=>'1940:2016',
                                                            'minDate' => 'today',
                                                            'maxDate' => '31-12-2016',
			),
                                                'htmlOptions'=>array(
                                                'style'=>'height:20px;'
                                                ),
                                            ));
                                        ?>
		<?php echo $form->error($model,'end_date'); ?>
	</div>

	<div class="row">
                                        <label>Regular non-availability</label>
		<?php echo $form->labelEx($model,'start_time'); ?>
		<?php 
                                            $this->widget('application.extensions.timepicker.EJuiDateTimePicker',array(
                                                            'model'=>$model,
                                                            'attribute'=>'start_time',
                                                            'options'=>array(
                                                            'showAnim'=>'slide',
                                                            'timeOnly'=>true,
                                                            'timeFormat' => 'hh:mm',
                                                            'dateFormat'=>'dd-mm-yy',
                                                            'changeMonth' => true,
                                                            'changeYear' => true,
                                                            ),
                                                ));
                                            ?>
		<?php echo $form->error($model,'start_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_time'); ?>
		<?php 
                                            $this->widget('application.extensions.timepicker.EJuiDateTimePicker',array(
                                                            'model'=>$model,
                                                            'attribute'=>'end_time',
                                                            'options'=>array(
                                                            'showAnim'=>'slide',
                                                            'timeOnly'=>true,
                                                            'timeFormat' => 'hh:mm',
                                                            'dateFormat'=>'dd-mm-yy',
                                                            'changeMonth' => true,
                                                            'changeYear' => true,
                                                            ),
                                                ));
                                            ?>
		<?php echo $form->error($model,'end_time'); ?>
	</div>
        
        
                    <div class="row block_existing_records">
                            <?php 
                                if(count($chkData)!=0){
                                    ?>
                        <h4 style="color: #f00">Already exists non availabilities are : </h4>
                        <table border="1" width="100%">
                        <tr>
                            <th>Non availablility id</th>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                        </tr>
                        <?php
                            foreach ($chkData as $dataAll) {
                                if($dataAll['already_booked'] == 'N'){
                                ?>
                        <tr>
                            <td><?php echo $dataAll['non_availablility_id']?></td>
                            <td><?php echo Utility::changeDateToUK($dataAll['date']);?></td>
                            <td><?php echo $dataAll['start_time']?></td>
                            <td><?php echo $dataAll['end_time']?></td>
                        </tr>
                        <?php
                                }
                            }
                        ?>
                        </table>
                        <?php
                                }
                            ?>
                    </div>
                    
                    <div class="row block_existing_records">
                            <?php 
                                if(count($chkData1)!=0){
                                    ?>
                        <h4 style="color: #f00">Confirm bookings are : </h4>
                        <table border="1" width="100%">
                        <tr>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                        </tr>
                        <?php
                            foreach ($chkData1 as $dataAll) {
                                if($dataAll['already_booked'] == "Y"){
                                ?>
                        <tr>
                            <td><?php echo Utility::changeDateToUK($dataAll['date']);?></td>
                            <td><?php echo $dataAll['start_time']?></td>
                            <td><?php echo $dataAll['end_time']?></td>
                        </tr>
                        <?php
                                }
                            }
                        ?>
                        </table>
                        <?php
                                }
                            ?>
                    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
// $(function()
// {
// $(".shift_remove").click(function(){
//     
//     var li_id = $(this).attr('id');
//     var ls_url = '<?php echo Yii::app()->baseUrl ?>/index.php?r=staff/nonAvailability/DateDelete';
//    $.ajax({url: ls_url,type:'POST', 
//        data:{id:li_id,state_date:$('#NonAvailability_start_date').val(),end_date:$('#NonAvailability_end_date').val(),start_time:$('#NonAvailability_start_time').val(),end_time:$('#NonAvailability_end_time').val()},success: function(result){
//        $("#block_existing_records").html(result);
//    }});
//// return false;
//});
// });
// 
 </script>