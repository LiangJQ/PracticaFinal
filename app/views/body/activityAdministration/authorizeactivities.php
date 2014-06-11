<?php
/*
 * Author: Liang Shan Ji
 */
?>
<div class="informationPanel divcont">
    <?php
    if (!empty(Session::get('activity_authorized?'))) {
        ?>
        <p class="messageNotif"><?php echo Session::get('activity_authorized?'); ?></p>
        <?php }
    ?>
    <div class="authorizeActivities tabActivities" >     
        <div id="authorizeActivitiesTitle">
            <?php if (empty($this->listActivities)) { ?>
                <div class="activitiesTitle">
                    <p id="title">No activities to authorize</p>
                </div>
            <?php } else {
                ?>
                <p id="title">Activities pending to authorize</p>
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
                                <a href="<?php echo URL . "activityAdministration/authorizeActivity/" . $value->workshop_id; ?>" onclick='return confirm("Authorize activity \"<?php echo $value->workshop_name; ?>\" ?")'>Authorize</a>
                            </div>
                            <div class="aAsButton">
                                <a href="<?php echo URL . "activityAdministration/denyActivity/" . $value->workshop_id; ?>" onclick='return confirm("Deny activity \"<?php echo $value->workshop_name; ?>\" ?")'>Deny</a>
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