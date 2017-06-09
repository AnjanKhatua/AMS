<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="row-fluid">
    <div class="span3">
        <div class="sidebar-nav">

            <?php
            $this->widget('zii.widgets.CMenu', array(
                /* 'type'=>'list', */
                'encodeLabel' => false,
                'items' => array(
                    //array('label'=>'<i class="icon icon-envelope"></i> Messages <span class="badge badge-success pull-right">12</span>', 'url'=>'#'),
                    // Include the operations menu
                    array('label' => 'OPERATIONS', 'items' => $this->menu),
//                                                                        array('label'=>'STAFF LIST','items'=>$this->staff),
                ),
            ));
            ?>
            <hr>
            <div class="boxDiv">
                STAFF LIST
            </div>
            <?php
            $sqlQueryForHospitalUnitArea = "SELECT * FROM {{hospital_unit}} h WHERE h.hospital_unit_id = " . $_GET['id'];
            $commandForHospitalUnitArea = Yii::app()->db->createCommand($sqlQueryForHospitalUnitArea)->queryAll();
            $sqlQueryForJobType = "SELECT * FROM {{job_type}}";
            $commandForJobType = Yii::app()->db->createCommand($sqlQueryForJobType)->queryAll();
            foreach ($commandForJobType AS $la_jobType) {
                ?>
            <div class="boxDiv">
                    <?php
                    echo $la_jobType['job_type'] . '<br>';
                    $allJobType = StaffRegistration::model()->staffJobTypeWise($la_jobType['job_type_id'], $commandForHospitalUnitArea[0]['local_area_id'], $commandForHospitalUnitArea[0]['hospital_unit_id']);
                    echo "\t\t<div class='box' id='" . $la_jobType['job_type'] . "'>\n" .
                    $allJobType . "\t\t</div><hr class='hr'>\n";
                    ?>
                </div>
                <?php
            }
            ?>
        </div>

        <br>
    </div><!--/span-->
    <div class="span9">

        <?php if (isset($this->breadcrumbs)): ?>
            <?php
            $this->widget('zii.widgets.CBreadcrumbs', array(
                'links' => $this->breadcrumbs,
                'homeLink' => CHtml::link('Dashboard'),
                'htmlOptions' => array('class' => 'breadcrumb')
            ));
            ?><!-- breadcrumbs -->
        <?php endif ?>

        <!-- Include content pages -->
        <?php echo $content; ?>

    </div><!--/span-->
</div><!--/row-->


<?php $this->endContent(); ?>