<?php
/*
 * Author: Liang Shan Ji
 */
?>
<div class="informationPanel">
    <?php if (!empty(Session::get('editUser_success?'))) {
        ?>
        <p class="messageNotif"><?php echo Session::get('editUser_success?'); ?></p>
    <?php } ?>
    <div class = "editSingleUser">
        <div id = "editSingleUserTitle"><p id = "title">Edit user</p></div>
        <form method = "post" action = "<?php echo URL; ?>userAdministration/editUserSave/<?php echo $this->user->user_id; ?>">
            <div>
                <label for = "user_id" class = "labelField">Id</label>
                <input type = "text" name = "user_id" value = "<?php echo $this->user->user_id; ?>" autocomplete = "off" required>
            </div>
            <div>
                <label for = "user_name" class = "labelField">Username</label>
                <input type = "text" name = "user_name" value = "<?php echo $this->user->user_name; ?>" autocomplete = "off" required>
            </div>
            <div>
                <label for = "user_password" class = "labelField">Password</label>
                <input type = "text" name = "user_password" value = "<?php echo $this->user->user_password; ?>" autocomplete = "off" required>
            </div>
            <div>
                <label for = "user_email" class = "labelField">Email</label>
                <input type = "email" name = "user_email" value = "<?php echo $this->user->user_email; ?>" autocomplete = "off" required>
            </div>
            <?php if (Session::get('user_role') == ROLE_OWNER) {
                ?>
                <div class="selectRole">
                    <input type="radio" name="user_role" value="user" <?php echo $this->user->user_role == 'user' ? 'checked' : ''; ?>><label for="user_role" class="valueRole">User</label>
                    <input type="radio" name="user_role" value="admin" <?php echo $this->user->user_role == 'admin' ? 'checked' : ''; ?>><label for="user_role" class="valueRole">Admin</label>
                </div>
            <?php } ?>
            <input type="submit" class="submit <?php echo Session::get('user_role') != ROLE_OWNER ? "addSelect" : ''; ?>" value="Edit">
        </form>
    </div>
</div>
</div>  
