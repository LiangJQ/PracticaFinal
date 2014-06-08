<?php
/*
 * Author: Liang Shan Ji
 */

$role = Session::get('user_role');
?>

<div id="divc">
    <div class="menuSelection">
        <nav class="methodLinks">
            <ul>
                <?php
                if ($role == ROLE_USER || $role == ROLE_ADMIN || $role == ROLE_OWNER) {
                    ?>
                    <li class="menuBarNav userInfo">
                        <div class="linkBackground"></div>
                        <div class="linkTitle">
                            <div class=icon> 
                                <i class="icon-mobile-phone icon-2x"></i>
                            </div>
                            <a href="<?php echo URL; ?>manager/page"><span>User information</span></a>
                        </div>
                    </li>
                    <li class="menuBarNav editPassword">
                        <div class="linkBackground"></div>
                        <div class="linkTitle">
                            <div class=icon> 
                                <i class="icon-mobile-phone icon-2x"></i>
                            </div>
                            <a href="<?php echo URL; ?>manager/page/changePasswordPage"><span>Change password</span></a>
                        </div>
                    </li>
                    <?php if ($role == ROLE_ADMIN || $role == ROLE_OWNER) { ?>
                        <li class="menuBarNav manageUser">
                            <div class="linkBackground"></div>
                            <div class="linkTitle">
                                <div class=icon> 
                                    <i class="icon-lightbulb icon-2x"></i>
                                </div>
                                <a href="#"><span>Edit Users</span></a>
                            </div>
                        </li>
                        <li class="menuBarNav manageWorkshop">
                            <div class="linkBackground"></div>
                            <div class="linkTitle">
                                <div class=icon> 
                                    <i class="icon-wrench icon-2x"></i>
                                </div>
                                <a href="#"><span>Manage workshop</span></a>
                            </div>
                        </li>
                        <li class="menuBarNav authorizeActivities">
                            <div class="linkBackground"></div>
                            <div class="linkTitle">
                                <div class=icon> 
                                    <i class="icon-briefcase icon-2x"></i>
                                </div>
                                <a href="#"><span>Authorize activities</span></a>
                            </div>
                        </li>
                    <?php } ?>
                <?php } ?>

                </<ul>
                    </nav>
                    </div>

