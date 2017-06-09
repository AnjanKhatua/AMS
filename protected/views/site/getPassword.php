<div class="row-fluid" id="forgotPasswordDiv">
    <div class="span6 offset3">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => "Enter new password",
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
            <?php if (isset($_SESSION['changePassword']) && $_SESSION['changePassword'] != "") { ?>
                <span id="forgotPassWord"><?php echo $_SESSION['changePassword']; ?></span>
                <?php
                $_SESSION['changePassword'] = "";
            }
            ?>
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
                    'submit' => array('site/GetPassword')
                ));
                ?>
            </div>

            <?php $this->endWidget(); ?>
        </div><!-- form -->

        <?php $this->endWidget(); ?>

    </div>

</div>