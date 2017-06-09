<?php 
                                if(count($chkData)!=0){
                                    ?>
                        <h4 style="color: #f00">Already exists non availabilities are : </h4>
                        <table border="1" width="100%">
                        <tr>
                            <th>Non availablility id</th>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Action</th>
                        </tr>
                        <?php
                            foreach ($chkData as $dataAll) {
                                ?>
                        <tr>
                            <td><?php echo $dataAll['non_availablility_id']?></td>
                            <td><?php echo Utility::changeDateToUK($dataAll['date']);?></td>
                            <td><?php echo $dataAll['start_time']?></td>
                            <td><?php echo $dataAll['end_time']?></td>
                            <td><input type='button'  name='remove'  value='Remove'  class='shift_remove' id='<?php echo $dataAll['id'] ?>' /></td>
                        </tr>
                        <?php
                            }
                        ?>
                        </table>
                        <?php
                                }
                            ?>