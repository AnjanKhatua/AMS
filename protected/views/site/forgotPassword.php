<div class="row-fluid" id="forgotPasswordDiv">
    <div class="span6 offset3">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => "Forgot Password",
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
            <?php if (isset($_SESSION['forgotPassword']) && $_SESSION['forgotPassword'] != "") { ?>
            <span id="forgotPassWord"><?php echo $_SESSION['forgotPassword']; ?></span>
                <?php
                $_SESSION['forgotPassword'] = "";
            }
            ?>
            <div class="row">
                <?php echo $form->labelEx($model, 'email'); ?>
                <?php echo $form->textField($model, 'email'); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>

            <div class="row buttons">
                <?php
                echo CHtml::button('Submit', array(
                    'class' => 'btn btn btn-primary',
                    'submit' => array('site/ForgotPassword')
                ));
                ?>
            </div>

            <?php $this->endWidget(); ?>
        </div><!-- form -->

        <?php $this->endWidget(); ?>

    </div>

</div>