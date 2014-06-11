<?php
/*
 * Author: Liang Shan Ji
 */

$role = Session::get('user_role');
?>

<div id="divc">
    <div class="menuSelection divcont">
        <div id='menuactionlinks'>
            <ul>
                <li><a href="<?php echo URL; ?>manager/"><span>User info</span></a></li>
                <li><a href="<?php echo URL; ?>manager/changePass"><span>Change password</span></a></li>
                <?php if ($role == ROLE_ADMIN || $role == ROLE_OWNER) { ?>
                    <li><a href="<?php echo URL; ?>userAdministration/listUsers"><span>Manage users</span></a></li>
                    <li><a href="<?php echo URL; ?>activityAdministration/listActivities"><span>Manage workshops</span></a></li>
                    <li class='last'><a href="<?php echo URL; ?>activityAdministration/authorizeActivities"><span>Authorize activities</span></a></li>
                    <?php } ?>
            </ul>
        </div>
    </div>

