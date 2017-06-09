<?php
/* @var $this HospitalUnitController */
/* @var $model HospitalUnit */

$this->breadcrumbs = array(
    'Hospitals' => array('index'),
        //$model->hospital_unit_id,
);

$this->menu = array(
    //array('label'=>'List HospitalUnit', 'url'=>array('index')),
//    array('label' => 'Create Hospital', 'url' => array('create'), 'visible' => Utility::checkLoginPerson($_SESSION[logged_user][type])),
//    array('label' => 'Update Hospital', 'url' => array('update', 'id' => $model->hospital_unit_id), 'visible' => Utility::checkLoginPerson($_SESSION[logged_user][type])),
//    array('label' => 'Delete Hospital', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->hospital_unit_id), 'confirm' => 'Are you sure you want to delete this item?'), 'visible' => Utility::checkLoginPerson($_SESSION[logged_user][type])),
    array('label' => 'Manage Hospital', 'url' => array('admin')),
);
?>

<?php
if($_GET['id'] == 0){
    ?>
<script type='text/javascript'>
    $(function ()
    {
        $('.boxDiv').hide();
    })
</script>
<?php
}

$ls_sqlForHospital = "SELECT h.hospital_unit_id, h.hospital_unit FROM {{hospital_unit}} h WHERE h.hospital_unit_active_status='Y' ORDER BY h.hospital_unit";

$ls_resultForHospital = Yii::app()->db->createCommand($ls_sqlForHospital)->queryAll();
$la_units = array("0" => "All Hospital");
foreach ($ls_resultForHospital as $la_value) {
    $key = $la_value['hospital_unit_id'];
    $value = $la_value['hospital_unit'];
    $la_units[$key] = $value;
}
?>

<h1>View event calendar for <?php echo CHtml::dropDownList('id', $_REQUEST['id'], $la_units); ?><input type="hidden" id="hospital_unit_id" value="<?php echo $model->hospital_unit_id; ?>"></h1>
<div id='calendar'></div>

<!-- Trigger the modal with a button -->
<div class="btninfo" data-toggle="modal" data-target="#myModal"></div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">AMS</h4>
            </div>
            <form id="staffDetailsForm">
                <div class="modal-body">
                    <h5><div id="staffDetails"></div></h5>
                    <hr>
                    <div id="shiftDetails"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="assign" data-dismiss="modal">Allocate shift</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script type='text/javascript'>
    $(function ()
    {
        $("#id").change(function () {
            var hospitalUnitId = $(this).val();
            var curUrl = window.location.href;
            var res = curUrl.split("&");
            var newUrl = res[0] + "&id=" + hospitalUnitId;
            location.href = newUrl;
        })
    })
</script>