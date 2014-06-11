<?php
/*
 * Author: Liang Shan Ji
 */
?>
<div class="informationPanel">
    <?php if (!empty(Session::get('editActivity_success?'))) {
        ?>
        <p class="messageNotif"><?php echo Session::get('editActivity_success?'); ?></p>
    <?php }
    ?>
    <div class = "editActivity tabActivities">
        <div id = "editActivityTitle"><p id = "title">Edit activity</p></div>
        <form method = "post" action = "<?php echo URL; ?>activityAdministration/editActivitySave/<?php echo $this->activity->workshop_id; ?>">
            <table>
                <tr>
                    <td>
                        <span><label class = "textstyle" for = "workshop_name">Activity name</label></span>
                    </td>
                    <td>
                        <input type = "text" name = "workshop_name" id = "edit_activity_input_workshop_name" value = "<?php echo $this->activity->workshop_name; ?>" class = "edit_activity_input" autocomplete = "off" required>
                    </td>
                    <td>
                        <span><label class = "textstyle" for = "workshop_date">Date <p class = "additionalDescription">(<?php echo MAX_LIMIT_DAY_TO_CREATE; ?> days)</p></label></span>
                    </td>
                    <td>                  
                        <select name="workshop_date" id="edit_activity_input_workshop_date" class="edit_activity_input" required>
                            <?php
                            echo "<option value='" . $this->activity->workshop_date . "' selected>" . $this->activity->workshop_date . "</option>";
                            echo "<optgroup label='------------------'></optgroup>";
                            for ($day = START_DAY; $day <= MAX_LIMIT_DAY_TO_CREATE; $day++) {
                                if (!in_array(date("Y-m-d", strtotime('+' . $day . ' day')), $this->listActivitiesLimited)) {
                                    echo "<option value='" . date("Y-m-d", strtotime('+' . $day . ' day')) . "'>" . date("Y-m-d", strtotime('+' . $day . ' day')) . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td>                    
                        <span><label class="textstyle" for="workshop_user_id">Manager id</label></span>
                    </td>
                    <td>                    
                        <input type="text" name="workshop_user_id" id="edit_activity_input_workshop_user_id" value = "<?php echo $this->activity->workshop_user_id; ?>" class="edit_activity_input" autocomplete="off" required> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <span><label class="textstyle" for="workshop_description">Description</label></span>
                    </td>
                    <td colspan="5">            
                        <textarea name="workshop_description" id="edit_activity_input_workshop_description"  class="edit_activity_input" ><?php echo $this->activity->workshop_description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span><label class="textstyle" for="workshop_url_web">Web links<br>(include "http://")</label></span>
                    </td>
                    <td colspan="5">
                        <textarea name="workshop_url_web" id="edit_activity_input_workshop_url_web"  class="edit_activity_input" ><?php
                            $urlWeb = explode('[{()}]', rtrim($this->activity->workshop_url_web, '[{()}]'));
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
                    <td colspan="5">                        
                        <textarea name="workshop_url_file" id="edit_activity_input_workshop_url_file"  class="edit_activity_input" ><?php
                            $urlWeb = explode('[{()}]', rtrim($this->activity->workshop_url_file, '[{()}]'));
                            foreach ($urlWeb as $keyWeb => $valueWeb) {
                                echo $valueWeb . "\n";
                            }
                            ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span><label class="textstyle" for="workshop_request">Request authorize</label></span>
                    </td>
                    <td>
                        <select name="workshop_request" id="edit_activity_input_workshop_request" class="edit_activity_input" >
                            <option value="N" <?php echo ($this->activity->workshop_request == 'N') ? 'selected' : ''; ?>><?php echo REQUEST_N; ?></option>
                            <option value="Y" <?php echo ($this->activity->workshop_request == 'Y') ? 'selected' : ''; ?>><?php echo REQUEST_Y; ?></option>
                        </select>
                    </td>
                    <td>
                        <span><label class="textstyle" for="workshop_authorize">Authorize activity</label></span>
                    </td>
                    <td>                    
                        <select name="workshop_authorize" id="edit_activity_input_workshop_authorize" class="edit_activity_input">
                            <option value="P" <?php echo ($this->activity->workshop_authorize == 'P') ? 'selected' : ''; ?>><?php echo AUTHORIZE_P; ?></option>
                            <option value="N" <?php echo ($this->activity->workshop_authorize == 'N') ? 'selected' : ''; ?>><?php echo AUTHORIZE_N; ?></option>
                            <option value="Y" <?php echo ($this->activity->workshop_authorize == 'Y') ? 'selected' : ''; ?>><?php echo AUTHORIZE_Y; ?></option>
                        </select>
                    </td>
                    <td colspan="2" class="actionCell"><input type="submit" value="Edit"></td>
                </tr>
            </table> 
        </form>   
    </div>
</div>  
</div>