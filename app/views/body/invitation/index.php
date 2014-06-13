<?php
/*
 * Author: Liang Shan Ji
 */
?>

<div  id="divc">
    <div class="divcont tabActivities" >
        <div class="activityTitle">
            <?php if (empty($this->listActivitiesInvited)) { ?>           
                <p id="title">No activities</p>
            </div>
            <?php
        } else {
            ?>
            <p id="title">Activities</p>       
        </div>
        <?php
        foreach ($this->listActivitiesInvited as $key => $value) {
            ?>  
            <table>
                <tr>
                    <td><span>Title</span></td>
                    <td colspan="2"><?php echo $value->workshop_name; ?></td>
                    <td><span>Activity manager</span></td>          
                    <td colspan="2"><?php echo $value->user_surname . ", " . $value->user_surname; ?></td>    
                </tr>
                <tr>
                    <td><span>Date</span></td>
                    <td><?php echo $value->workshop_date; ?></td>
                    <td><span>Table</span></td>          
                    <td><?php echo $value->area_table; ?></td>          
                    <td><span>Seat</span></td>          
                    <td><?php echo $value->area_seat; ?></td>          
                </tr>
            </table>
            <?php
        }
    }
    ?>
</div>     