<?php
/* @var $this DefaultController */

$this->breadcrumbs = array(
    $this->module->id,
);
?>
<?php
//echo '<pre>';
//print_r($_SESSION['logged_user']) ; 
//echo '</pre>';
?>
<?php // echo Yii::app()->basePath . '/../userImage/' . $_SESSION['logged_user']['image'];        ?>
<div class="container">
    <div class="contains">
        <div class="contain">
            <div class="mg_contain">            
                <span id="imag">
                    <?php
                    if ($_SESSION['logged_user']['image'] != "") {
                        echo CHtml::image(Yii::app()->request->baseUrl . '/userImage/' . $_SESSION['logged_user']['image'], "image", array("width" => 150));
                    }
                    ?>
                </span>
            </div>
            <div class="lower_panel">
                <label id="image">Change image</label>
            </div>
        </div>
    </div>
    <div class="col-md-1">
    </div>
    <div class="info">
        <div> 	
            <center>
                <span style="font-size:20px">Welcome <span style="font-size:20px"><?php echo $_SESSION['logged_user']['first_name'] . " " . $_SESSION['logged_user']['last_name'] ?></span></span> 
            </center>
        </div>
        <div> 	
            <span style="font-size:15px">Your Email Id : <?php echo $_SESSION['logged_user']['email'] ?></span>
        </div>
        <div> 	
            <span style="font-size:15px">Address : <?php echo $_SESSION['logged_user']['address'] ?></span> 
        </div>
        <div> 
            <span style="font-size:15px">Mobile : <?php echo $_SESSION['logged_user']['mobile'] ?></span>
        </div>
        <?php
        $sqlQueryForStaff = "SELECT * FROM {{staff_registration}} WHERE `staff_id` = " . $_SESSION['logged_user']['staff_id'];
        $commandForStaff = Yii::app()->db->createCommand($sqlQueryForStaff)->queryAll();
        ?>
        <hr> 
        <center>
            <span style="font-size:20px">Reminder of your profile</span> 
        </center>
        <hr>
        <div> 
            <span style="font-size:15px">Passport expiry date : <?php echo Utility::changeDateToUK($commandForStaff[0]['passport_expiry_date']); ?></span>
        </div>
        <div> 
            <span style="font-size:15px">Visa expiry date : <?php echo Utility::changeDateToUK($commandForStaff[0]['visa_expiry_date']); ?></span>
        </div>
        <div> 
            <span style="font-size:15px">Dbs expiry : <?php echo Utility::changeDateToUK($commandForStaff[0]['dbs_expiry']); ?></span>
        </div>
        <div> 
            <span style="font-size:15px">Mandatory training expiry date : <?php echo Utility::changeDateToUK($commandForStaff[0]['mandatory_training_expiry_date']); ?></span>
        </div>
        <div> 
            <span style="font-size:15px">Pmva expiry date : <?php echo Utility::changeDateToUK($commandForStaff[0]['pmva_expiry_date']); ?></span>
        </div>
        <div> 
            <span style="font-size:15px">Maybo training expiry : <?php echo Utility::changeDateToUK($commandForStaff[0]['maybo_training_expiry']); ?></span>
        </div>
        <div> 
            <span style="font-size:15px">Pin expiry date : <?php echo Utility::changeDateToUK($commandForStaff[0]['pin_expiry_date']); ?></span>
        </div>        
    </div>	
    <div class="clearfix"> </div>
</div>
<div id="pos" style="float: right">
    <form id="image_uplode" action="<?php echo Yii::app()->createUrl('staff/default/ProfilePicture'); ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="image"/>
        <br>
        <input type="submit" value="Save"/>
    </form>
</div>

<script>
    $(document).ready(function () {
        $("#pos").hide();
        $("#image").click(function () {
            $("#pos").show();
        });
        $("form").submit(function () {
            $("#pos").hide();
        });
    });
</script>