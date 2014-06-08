<?php
/*
 * Author: Liang Shan Ji
 */

$successInfo = '';
$successInfo = Session::get('password_success?');
?>

<div class="informationPanel">
    <div class="changePassword">
        <?php if (empty($successInfo)) { ?>

            <form method="post" action="<?php echo URL; ?>userManagement/changePassword" name="changePassword" class="changePasswordForm">
                <p>
                    <label class="textstyle" for="user_password">Current password</label>
                    <input type="password" name="user_password" id="changePassword_input_password" placeholder="Current password" class="changePassword_input" autocomplete="off" required>
                </p>
                <p>
                    <label class="textstyle" for="user_password_new">New password</label>
                    <input type="password" name="user_password_new" id="changePassword_input_password_new" placeholder="New password" class="changePassword_input" autocomplete="off" required> 
                </p>
                <p>
                    <label class="textstyle" for="user_password_new_confirm">Confirm new password</label>
                    <input type="password" name="user_password_new_confirm" id="changePassword_input_password_new_confirm" placeholder="Confirm new password" class="changePassword_input" autocomplete="off" required> 
                </p>
                <p>
                    <input type="submit" name="changePassword" value="Submit">
                </p>   
            </form>
            <?php if ($successInfo == PASSWORD_NOT_MATCHING || $successInfo == PASSWORD_WRONG_CURRENT_PASSWORD) { ?>
                <p><?php echo $successInfo; ?></p>
                <?php
            }
        } else {
            ?>
            <p><?php
                echo $successInfo;
                $successInfo = '';
                Session::set('password_success?', '');
                ?></p>
<?php }
?>
    </div>
</div>
</div>     
