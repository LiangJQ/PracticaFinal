<?php
/*
 * Author: Liang Shan Ji
 */
?>
<div class="informationPanel">
    <?php
    if (!empty(Session::get('createActivity_success?'))) {
        ?>
        <p class="messageNotif"><?php echo Session::get('createActivity_success?'); ?></p>
        <?php
    }
    if (!empty(Session::get('editActivity_success?'))) {
        ?>
        <p class="messageNotif"><?php echo Session::get('editActivity_success?'); ?></p>
        <?php
    }
    if (!empty(Session::get('deleteActivity_success?'))) {
        ?>
        <p class="messageNotif"><?php echo Session::get('deleteActivity_success?'); ?></p>
    <?php }
    ?>
    <div class="manageActivity tabActivities" >     
        <div class="activityTitle">
            <?php if (empty($this->userActivity)) { ?>
                <p id="title">Create your activity</p>
            </div>
            <form method="post" action="<?php echo URL; ?>workshop/createActivity">
                <table>
                    <tr>
                        <td>
                            <span><label class="textstyle" for="workshop_name">Activity name</label></span>
                        </td>
                        <td>                
                            <input type="text" name="workshop_name" id="manage_activity_input_workshop_name" placeholder="Activity name" class="manage_activity_input" autocomplete="off" required>
                        </td>
                        <td>
                            <span><label class="textstyle" for="workshop_date">Date <p class="additionalDescription">(<?php echo MAX_LIMIT_DAY_TO_CREATE; ?> days)</p></label></span>
                        </td>
                        <td>                  
                            <select name="workshop_date" id="manage_activity_input_workshop_date" class="manage_activity_input" required>
                                <?php
                                for ($day = START_DAY; $day <= MAX_LIMIT_DAY_TO_CREATE; $day++) {
                                    if (!in_array(date("Y-m-d", strtotime('+' . $day . ' day')), $this->listActivitiesLimited)) {
                                        echo "<option value='" . date("Y-m-d", strtotime('+' . $day . ' day')) . "'>" . date("Y-m-d", strtotime('+' . $day . ' day')) . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><label class="textstyle" for="workshop_description">Description</label></span>
                        </td>
                        <td colspan="3">            
                            <textarea name="workshop_description" id="manage_activity_input_workshop_description"  class="manage_activity_input" ></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><label class="textstyle" for="workshop_url_web">Web links<br>(include "http://")</label></span>
                        </td>
                        <td colspan="3">
                            <textarea name="workshop_url_web" id="manage_activity_input_workshop_url_web"  class="manage_activity_input" ></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><label class="textstyle" for="workshop_url_file">File links<br>(include "http://")</label></span>
                        </td>
                        <td colspan="3">                        
                            <textarea name="workshop_url_file" id="manage_activity_input_workshop_url_file"  class="manage_activity_input" ></textarea>
                        </td>
                    </tr>         
                </table> 
                <div class="actionZone">
                    <div class="buttons">
                        <div class="fixButton">
                            <input type="submit" value="Create">
                        </div>
                    </div>
                </div>
            </form> 
        <?php } else if ($this->userActivity->workshop_request == 'N') {
            ?>
            <p id="title">Edit your activity</p>
        </div>       
        <form method = "post" action = "<?php echo URL; ?>workshop/editActivitySave/<?php echo $this->userActivity->workshop_id; ?>">
            <table>
                <tr>
                    <td>
                        <span><label class = "textstyle" for = "workshop_name">Activity name</label></span>
                    </td>
                    <td>
                        <input type = "text" name = "workshop_name" id = "manage_activity_input_workshop_name" value = "<?php echo $this->userActivity->workshop_name; ?>" class = "manage_activity_input" autocomplete = "off" required>
                    </td>
                    <td>
                        <span><label class = "textstyle" for = "workshop_date">Date <p class = "additionalDescription">(<?php echo MAX_LIMIT_DAY_TO_CREATE; ?> days)</p></label></span>
                    </td>
                    <td>                  
                        <select name="workshop_date" id="manage_activity_input_workshop_date" class="manage_activity_input" required>
                            <?php
                            echo "<option value='" . $this->userActivity->workshop_date . "' selected>" . $this->userActivity->workshop_date . "</option>";
                            echo "<optgroup label='------------------'></optgroup>";
                            for ($day = START_DAY; $day <= MAX_LIMIT_DAY_TO_CREATE; $day++) {
                                if (!in_array(date("Y-m-d", strtotime('+' . $day . ' day')), $this->listActivitiesLimited)) {
                                    echo "<option value='" . date("Y-m-d", strtotime('+' . $day . ' day')) . "'>" . date("Y-m-d", strtotime('+' . $day . ' day')) . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span><label class="textstyle" for="workshop_description">Description</label></span>
                    </td>
                    <td colspan="3">            
                        <textarea name="workshop_description" id="manage_activity_input_workshop_description"  class="manage_activity_input" ><?php echo $this->userActivity->workshop_description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span><label class="textstyle" for="workshop_url_web">Web links<br>(include "http://")</label></span>
                    </td>
                    <td colspan="3">
                        <textarea name="workshop_url_web" id="manage_activity_input_workshop_url_web"  class="manage_activity_input" ><?php
                            $urlWeb = explode('[{()}]', rtrim($this->userActivity->workshop_url_web, '[{()}]'));
                            foreach ($urlWeb as $keyWeb => $valueWeb) {
                                echo $valueWeb . "\n";
                            }
                            ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span><label class="textstyle" for="workshop_url_file">File links<br>(include "http://")</label></span>
                    </td>
                    <td colspan="3">                        
                        <textarea name="workshop_url_file" id="manage_activity_input_workshop_url_file"  class="manage_activity_input" ><?php
                            $urlFile = explode('[{()}]', rtrim($this->userActivity->workshop_url_file, '[{()}]'));
                            foreach ($urlFile as $keyFile => $valueFile) {
                                echo $valueFile . "\n";
                            }
                            ?></textarea>
                    </td>
                </tr>
            </table> 
            <div class="actionZone">
                <div class="buttons">
                    <input type="submit" value="Edit"> 
                    <div class="aAsButton">
                        <a href="<?php echo URL . "workshop/deleteActivity/" . $this->userActivity->workshop_id; ?>" onclick='return confirm("Delete activity ?")'>Delete</a>
                    </div>
                </div>
            </div>
        </form>   
        <?php
    } else {
        ?>
        <p id="title">Activity sent for authorize</p>
    </div>
    <table>
        <tr>
            <td><span>Name</span></td>
            <td><?php echo $this->userActivity->workshop_name; ?></td>
            <td><span>Date</span></td>
            <td><?php echo $this->userActivity->workshop_date; ?></td>
            <td><span>Manager id</span></td>
            <td><?php echo $this->userActivity->workshop_user_id; ?></td>
        </tr>
        <tr>
            <td><span>Description</span></td>
            <td colspan="5"><?php echo $this->userActivity->workshop_description; ?></td>
        </tr>
        <tr>
            <td><span>Web links<br>(include "http://")</span></td>
            <td colspan="5">
                <?php
                $urlWeb = explode('[{()}]', rtrim($this->userActivity->workshop_url_web, '[{()}]'));
                foreach ($urlWeb as $keyWeb => $valueWeb) {
                    ?>
                    <a href="<?php echo URL . REDIRECT_URL . $valueWeb; ?>"><?php echo $valueWeb; ?></a><br>
                <?php }
                ?>
            </td>
        </tr>
        <tr>
            <td><span>File links<br>(include "http://")</span></td>
            <td colspan="5">                        
                <?php
                $urlFile = explode('[{()}]', rtrim($this->userActivity->workshop_url_file, '[{()}]'));
                foreach ($urlFile as $keyFile => $valueFile) {
                    ?>
                    <a href="<?php echo URL . REDIRECT_URL . $valueFile; ?>"><?php echo $valueFile; ?></a><br>
                <?php }
                ?>
            </td>
        </tr>
        <tr>
            <td><span>Request authorize</span></td>
            <td colspan="2"><?php echo constant("REQUEST_" . $this->userActivity->workshop_request); ?></td>
            <td><span>Authorize activity</span></td>
            <td colspan="2"><?php echo constant("AUTHORIZE_" . $this->userActivity->workshop_authorize); ?></td>
        </tr>
    </table>
    <div class="actionZone">
        <div class="buttons">
            <div class="fixButton">
                <div class="aAsButton">
                    <a href="<?php echo URL . "workshop/deleteActivity/" . $this->userActivity->workshop_id; ?>" onclick='return confirm("Delete activity ?")'>Delete</a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div>
</div>  
</div>  