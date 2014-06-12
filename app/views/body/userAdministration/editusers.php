<?php
/*
 * Author: Liang Shan Ji
 */
?>
<div class="informationPanel">
    <?php
    if (!empty(Session::get('createUser_success?'))) {
        ?>
        <p class="messageNotif"><?php echo Session::get('createUser_success?'); ?></p>
        <?php
    }
    if (!empty(Session::get('deleteUser_success?'))) {
        ?>
        <p class="messageNotif"><?php echo Session::get('deleteUser_success?'); ?></p>
    <?php }
    ?>
    <div class="createUsers">
        <div id="createUsersTitle"><p id="title">Create user</p></div>
        <form method="post" action="<?php echo URL; ?>userAdministration/createUser">
            <input type="text" name="user_name" placeholder="Name" autocomplete="off" required>
            <input type="text" name="user_surname" placeholder="Surname" autocomplete="off" required>
            <input type="password" name="user_password" placeholder="Password" autocomplete="off" required>
            <input type="email" name="user_email" placeholder="Email" autocomplete="off" required>
            <?php if (Session::get('user_role') == ROLE_OWNER) { ?>
                <div class="selectRole">
                    <input type="radio" name="user_role" value="user" checked><label for="user_role" class="valueRole">User</label>
                    <input type="radio" name="user_role" value="user"><label for="user_role" class="valueRole">Admin</label>
                </div>
            <?php } ?>
            <input type="submit" class="submit <?php echo Session::get('user_role') == ROLE_OWNER ? "" : 'addSelect'; ?>" value="Create">
        </form>
    </div>
    <div class="editUsers" >
        <div id="editUsersTitle"><p id="title">User list</p></div>
        <table class="userListTable">
            <tr>
                <th></th>
                <th>Id</th>
                <th>Full Name</th>
                <th>Password</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
            <?php
            $alternate = 1;
            foreach ($this->listUsers as $key => $value) {
                $alternate = -$alternate;
                ?>            
                <tr class="<?php
                echo ($alternate == 1) ? 'diffa' : 'diffb';
                ?>">
                    <td>
                        <a href="<?php echo URL . "userAdministration/editUser/" . $value->user_id; ?>">Edit</a>
                        <a href="<?php echo URL . "userAdministration/deleteUser/" . $value->user_id; ?>" onclick='return confirm("Delete user \"<?php echo $value->user_name; ?>\" ?")'>Delete</a>
                    </td>
                    <td><?php echo $value->user_id; ?></td>
                    <td><?php echo $value->user_surname . ", " . $value->user_name; ?></td>
                    <td><?php echo $value->user_password; ?></td>
                    <td><?php echo $value->user_email; ?></td>
                    <td><?php echo $value->user_role; ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
</div>
</div>  