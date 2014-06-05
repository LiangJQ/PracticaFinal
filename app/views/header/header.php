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
    <body>
        <div id="view">
            <div id="header">
                <div id="login">
                    <?php
                    if (Session::get('is_user_logged_in')==false) {
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
                    if (false) {
                        ?>
                        <div class="container" id="logo">

                            <a href="<?php echo URL; ?>index">
                                <img class="icon" id="logo_png" src="style/resources/logo_small.png">
                            </a>
                            <?php
                        } else {
                            ?>
                            <div class="container" id="logo_large">
                                <a href="<?php echo URL; ?>index">
                                    <img class="icon" id="logo_png_large" src="style/resources/logo_large.png">
                                </a>
                                <?php
                            }
                            ?>
                        </div>

                        <div class="container" id="home">
                            <a href="<?php echo URL; ?>dashboard">
                                <img class="icon" src="style/resources/home.png">
                            </a>
                            <p class="text">Home</p>
                        </div>

                        <div class="container" id="calendar">
                            <a href="<?php echo URL; ?>activities">
                                <img class="icon" src="style/resources/calendar.png">
                            </a>
                            <p class="text">Calendar</p>
                        </div>
                        <?php
                        if (false) {
                            ?>
                            <div class="container" id="invitation">
                                <img class="icon" src="style/resources/invitation.png">
                                <p class="text">Invitations</p>
                            </div>

                            <div class="container" id="workshop">
                                <img class="icon" src="style/resources/workshop.png">
                                <p class="text">Workshop</p>
                            </div>

                            <div class="container" id="profile">
                                <img class="icon" src="style/resources/profile.png">
                                <p class="text">Profile</p>
                            </div>
                            <?php
                        }
                        ?>
                </header>
            </div>

            <div id="content">

                <div id="divh"></div>