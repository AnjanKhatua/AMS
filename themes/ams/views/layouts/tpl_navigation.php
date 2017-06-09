<div class="navbar navbar-inverse navbar-fixed-top">
    <!-- Be sure to leave the brand out there if you want it shown -->
    <!--<div class="container" style="text-align: center; font-size: 20px">
        <a class="brand" href="#"> &nbsp;<?php //echo Yii::app()->name              ?></a>
    </div>-->
    <div id='cssmenu'>
        <?php
        if (!isset($_SESSION['logged_user']['type'])) {
            $this->widget('zii.widgets.CMenu', array(
                'htmlOptions' => array('class' => 'nav'),
                'activeCssClass' => 'active',
                'items' => array(
//                                    array('label' => 'Home', 'url' => array('/site/index')),
//                                    array('label' => 'About', 'url' => array('/site/page', 'view' => 'about'), 'visible' => Yii::app()->user->isGuest),
//                                    array('label' => 'Contact', 'url' => array('/site/contact'), 'visible' => Yii::app()->user->isGuest),
//                                    array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                ),
            ));
        } else if ($_SESSION['logged_user']['type'] === 'D' || $_SESSION['logged_user']['type'] === 'M') {
            $this->widget('zii.widgets.CMenu', array(
                'htmlOptions' => array('class' => 'nav'),
                'activeCssClass' => 'active',
                'items' => array(
                    array('label' => 'Home', 'url' => array('/admin/default/index'), 'visible' => !Yii::app()->user->isGuest),
                    array(
                        'label' => 'Manage Hospital',
                        'items' => array(
                            array('label' => 'Hospital Groups', 'url' => array('/admin/HospitalRegistration/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Hospitals', 'url' => array('/admin/HospitalUnit/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Wards', 'url' => array('/admin/Ward/admin'), 'visible' => !Yii::app()->user->isGuest)
                        ),
                        'url' => array('/admin/HospitalRegistration/admin')
                    ),
                    array(
                        'label' => 'Manage Staff',
                        'items' => array(
                            array('label' => 'Office Staff Registration', 'url' => array('/admin/User/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Staff Registration', 'url' => array('/admin/StaffRegistration/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Draft Staffs', 'url' => array('/admin/StaffRegistration/AdminDraft'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Suspended Staffs', 'url' => array('/admin/StaffRegistration/AdminSuspended'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Inactive Staffs', 'url' => array('/admin/StaffRegistration/AdminInactive'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Archive Staffs', 'url' => array('/admin/StaffRegistration/AdminArchive'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Show Staff Rota Details', 'url' => array('/admin/default/staffRotaDetails'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Export Staff Details', 'url' => array('/admin/staffRegistration/ExportStaffDetails'), 'visible' => !Yii::app()->user->isGuest),
                            array(
                                'label' => 'Settings for Staff',
                                'items' => array(
                                    array('label' => 'Service Area', 'url' => array('/admin/WorkArea/admin'), 'visible' => !Yii::app()->user->isGuest),
                                    array('label' => 'Job Type', 'url' => array('/admin/JobType/admin'), 'visible' => !Yii::app()->user->isGuest),
                                    array('label' => 'Document Type', 'url' => array('/admin/DocumentHeader/admin'), 'visible' => !Yii::app()->user->isGuest),
                                    array('label' => 'Pay Type', 'url' => array('/admin/PayType/admin'), 'visible' => !Yii::app()->user->isGuest),
                                ),
                                'url' => array('/admin/WorkArea/admin'),
                            ),
                        ),
                        'url' => array('/admin/StaffRegistration/admin'),
                    ),
                    array(
                        'label' => 'Manage Shift',
                        'items' => array(
                            array('label' => 'Shift Creation', 'url' => array('/admin/ShiftManagementForHospital/create'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Manage Shift for Hospital', 'url' => array('/admin/ShiftManagementForHospital/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Manage Unfilled Shift', 'url' => array('/admin/ShiftManagementForHospital/adminUnfilled'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Shift Created By You', 'url' => array('/admin/ShiftManagementForHospital/adminSelf'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Archive Shift', 'url' => array('/admin/shiftManagementForHospital/adminArchive'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Historical Filled Shift', 'url' => array('/admin/shiftManagementForHospital/adminHistoricalFilled'), 'visible' => !Yii::app()->user->isGuest),
                        ),
                        'url' => array('/admin/ShiftManagementForHospital/admin'),
                    ),
                    array(
                        'label' => 'Training',
                        'items' => array(
                            array('label' => 'Type of Training ', 'url' => array('/admin/AllTraining/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Staff Training Details', 'url' => array('/admin/TrainingDetails/admin'), 'visible' => !Yii::app()->user->isGuest),
                        ),
                        'url' => array('/admin/AllTraining/admin'),
                    ),
                    array('label' => 'Notification', 'url' => array('/admin/NotificationTemplate/admin'), 'visible' => !Yii::app()->user->isGuest),
                    array('label' => 'Reports', 'url' => array('/admin/default/reports'), 'visible' => !Yii::app()->user->isGuest),
                    array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                ),
            ));
        } else if ($_SESSION['logged_user']['type'] === 'A') {
            $this->widget('zii.widgets.CMenu', array(
                'htmlOptions' => array('class' => 'nav'),
                'activeCssClass' => 'active',
                'items' => array(
                    array('label' => 'Home', 'url' => array('/admin/default/index'), 'visible' => !Yii::app()->user->isGuest),
                    array(
                        'label' => 'Manage Staff',
                        'items' => array(
                            array('label' => 'Staff Registration', 'url' => array('/admin/StaffRegistration/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Draft Staffs', 'url' => array('/admin/StaffRegistration/AdminDraft'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Inactive Staffs', 'url' => array('/admin/StaffRegistration/AdminInactive'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Suspended Staffs', 'url' => array('/admin/StaffRegistration/AdminSuspended'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Archive Staffs', 'url' => array('/admin/StaffRegistration/AdminArchive'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Export Staff Details', 'url' => array('/admin/staffRegistration/ExportStaffDetails'), 'visible' => !Yii::app()->user->isGuest),
                        ),
                        'url' => array('/admin/StaffRegistration/admin'),
                    ),
                    array(
                        'label' => 'Settings for Staff',
                        'items' => array(
                            array('label' => 'Service Area', 'url' => array('/admin/WorkArea/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Job Type', 'url' => array('/admin/JobType/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Document Type', 'url' => array('/admin/DocumentHeader/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Pay Type', 'url' => array('/admin/PayType/admin'), 'visible' => !Yii::app()->user->isGuest),
                        ),
                        'url' => array('/admin/WorkArea/admin'),
                    ),
                    array('label' => 'Reports', 'url' => array('/admin/default/reports'), 'visible' => !Yii::app()->user->isGuest),
                    array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                ),
            ));
        } else if ($_SESSION['logged_user']['type'] === 'C') {
            $this->widget('zii.widgets.CMenu', array(
                'htmlOptions' => array('class' => 'nav'),
                'activeCssClass' => 'active',
                'items' => array(
                    array('label' => 'Home', 'url' => array('/admin/default/index'), 'visible' => !Yii::app()->user->isGuest),
                    array('label' => 'Hospitals', 'url' => array('/admin/HospitalUnit/admin'), 'visible' => !Yii::app()->user->isGuest),
                    array(
                        'label' => 'Manage Staff',
                        'items' => array(
                            array('label' => 'Staff Registration', 'url' => array('/admin/StaffRegistration/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Draft Staffs', 'url' => array('/admin/StaffRegistration/AdminDraft'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Inactive Staffs', 'url' => array('/admin/StaffRegistration/AdminInactive'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Suspended Staffs', 'url' => array('/admin/StaffRegistration/AdminSuspended'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Archive Staffs', 'url' => array('/admin/StaffRegistration/AdminArchive'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Show Staff Rota Details', 'url' => array('/admin/default/staffRotaDetails'), 'visible' => !Yii::app()->user->isGuest),                                                        
                        ),
                        'url' => array('/admin/StaffRegistration/admin'),
                    ),
                    array(
                        'label' => 'Manage Shift',
                        'items' => array(
                            array('label' => 'Shift Creation', 'url' => array('/admin/ShiftManagementForHospital/create'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Manage Shift for Hospital', 'url' => array('/admin/ShiftManagementForHospital/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Manage Unfilled Shift', 'url' => array('/admin/ShiftManagementForHospital/adminUnfilled'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Shift Created By You', 'url' => array('/admin/ShiftManagementForHospital/adminSelf'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Archive Shift', 'url' => array('/admin/shiftManagementForHospital/adminArchive'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Historical Filled Shift', 'url' => array('/admin/shiftManagementForHospital/adminHistoricalFilled'), 'visible' => !Yii::app()->user->isGuest),
                        ),
                        'url' => array('/admin/ShiftManagementForHospital/admin'),
                    ),
                    array('label' => 'Reports', 'url' => array('/admin/default/reports'), 'visible' => !Yii::app()->user->isGuest),
                    array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                ),
            ));
        } else if ($_SESSION['logged_user']['type'] === 'S') {
            $this->widget('zii.widgets.CMenu', array(
                'htmlOptions' => array('class' => 'nav'),
                'activeCssClass' => 'active',
                'items' => array(
                    array('label' => 'Home', 'url' => array('/staff/default/index'), 'visible' => !Yii::app()->user->isGuest),
                    array(
                        'label' => 'Non Availability Management',
                        'items' => array(
                            array('label' => 'Non Availability', 'url' => array('/staff/NonAvailability/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Holiday', 'url' => array('/staff/StaffHoliday/admin'), 'visible' => !Yii::app()->user->isGuest),
                        ),
                        'url' => array('/staff/NonAvailability/admin'),
                    ),
                    array(
                        'label' => 'Shift Management',
                        'items' => array(
                            array('label' => 'Pre booked Confirmed Shifts', 'url' => array('/staff/StaffBooking/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Historical Shifts', 'url' => array('/staff/StaffBooking/AdminPrevious'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Cancelled Confirmed Shifts', 'url' => array('/staff/StaffBooking/AdminCancel'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Upcoming Available Shifts', 'url' => array('/staff/AvailableShiftForHospital/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Shift Applied for', 'url' => array('/staff/ShiftEnquiry/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Enquired Shift for You', 'url' => array('/staff/ShiftEnquiry/AdminAck'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Upload Timesheet', 'url' => array('/staff/UploadedTimesheetByStaff/admin'), 'visible' => !Yii::app()->user->isGuest),
                        ),
                        'url' => array('/staff/AvailableShiftForHospital/admin'),
                    ),
                    array('label' => 'Settings', 'url' => array('/staff/default/settings'), 'visible' => !Yii::app()->user->isGuest),
                    array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                ),
            ));
        } else if ($_SESSION['logged_user']['type'] === 'F') {
            $this->widget('zii.widgets.CMenu', array(
                'htmlOptions' => array('class' => 'nav'),
                'activeCssClass' => 'active',
                'items' => array(
                    array('label' => 'Home', 'url' => array('/finance/default/index'), 'visible' => !Yii::app()->user->isGuest),
                    array(
                        'label' => 'Manage Staff',
                        'items' => array(
                            array('label' => 'Staff Registration', 'url' => array('/admin/StaffRegistration/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Draft Staffs', 'url' => array('/admin/StaffRegistration/AdminDraft'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Inactive Staffs', 'url' => array('/admin/StaffRegistration/AdminInactive'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Suspended Staffs', 'url' => array('/admin/StaffRegistration/AdminSuspended'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Archive Staffs', 'url' => array('/admin/StaffRegistration/AdminArchive'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Show Staff Rota Details', 'url' => array('/admin/default/staffRotaDetails'), 'visible' => !Yii::app()->user->isGuest),                                                        
                        ),
                        'url' => array('/admin/StaffRegistration/admin'),
                    ),
                    array(
                        'label' => 'Manage Job Type',
                        'items' => array(
                            array('label' => 'Job Type', 'url' => array('/finance/JobTypeForFinance/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Job Rate for Staff', 'url' => array('/finance/StaffJobTypeRate/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Job Rate for Hospital', 'url' => array('/finance/HospitalJobTypeRate/admin'), 'visible' => !Yii::app()->user->isGuest),
                        ),
                        'url' => array('/finance/JobTypeForFinance/admin'),
                    ),
                    array('label' => 'Timesheet Entry', 'url' => array('/finance/Timesheet/admin'), 'visible' => !Yii::app()->user->isGuest),
                    array(
                        'label' => 'Manage Payment',
                        'items' => array(
                            array('label' => 'Payment Details for Staff', 'url' => array('/finance/TimesheetPaymentDetailsForStaff/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Generate Invoice', 'url' => array('/finance/TimesheetPaymentDetailsForStaff/generateInvoice'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Make Payment', 'url' => array('/finance/TimesheetPaymentDetailsForStaff/makePayment'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Export Invoice', 'url' => array('/finance/TimesheetPaymentDetailsForStaff/exportAllInvoice'), 'visible' => !Yii::app()->user->isGuest),
                        ),
                        'url' => array('/finance/TimesheetPaymentDetailsForStaff/admin'),
                    ),
                    array(
                        'label' => 'Training',
                        'items' => array(
                            array('label' => 'Type of Training ', 'url' => array('/admin/AllTraining/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Staff Training Details', 'url' => array('/admin/TrainingDetails/admin'), 'visible' => !Yii::app()->user->isGuest),
                        ),
                        'url' => array('/admin/AllTraining/admin'),
                    ),
                    array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                ),
            ));
        }
        ?>
    </div>

</div>

<div class="subnav navbar navbar-fixed-top">
    <div class="navbar-inner" style="padding-left: 30px">
        <div class="container">

            <div class="style-switcher">
                <center>
                    <a href="javascript:chooseStyle('none', 60)" checked="checked"><span class="style" style="background-color:#0088CC;"></span></a>
                    <a href="javascript:chooseStyle('style2', 60)"><span class="style" style="background-color:#7c5706;"></span></a>
                    <a href="javascript:chooseStyle('style3', 60)"><span class="style" style="background-color:#468847;"></span></a>
                    <a href="javascript:chooseStyle('style4', 60)"><span class="style" style="background-color:#4e4e4e;"></span></a>
                    <a href="javascript:chooseStyle('style5', 60)"><span class="style" style="background-color:#d85515;"></span></a>
                    <a href="javascript:chooseStyle('style6', 60)"><span class="style" style="background-color:#a00a69;"></span></a>
                    <a href="javascript:chooseStyle('style7', 60)"><span class="style" style="background-color:#a30c22;"></span></a>
                </center>
            </div>
        </div><!-- container -->
    </div><!-- navbar-inner -->
</div><!-- subnav -->
