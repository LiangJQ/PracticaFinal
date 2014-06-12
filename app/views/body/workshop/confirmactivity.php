<?php
/*
 * Author: Liang Shan Ji
 */
?>
<div class="informationPanel">
    <div class="confirmActivity tabActivities" >     
        <div class="activityTitle">
            <?php if ($this->userActivity->workshop_request == 'Y') { ?>
                <div class="activityTitle">
                    <p id="title">Your request to authorize your activity has been sent</p>
                </div>
            <?php } else {
                ?>
                <p id="title">Your activity</p>
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
                            <a href="<?php echo URL . "workshop/confirmActivitySave/" . $this->userActivity->workshop_id; ?>" onclick='return confirm("Send request to authorize activity ?")'>Send request</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>  
</div>  