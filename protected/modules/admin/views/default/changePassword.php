<div class="row-fluid" id="forgotPasswordDiv">
    <div class="span6 offset3">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => "Change password",
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
            <?php if (isset($_SESSION['ChangePasswordMsg']) && $_SESSION['ChangePasswordMsg'] != "") { ?>
                <span id="forgotPassWord"><?php echo $_SESSION['ChangePasswordMsg']; ?></span>
                <?php
                $_SESSION['ChangePasswordMsg'] = "";
            }
            if (isset($_SESSION['ChangePasswordMsgError']) && $_SESSION['ChangePasswordMsgError'] != "") {
                ?>
                <span id="forgotPassWordError"><?php echo $_SESSION['ChangePasswordMsgError']; ?></span>
                <?php
                $_SESSION['ChangePasswordMsgError'] = "";
            }
            ?>
            <div class="row">
                <?php echo $form->labelEx($model, 'email'); ?>
                <?php echo $form->textField($model, 'email'); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'new_password'); ?>
                <?php echo $form->passwordField($model, 'new_password'); ?>
                <?php echo $form->error($model, 'new_password'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'repeat_password'); ?>
                <?php echo $form->passwordField($model, 'repeat_password'); ?>
                <?php echo $form->error($model, 'repeat_password'); ?>
            </div>

            <div class="row buttons">
                <?php
                echo CHtml::button('Submit', array(
                    'class' => 'btn btn btn-primary',
                    'submit' => array('default/ChangePassword')
                ));
                ?>
            </div>

<?php $this->endWidget(); ?>
        </div><!-- form -->

        <?php $this->endWidget(); ?>
        <?php
        echo CHtml::link('Goto office staff dashboard?', array(
            '/admin/User/admin',
                ), array(
            'id' => 'cChangePassword',
                )
        );
        ?>

        <?php
        echo CHtml::link('Goto staff dashboard?', array(
            '/admin/StaffRegistration/admin',
                ), array(
            'id' => 'cForgotPassword',
                )
        );
        ?>
    </div>

</div>