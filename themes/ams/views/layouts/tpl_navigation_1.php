<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <!-- Be sure to leave the brand out there if you want it shown -->
            <a class="brand" href="#"> &nbsp;<?php echo Yii::app()->name ?></a>
            <div class="nav-collapse" id='cssmenu'>
                <?php
                if ($_SESSION['logged_user']['type'] === 'A' || $_SESSION['logged_user']['type'] === 'M' || $_SESSION['logged_user']['type'] === 'C') {
                    $this->widget('zii.widgets.CMenu', array(
                        'htmlOptions' => array('class' => 'nav'),
                        'activeCssClass' => 'active',
                        'items' => array(
                            array('label' => 'Home', 'url' => array('/admin/default/index'), 'visible' => !Yii::app()->user->isGuest),
//                                    array('label' => 'Hospital Registration', 'url' => array('/admin/HospitalRegistration/create'), 'visible' => !Yii::app()->user->isGuest),
//                                    array('label' => 'Hospital Unit Registration', 'url' => array('/admin/HospitalUnit/create'), 'visible' => !Yii::app()->user->isGuest),
                            array(
                                'label' => 'Staff Management',
                                'items' => array(
                                    array('label' => 'Staff Registration', 'url' => array('/admin/StaffRegistration/admin'), 'visible' => !Yii::app()->user->isGuest),
                                    array('label' => 'Service Area', 'url' => array('/admin/WorkArea/admin'), 'visible' => !Yii::app()->user->isGuest),
                                    array('label' => 'Job Type', 'url' => array('/admin/JobType/admin'), 'visible' => !Yii::app()->user->isGuest),
                                    array('label' => 'Pay Type', 'url' => array('/admin/PayType/admin'), 'visible' => !Yii::app()->user->isGuest),
                                    array('label' => 'Grade', 'url' => array('/admin/Grade/admin'), 'visible' => !Yii::app()->user->isGuest),
                                ),
                                'url' => array('/admin/StaffRegistration/admin'),
                            ),
                            array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                        ),
                    ));
                } else if ($_SESSION['logged_user']['type'] === 'S') {
                    $this->widget('zii.widgets.CMenu', array(
                        'htmlOptions' => array('class' => 'nav'),
                        'activeCssClass' => 'active',
                        'items' => array(
                            array('label' => 'Home', 'url' => array('/admin/default/index'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Staff Updation', 'url' => array('/staff/StaffStaffRegistration/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                        ),
                    ));
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="subnav navbar navbar-fixed-top">
    <div class="navbar-inner" style="padding-left: 30px">
        <div class="container">

            <div class="style-switcher pull-left">
                <a href="javascript:chooseStyle('none', 60)" checked="checked"><span class="style" style="background-color:#0088CC;"></span></a>
                <a href="javascript:chooseStyle('style2', 60)"><span class="style" style="background-color:#7c5706;"></span></a>
                <a href="javascript:chooseStyle('style3', 60)"><span class="style" style="background-color:#468847;"></span></a>
                <a href="javascript:chooseStyle('style4', 60)"><span class="style" style="background-color:#4e4e4e;"></span></a>
                <a href="javascript:chooseStyle('style5', 60)"><span class="style" style="background-color:#d85515;"></span></a>
                <a href="javascript:chooseStyle('style6', 60)"><span class="style" style="background-color:#a00a69;"></span></a>
                <a href="javascript:chooseStyle('style7', 60)"><span class="style" style="background-color:#a30c22;"></span></a>
            </div>
        </div><!-- container -->
    </div><!-- navbar-inner -->
</div><!-- subnav -->