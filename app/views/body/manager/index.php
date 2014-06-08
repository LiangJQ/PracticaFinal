<?php
/*
 * Author: Liang Shan Ji
 */

$role = Session::get('user_role');
?>
<div class="informationPanel">
    <div class="personalInformation" >      
        <div id="tablePersonalInformation">
            <table>
                <tr>
                    <td><span>Id</span></td>
                    <td><?php echo Session::get('user_id'); ?></td>
                </tr>
                <tr>
                    <td><span>Nombre</span></td>
                    <td><?php echo Session::get('user_name'); ?></td>
                </tr>
                <tr>
                    <td><span>Email</span></td>
                    <td><?php echo Session::get('user_email'); ?></td>
                </tr>
                <tr>
                    <td><span>Rol</span></td>
                    <td><?php echo Session::get('user_role'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>  
</div>