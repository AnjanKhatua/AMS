<style type="text/css">
    /*    h1,h3, h5{
    
            text-align: center;
        }
        table{
            margin: auto;
            border: 1px solid gray;
        }
        table td,table tr{
            border: 1px solid gray;
            border-collapse: collapse;
            padding: 5px;
        }
        #signature{
            text-align: right;
        }
        #right{
            text-align: right;
        }*/

    .sTable{
        font-size: 10px;
        padding: 2px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        border-right: 1px solid #ddd;
        border-bottom-right-radius: 5px;
    }
</style>

<page>

    <table width="100%">
        <tr>
            <td>To,</td>
            <td>Ivers Care Services</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>            
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>            
            <td><b>Invoice Date</b></td>            
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>         
            <td><b><?php echo (isset($allStaffDetails['company_name']) && ($allStaffDetails['company_name'] != "")) ? "Company Name :" : "" ?></b></td>
        </tr>
        <tr>
            <td></td>            <td>Dallam Court</td>            <td></td>            <td></td>            <td><?php echo $allResult[1]['invoice_date'] ?></td>            <td></td>           <td><?php echo $allStaffDetails['company_name'] ?></td>
        </tr>
        <tr>
            <td></td>            <td>Dallam Lane</td>            <td></td>            <td></td>            <td></td>            <td></td>           <td></td>
        </tr>
        <tr>
            <td></td>            <td>Warrington</td>            <td></td>            <td></td>            <td><b>Reference Number</b></td>            <td></td>           <td><b><?php echo (isset($allStaffDetails['address']) && ($allStaffDetails['address'] != "")) ? "Address :" : "" ?></b></td>
        </tr>
        <tr>
            <td></td>            <td>WA2 7LT</td>            <td></td>            <td></td>            <td><?php echo $allStaffDetails['name'] ?></td>            <td></td>           <td><?php echo $allStaffDetails['address'] ?></td>
        </tr>
        <tr>
            <td></td>            <td>UNITED KINGDOM</td>            <td></td>            <td></td>            <td></td>            <td></td>           <td></td>
        </tr>
    </table>

    <br><br>
    <div style="text-align: center"><b><u>This is not a tax invoice</u></b></div>
    <br><br>
    <table style="padding-left: 60px">
        <tbody>
            <?php
            $li_getAmount = 0;
            $i = 0;
            foreach ($allResult as $la_resultValue) {
                if ($i == 0) {
                    ?>
                    <tr>
                        <td class="sTable"><b><?php echo $la_resultValue['description'] ?></b></td>
                        <td class="sTable"><b><?php echo $la_resultValue['hospital_unit'] ?></b></td>
                        <td class="sTable"><b><?php echo $la_resultValue['total_worked_hours'] ?></b></td>
                        <td class="sTable"><b><?php echo $la_resultValue['rate_for_that_shift'] ?></b></td>
                        <td class="sTable"><b><?php echo $la_resultValue['total_amount'] ?></b></td>
                    </tr>
                    <?php
                    $i++;
                } else {
                    ?>
                    <tr>
                        <td class="sTable"><?php echo $la_resultValue['description'] ?></td>
                        <td class="sTable"><?php echo $la_resultValue['hospital_unit'] ?></td>
                        <td class="sTable" style="text-align: right"><?php echo $la_resultValue['total_worked_hours'] ?></td>
                        <td class="sTable" style="text-align: right"><?php echo $la_resultValue['rate_for_that_shift'] ?></td>
                        <td class="sTable" style="text-align: right"><?php echo $la_resultValue['total_amount'] ?></td>
                    </tr>
                    <?php
                    $li_getAmount += $la_resultValue['total_amount'];
                }
            }
            ?>
            <tr>
                <td class="sTable" colspan="4" style="text-align: right"><b>Total shift amount in (GBP) : </b></td>
                <td class="sTable" style="text-align: right"><b><?php echo $li_getAmount; ?></b></td>
            </tr>
            <?php
            if (count($allExp) != 1) {
                ?>
                <tr>
                    <td class="sTable" colspan="5" style="text-align: center"><b><u>Expenses Details</u></b></td>
                </tr>
                <?php
                $i = 0;
                $li_getExpAmount = 0;
                foreach ($allExp as $la_allExpValue) {
                    if ($i == 0) {
                        ?>
                        <tr>
                            <td class="sTable" colspan="4" style="text-align: left"><b><?php echo $la_allExpValue['description']; ?></b></td>
                            <td class="sTable" colspan="1" style="text-align: left"><b><?php echo $la_allExpValue['expenses']; ?></b></td>
                        </tr>
                        <?php
                        $i++;
                    } else {
                        ?>
                        <tr>
                            <td class="sTable" colspan="4" style="text-align: left"><?php echo $la_allExpValue['description']; ?></td>
                            <td class="sTable" colspan="1" style="text-align: right"><?php echo $la_allExpValue['expenses']; ?></td>
                        </tr>
                        <?php
                    }
                    $li_getExpAmount += $la_allExpValue['expenses'];
                }
                ?>
                <tr>
                    <td class="sTable" colspan="4" style="text-align: right"><b>(Add) Total expenses amount in (GBP) : </b></td>
                    <td class="sTable" style="text-align: right"><b><?php echo $li_getExpAmount; ?></b></td>
                </tr>
                <?php
            }
            ?>

            <?php
            if (count($allTraining) != 1) {
                ?>
                <tr>
                    <td class="sTable" colspan="5" style="text-align: center"><b><u>Training Deduction Details</u></b></td>
                </tr>
                <?php
                $i = 0;
                $li_getTrainingAmount = 0;
                foreach ($allTraining as $la_trainingValue) {
                    if ($i == 0) {
                        ?>
                        <tr>
                            <td class="sTable" colspan="1" style="text-align: left"><b><?php echo $la_trainingValue['week_end_date']; ?></b></td>
                            <td class="sTable" colspan="3" style="text-align: left"><b><?php echo $la_trainingValue['description']; ?></b></td>
                            <td class="sTable" colspan="1" style="text-align: left"><b><?php echo $la_trainingValue['training_deduction_amount']; ?></b></td>
                        </tr>
                        <?php
                        $i++;
                    } else {
                        ?>
                        <tr>
                            <td class="sTable" colspan="1" style="text-align: left"><?php echo Utility::changeDateToUK($la_trainingValue['week_end_date']); ?></td>
                            <td class="sTable" colspan="3" style="text-align: left"><?php echo $la_trainingValue['description']; ?></td>
                            <td class="sTable" colspan="1" style="text-align: right"><?php echo $la_trainingValue['training_deduction_amount']; ?></td>
                        </tr>
                        <?php
                    }
                    $li_getTrainingAmount += $la_trainingValue['training_deduction_amount'];
                }
                ?>
                <tr>
                    <td class="sTable" colspan="4" style="text-align: right"><b>(Less) Total shift amount in (GBP) : </b></td>
                    <td class="sTable" style="text-align: right"><b><?php echo $li_getTrainingAmount; ?></b></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td class="sTable" colspan="4" style="text-align: right"><b>Total amount in (GBP) : </b></td>
                <td class="sTable" style="text-align: right"><b><u><?php echo ($li_getAmount + $li_getExpAmount) - $li_getTrainingAmount; ?></u></b></td>
            </tr>
        </tbody>
    </table>
</page>
<!--<footer>This is not a tax invoice</footer>-->
