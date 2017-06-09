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
//$lo_units = HospitalUnit::model()->findAll("hospital_unit_active_status='Y'");
//$la_units = CHtml::listData(HospitalUnit::model()->findAll("hospital_unit_active_status='Y'"), 'hospital_unit_id', 'hospital_unit');

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

<div id='calendars'></div>

<!--<script type='text/javascript'>
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
</script>-->

<script type='text/javascript'>
    $(function ()
    {
        $("#id").change(function () {
            var hospitalUnitId = $(this).val();
            var curUrl = window.location.href;
            if(hospitalUnitId != 0){
            var res = curUrl.split("/");
            var newUrl = '';
            for(i = 0; i < res.length; i++){
                if(i != res.length-1){
                    newUrl += res[i] + '/';
                }
            }
            var rest = res[res.length-1].split("&");
            newUrl += 'eventCalendar' + "&id=" + hospitalUnitId;
        }else{
            var res = curUrl.split("&");
            var newUrl = res[0] + "&id=" + hospitalUnitId;
            location.href = newUrl;
        }
            location.href = newUrl;
        })
    })
</script>