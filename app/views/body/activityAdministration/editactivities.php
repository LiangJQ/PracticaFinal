<?php
/*
 * Author: Liang Shan Ji
 */
?>
<div class="informationPanel divcont">
    <?php
    if (!empty(Session::get('createActivity_success?'))) {
        ?>
        <p class="messageNotif"><?php echo Session::get('createActivity_success?'); ?></p>
        <?php
    }
    if (!empty(Session::get('deleteActivity_success?'))) {
        ?>
        <p class="messageNotif"><?php echo Session::get('deleteActivity_success?'); ?></p>
    <?php }
    ?>
    <div class="createActivity tabActivities">
        <div class="activityTitle"><p id="title">Create activity</p></div>
        <form method="post" action="<?php echo URL; ?>activityAdministration/createActivity">
            <table>
                <tr>
                    <td>
                        <span><label class="textstyle" for="workshop_name">Activity name</label></span>
                    </td>
                    <td>                
                        <input type="text" name="workshop_name" id="create_activity_input_workshop_name" placeholder="Activity name" class="create_activity_input" autocomplete="off" required>
                    </td>
                    <td>
                        <span><label class="textstyle" for="workshop_date">Date <p class="additionalDescription">(<?php echo MAX_LIMIT_DAY_TO_CREATE; ?> days)</p></label></span>
                    </td>
                    <td>                  
                        <select name="workshop_date" id="create_activity_input_workshop_date" class="create_activity_input" required>
                            <?php
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
                        <input type="text" name="workshop_user_id" id="create_activity_input_workshop_user_id" placeholder="Manager Id" class="create_activity_input" autocomplete="off" required> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <span><label class="textstyle" for="workshop_description">Description</label></span>
                    </td>
                    <td colspan="5">            
                        <textarea name="workshop_description" id="create_activity_input_workshop_description"  class="create_activity_input" ></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span><label class="textstyle" for="workshop_url_web">Web links<br>(include "http://")</label></span>
                    </td>
                    <td colspan="5">
                        <textarea name="workshop_url_web" id="create_activity_input_workshop_url_web"  class="create_activity_input" ></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span><label class="textstyle" for="workshop_url_file">File links<br>(include "http://")</label></span>
                    </td>
                    <td colspan="5">                        
                        <textarea name="workshop_url_file" id="create_activity_input_workshop_url_file"  class="create_activity_input" ></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span><label class="textstyle" for="workshop_request">Request authorize</label></span>
                    </td>
                    <td>
                        <select name="workshop_request" id="create_activity_input_workshop_request" class="create_activity_input" disabled>
                            <option value="N"><?php echo REQUEST_N; ?></option>
                            <option value="Y"><?php echo REQUEST_Y; ?></option>
                        </select>
                    </td>
                    <td>
                        <span><label class="textstyle" for="workshop_authorize">Authorize activity</label></span>
                    </td>
                    <td>                    
                        <select name="workshop_authorize" id="create_activity_input_workshop_authorize" class="create_activity_input" disabled>
                            <option value="P"><?php echo AUTHORIZE_P; ?></option>
                            <option value="N"><?php echo AUTHORIZE_N; ?></option>
                            <option value="Y"><?php echo AUTHORIZE_Y; ?></option>
                        </select>
                    </td>
                    <td colspan="2" class="actionCell"><input type="submit" value="Create"></td>
                </tr>
            </table> 
        </form>   
    </div>
    <div class="editActivities tabActivities" >     
        <div id="editActivitiesTitle">
            <?php if (empty($this->listActivities)) { ?>
                <div class="activitiesTitle">
                    <p id="title">No activities</p>
                </div>
            <?php } else {
                ?>
                <p id="title">Activity list</p>
            </div>
            <?php
            foreach ($this->listActivities as $key => $value) {
                ?>            
                <table>
                    <tr>
                        <td><span>Name</span></td>
                        <td><?php echo $value->workshop_name; ?></td>
                        <td><span>Date</span></td>
                        <td><?php echo $value->workshop_date; ?></td>
                        <td><span>Manager id</span></td>
                        <td><?php echo $value->workshop_user_id; ?></td>
                    </tr>
                    <tr>
                        <td><span>Description</span></td>
                        <td colspan="5"><?php echo $value->workshop_description; ?></td>
                    </tr>
                    <tr>
                        <td><span>Web links<br>(include "http://")</span></td>
                        <td colspan="5">
                            <?php
                            $urlWeb = explode('[{()}]', rtrim($value->workshop_url_web, '[{()}]'));
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
                            $urlFile = explode('[{()}]', rtrim($value->workshop_url_file, '[{()}]'));
                            foreach ($urlFile as $keyFile => $valueFile) {
                                ?>
                                <a href="<?php echo URL . REDIRECT_URL . $valueFile; ?>"><?php echo $valueFile; ?></a><br>
                            <?php }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><span>Request authorize</span></td>
                        <td><?php echo constant("REQUEST_" . $value->workshop_request); ?></td>
                        <td><span>Authorize activity</span></td>
                        <td><?php echo constant("AUTHORIZE_" . $value->workshop_authorize); ?></td>
                        <td colspan="2" class="actionCell">
                            <div class="aAsButton">
                                <a href="<?php echo URL . "activityAdministration/editActivity/" . $value->workshop_id; ?>">Edit</a>
                            </div>
                            <div class="aAsButton">
                                <a href="<?php echo URL . "activityAdministration/deleteActivity/" . $value->workshop_id; ?>" onclick='return confirm("Delete activity \"<?php echo $value->workshop_name; ?>\" ?")'>Delete</a>
                            </div>
                        </td>
                    </tr>
                </table>
                <?php
            }
        }
        ?>
    </div>
</div>
</div>  