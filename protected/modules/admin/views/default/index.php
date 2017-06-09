<?php
/* @var $this DefaultController */

$this->breadcrumbs = array(
    $this->module->id,
);
?>
<h3>
    <p>
        Welcome <?php echo $_SESSION['logged_user']['first_name']; ?>!!
    </p>
</h3>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/js/chart.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/js/app.js"></script>
        <div id="chart-container">
            <canvas id="mycanvas"></canvas>
        </div>