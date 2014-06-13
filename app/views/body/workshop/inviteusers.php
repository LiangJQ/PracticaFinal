<?php
/*
 * Author: Liang Shan Ji
 */
?>

<div class="informationPanel">
    <div class="inviteUsers tabActivities" >     
        <div class="activityTitle">
            <?php if (empty($this->userActivity)) { ?>
                <div class="activityTitle">
                    <p id="title">You don't have an activity</p>
                </div>
            <?php } else {
                ?>
                <p id="title">Invite users</p>
            </div>       
            <div class="listUserToInvite">
                <form method="post" action="<?php echo URL; ?>workshop/inviteUsersList">
                    <div class="userListCheck">
                        <?php
                        if ($this->userActivity->workshop_request == 'N') {
                            foreach ($this->listUsers as $value) {
                                ?>                                        
                                <div class="row">
                                    <div class="usersFullname">
                                        <?php echo $value->user_surname . ", " . $value->user_name; ?>
                                    </div>
                                    <div class="switch">
                                        <input class="checkToggleGeneral additionalCheckToggleStyle" id="<?php echo $value->user_id; ?>"  name="user_id[]" 
                                               value="<?php echo $value->user_id; ?>" type="checkbox" <?php
                                               if (!empty($this->usersInvited)) {
                                                   echo in_array($value->user_id, $this->usersInvited) ? 'checked' : '';
                                               }
                                               echo $this->userActivity->workshop_request == 'Y' ? ' disabled' : ' ';
                                               ?>>
                                        <label for="<?php echo $value->user_id; ?>"></label>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            foreach ($this->listUsers as $value) {
                                if (in_array($value->user_id, $this->usersInvited)) {
                                    ?>
                                    <div class="row">
                                        <div class="usersFullname">
                                            <?php echo $value->user_surname . ", " . $value->user_name; ?>
                                        </div>
                                        <div class="switch">
                                            <input class="checkToggleGeneral additionalCheckToggleStyle" id="<?php echo $value->user_id; ?>"  name="user_id[]" 
                                                   value="<?php echo $value->user_id; ?>" type="checkbox" checked  disabled="">
                                            <label for="<?php echo $value->user_id; ?>"></label>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                    <?php if ($this->userActivity->workshop_request == 'N') { ?>
                        <div class = "actionZone">
                            <div class = "buttons">
                                <div class = "fixButton">
                                    <input type = "submit" value = "Update list">
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </form>
            </div>
            <?php
        }
        ?>
    </div>
</div>  
</div>  