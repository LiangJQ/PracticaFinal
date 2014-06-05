<?php
/*
 * Author: Liang Shan Ji
 */
?>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
        <link rel="stylesheet" href="<?php echo URL . CSS_PATH; ?>reset.css" />
        <link rel="stylesheet" href="<?php echo URL . CSS_PATH; ?>style.css" />
        <title>TDWTech Association</title>
    </head>
    <body style="background-image: url('<?php echo URL . IMG_PATH; ?>background.png')">
        <div id="view">
            <div id="header">
                <div id="login">
                    <?php
                    if (Session::get('is_user_logged_in') == false) {
                        ?>
                        <!-- login form box -->
                        <form method="post" action="<?php echo URL; ?>login/login" name="loginform" class="login">
                            <p>
                                <label class="textstyle" for="login">User ID</label>
                                <input type="text" name="user_id" id="login_input_username" placeholder="User ID" class="login_input" required>
                            </p>
                            <p>
                                <label class="textstyle" for="password">Password</label>
                                <input type="password" name="user_password" id="login_input_password" placeholder="Password" class="login_input" autocomplete="off" required> 
                            </p>
                            <p>
                                <input type="submit" name="login" value="Log in">
                            </p>       
                            <p>
                                <input type="button" name="register" value="Register" onclick="alert('TODO')">
                            </p>     
                        </form>     
                        <?php
                    } else {
                        ?>          
                        <!-- user information -->
                        <div id="loggedin">
                            <table class="login">
                                <tr>
                                    <td class="tdr">
                                        <p class="fieldr textstyle">User ID:</p>
                                    </td>
                                    <td class="tdl">
                                        <?php
                                        echo "<p class='fieldl textstyle'>" . Session::get('user_id') . "<p>";
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tdr">
                                        <p class="fieldr textstyle">Username:</p>
                                    </td>
                                    <td class="tdl">
                                        <?php
                                        echo "<p class='fieldl textstyle'>" . Session::get('user_name') . "<p>";
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="tdf">
                                        <div class="button"><a href="<?php echo URL; ?>login/logout"><p>Logout</p></a></div>
                                    </td>
                                </tr>
                            </table>                
                        </div>
                        <?php
                    }
                    ?>
                </div>     

                <header>

                    <?php
                    if (Session::get('is_user_logged_in') == true) {
                        ?>
                        <div class="container" id="logo">

                            <a href="<?php echo URL; ?>index">
                                <img class="icon" id="logo_png" src="<?php echo URL . IMG_PATH; ?>logo_small.png">
                            </a>
                            <?php
                        } else {
                            ?>
                            <div class="container" id="logo_large">
                                <a href="<?php echo URL; ?>index">
                                    <img class="icon" id="logo_png_large" src="<?php echo URL . IMG_PATH; ?>logo_large.png">
                                </a>
                                <?php
                            }
                            ?>
                        </div>

                        <div class="container" id="home">
                            <a href="<?php echo URL; ?>index">
                                <img class="icon" src="<?php echo URL . IMG_PATH; ?>home.png">
                            </a>
                            <p class="text">Home</p>
                        </div>

                        <div class="container" id="activities">
                            <a href="<?php echo URL; ?>activities">
                                <img class="icon" src="<?php echo URL . IMG_PATH; ?>activities.png">
                            </a>
                            <p class="text">Activities</p>
                        </div>
                        <?php
                        if (Session::get('is_user_logged_in') == true) {
                            ?>
                            <div class="container" id="invitation">
                                <a href="<?php echo URL; ?>invitation">
                                    <img class="icon" src="<?php echo URL . IMG_PATH; ?>invitation.png">
                                </a>
                                <p class="text">Invitation</p>
                            </div>

                            <div class="container" id="workshop">
                                <a href="<?php echo URL; ?>workshop">
                                    <img class="icon" src="<?php echo URL . IMG_PATH; ?>workshop.png">
                                </a>
                                <p class="text">Workshop</p>
                            </div>

                            <div class="container" id="dashboard">                                                               
                                <a href="<?php echo URL; ?>dashboard">
                                    <img class="icon" src="<?php echo URL . IMG_PATH; ?>dashboard.png">
                                </a>
                                <p class="text">Dashboard</p>
                            </div>
                            <?php
                        }
                        ?>
                </header>
            </div>

            <div id="content">

                <div id="divh"></div>