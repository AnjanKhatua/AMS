<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Login',
);
?>
<div class="page-header">
    <h1>Login <small>to your account</small></h1>
</div>
<div class="span3">
    <div class="sidebar-nav">
        <ul id="yw2">
            <li>
                <ul>
                    <li>
                        <hr>
                        <a><span id="cLogin">LogIn</span></a>
                        <a><span id="cForgotPassword">Forgot password?</span></a>
                        <hr>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <br>
</div>

<div class="row-fluid" id="loginDiv">

    <div class="span6 offset3">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => "Private access",
        ));
        ?>

        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'login-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>

            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <div class="row">
                <?php echo $form->labelEx($model, 'username'); ?>
                <?php echo $form->textField($model, 'username'); ?>
                <?php echo $form->error($model, 'username'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'password'); ?>
                <?php echo $form->passwordField($model, 'password'); ?>
                <?php echo $form->error($model, 'password'); ?>
            </div>

            <!--        <div class="row rememberMe">
            <?php // echo $form->checkBox($model,'rememberMe'); ?>
            <?php // echo $form->label($model,'rememberMe'); ?>
            <?php // echo $form->error($model,'rememberMe');  ?>
                    </div>-->

            <div class="row buttons">
                <?php echo CHtml::submitButton('Login', array('class' => 'btn btn btn-primary')); ?>
            </div>

            <?php $this->endWidget(); ?>
        </div><!-- form -->

        <?php $this->endWidget(); ?>

    </div>

</div>

<div class="row-fluid" id="forgotPasswordDiv">
    <div class="span6 offset3">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => "Private access",
        ));
        ?>

        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'forgot-password-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <div class="row">
                <?php echo $form->labelEx($model, 'email', array('id' => 'emailId')); ?>
                <?php echo $form->textField($model, 'email', array('id' => 'emailId')); ?>
                <?php echo $form->error($model, 'email', array('id' => 'emailIdMsg')); ?>
            </div>

            <div class="row buttons">
                <?php
                echo CHtml::button('Submit', array(
                    'class' => 'btn btn btn-primary',
                    'submit' => array('site/ForgotPassword', 'action' => 'sms')
                ));
                ?>
            </div>

            <?php $this->endWidget(); ?>
        </div><!-- form -->

        <?php $this->endWidget(); ?>

    </div>

</div>
<script>
    $(document).ready(function () {
//        $("#forgot-password-form").submit(function (e) {
//            if ($("#emailId").val() == '') {
//                $("#emailIdMsg").html("Please enter email!").show();
//                return false;
//            }else{
//                $("#emailIdMsg").html("").show();
//                return true;
//            }
//        });
<?php
if (isset($_POST['LoginForm']['email']) && ($_POST['LoginForm']['email'] != '')) {
    ?>
            $("#cForgotPassword").trigger('click');
    <?php
}
?>
    });
</script>