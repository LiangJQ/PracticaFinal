<?php
/*
 * Author: Liang Shan Ji
 */
?>

<div class="informationPanel">
    <?php if (!empty(Session::get('password_success?'))) { ?>
        <p class="messageNotif"><?php echo Session::get('password_success?'); ?></p>
    <?php }
    ?>
    <div class="changePassword">
        <div id="changePasswordTitle"><p id="title">Change password</p></div>
        <form method="post" action="<?php echo URL; ?>manager/changePassword" name="changePassword" class="changePasswordForm">
            <input type="password" name="user_password" placeholder="Current password" autocomplete="off" required>
            <input type="password" name="user_password_new" placeholder="New password" autocomplete="off" required>
            <input type="password" name="user_password_new_confirm" placeholder="Confirm new password" autocomplete="off" required>
            <input type="submit" name="login" class="submit" value="Submit">
        </form>
    </div>
</div>
</div>     
