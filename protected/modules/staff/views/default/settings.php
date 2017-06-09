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
<div class="row-fluid">
    <div class="span3">
        <div class="sidebar-nav">
            <ul id="yw2">
                <li>
                    <span>OPERATIONS</span>
                    <ul>
                        <li>
                            <a><span id="contact">Change Contact Number</span></a>
                            <a><span id="password">Change Password</span></a>
                            <a><span id="uploadDoc">Manage Document</span></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <br>
    </div>
    <div class="span9">
        <div class="sidebar-nav">
            <ul id="yw2">
                <li>
                    <span class="l1"></span>
                    <div style="padding-bottom: 5px; width: 50%">
                        <span style="text-align: center"><h5><u>Enter your details</u></h5></span>
                    </div>
                    <ul>
                        <li>
                            <div id="pos">
                                <form id="u_contact" action="<?php echo Yii::app()->createUrl('staff/default/ProfileUpdate'); ?>" method="post" enctype="multipart/form-data">
                                    <div>
                                        <span class="l1"></span>
                                        <span class="errorMsg">
                                            <?php
                                            if ($model['errorNumber'] == 'set') {
                                                echo 'Enter correct mobile number!!';
                                            }
                                            ?></span><br>
                                        <span class="l1">Old contact number : </span>
                                        <input id="oldno" type="text" name="oldContact" placeholder="Enter old number" value="<?php echo isset($_POST['oldContact']) ? $_POST['oldContact'] : "" ?>">
                                        <span id="msgoldcontact"></span>
                                    </div>
                                    <div>
                                        <span class="l1">New contact number : </span>
                                        <input id="newno" type="text" name="newContact" placeholder="Enter new number" value="<?php echo isset($_POST['newContact']) ? $_POST['newContact'] : "" ?>">
                                        <span id="msgnewcontact"></span>
                                    </div>
                                    <div class="l2">
                                        <input type="submit" value="Save" onclick="require()"/>
                                    </div>
                                </form>
                            </div>
                            <div id="pos1">
                                <form id="u_password" action="<?php echo Yii::app()->createUrl('staff/default/ProfileUpdate'); ?>" method="post" enctype="multipart/form-data">
                                    <div>
                                        <span class="l1"></span>
                                        <span class="errorMsg">
                                            <?php
                                            if ($model['errorPassword'] == 'set') {
                                                echo 'Enter correct old password!!';
                                            }
                                            ?></span><br>
                                        <span class="l1">Old password : </span>
                                        <input id="oldpass" type="password" name="oldPassword" placeholder="Enter old password" value="<?php echo isset($_POST['oldPassword']) ? $_POST['oldPassword'] : "" ?>">
                                        <span id="msgoldpassword"></span>
                                    </div>
                                    <div>
                                        <span class="l1">New password : </span>
                                        <input id="newpass" type="password" name="newPassword" placeholder="Enter new password" value="<?php echo isset($_POST['newPassword']) ? $_POST['newPassword'] : "" ?>">
                                        <span id="msgnewpassword"></span>
                                    </div>
                                    <div>
                                        <span class="l1">Re-type password : </span>
                                        <input id="renewpass" type="password" name="reTypePassword" placeholder="Enter re-type password" value="<?php echo isset($_POST['reTypePassword']) ? $_POST['reTypePassword'] : "" ?>">
                                        <span id="msgnewretypepassword"></span>
                                    </div>
                                    <div class="l2">
                                        <input type="submit" value="Save"/>
                                    </div>
                                </form>
                            </div>
                            <div id="pos2">
                                <form id="u_password" action="<?php echo Yii::app()->createUrl('staff/default/ProfileUpdate'); ?>" method="post" enctype="multipart/form-data">
                                    <?php
                                    $allFiles = Yii::app()->db->createCommand("SELECT * FROM {{staff_document}} WHERE `staff_id` = " . $_SESSION['logged_user']['staff_id'])->queryAll();
                                    $docTypes = Yii::app()->db->createCommand("SELECT * FROM {{document_header}}")->queryAll();

                                    if (isset($allFiles)) {
                                        $length = count($allFiles);
                                        if ($length != 0) {
                                            ?>
                                            <table border="1" width="50%">
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Link</th>
                                                </tr>
                                                <?php
                                                echo 'Uploaded files are : ';
                                                foreach ($allFiles as $lv_doc) {
                                                    ?>
                                                    <tr>
                                                        <td><?php
                                                            foreach ($docTypes as $lv_type) {
                                                                if ($lv_type['document_header_id'] == $lv_doc['document_header_id']) {
                                                                    echo $lv_type['header_name'];
                                                                    break;
                                                                }
                                                            }
                                                            ?></td>
                                                        <td><a href="<?php
                                                            $destdir = Yii::app()->baseUrl . '/staffDocuments/';
                                                            echo $destdir . $lv_doc['document_name'];
                                                            ?>" download>Download</a></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </table>
                                            <?php
                                        } else {
                                            echo 'No files are uploaded';
                                        }
                                    }
                                    ?>
                                    <hr>    
                                    <div id="documents"></div>
                                    <?php $allDocType = DocumentHeader::model()->docTypeAll(); ?> 
                                    <input type="button" name="addDocs" id="addDoc" value="Click to add Document" onClick='$("#documents").append("<tr><td><select name=\"docType[]\"><?php foreach ($allDocType as $k => $lo_doc) { ?><option value=\"<?php echo $k; ?>\"><?php echo $lo_doc; ?></option><?php } ?></select></td><td><input type=\"file\" name=\"fileName[]\"/></td><td><input  type=button value=Remove class=\"ticket_text\" onClick=\" $(this).parent().parent().remove();\"></td></tr>");'>
                                    <input type="submit" value="Save"/>
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#pos1").hide();
            $("#pos2").hide();
            $("#contact").click(function () {
                $("#pos").show();
                $("#pos1").hide();
                $("#pos2").hide();
            });
            $("#password").click(function () {
                $("#pos1").show();
                $("#pos").hide();
                $("#pos2").hide();
            });
            $("#uploadDoc").click(function () {
                $("#pos2").show();
                $("#pos").hide();
                $("#pos1").hide();
            });

<?php
if (isset($_POST['oldPassword']) && ($_POST['oldPassword'] != '')) {
    ?>
                $("#password").trigger('click');
    <?php
}

if (isset($_POST['docType']) && ($_POST['docType'] != '')) {
    ?>
                $("#uploadDoc").trigger('click');
    <?php
}
?>
        });


        $('#u_contact').submit(function () {
            var on = document.getElementById('oldno').value;
            var nn = document.getElementById('newno').value;

            if ((on == "") && (nn == "")) {
                document.getElementById("msgoldcontact").innerHTML = "";
                document.getElementById("msgoldcontact").innerHTML = "Please enter old number!";
            } else if ((on != "") && (nn == "")) {
                document.getElementById("msgoldcontact").innerHTML = "";
                document.getElementById("msgnewcontact").innerHTML = "Please enter new number!";
            } else if ((on == "") && (nn != "")) {
                document.getElementById("msgnewcontact").innerHTML = "";
                document.getElementById("msgoldcontact").innerHTML = "Please enter old number!";
            } else {
                document.getElementById("msgoldcontact").innerHTML = "";
                document.getElementById("msgnewcontact").innerHTML = "";
//                $(function () {
//                    $("#contact").trigger('click');
//                });
                return true;
            }
            return false;
        });

        $('#u_password').submit(function () {
            var op = document.getElementById('oldpass').value;
            var np = document.getElementById('newpass').value;
            var nrp = document.getElementById('renewpass').value;

            if (op == "") {
                if (np != "")
                    document.getElementById("msgnewpassword").innerHTML = "";
                if (nrp != "")
                    document.getElementById("msgnewretypepassword").innerHTML = "";
                document.getElementById("msgoldpassword").innerHTML = "Please enter old password!";
            } else if (np == "") {
                if (op != "")
                    document.getElementById("msgoldpassword").innerHTML = "";
                if (nrp != "")
                    document.getElementById("msgnewretypepassword").innerHTML = "";
                document.getElementById("msgnewpassword").innerHTML = "Please enter new password!";
            } else if (nrp == "") {
                if (np != "")
                    document.getElementById("msgnewpassword").innerHTML = "";
                if (op != "")
                    document.getElementById("msgoldpassword").innerHTML = "";
                document.getElementById("msgnewretypepassword").innerHTML = "Please enter re-type password!";
            } else if (nrp != np) {
                document.getElementById("msgnewretypepassword").innerHTML = "";
                document.getElementById("msgnewretypepassword").innerHTML = "Re-type password not match!";
            } else if (np.length < 8) {
                document.getElementById("msgnewpassword").innerHTML = "";
                document.getElementById("msgnewpassword").innerHTML = "Please enter more than 7 character!";
            } else {
                document.getElementById("msgoldpassword").innerHTML = "";
                document.getElementById("msgnewpassword").innerHTML = "";
                document.getElementById("msgnewretypepassword").innerHTML = "";
                $(function () {
                    $("#password").trigger('click');
                });
                return true;
            }
            return false;
        });
    </script>