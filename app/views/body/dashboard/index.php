<?php
/*
 * Author: Liang Shan Ji
 */

$person = $this->personalInformation;
$role = Session::get('user_role');
?>

<div id="divc">
    <div class="divcont personalInformation" >      
        <table>
            <tr>
                <td><span>Id del usuario</span></td>
                <td><?php echo $person->user_id; ?></td>
                <td><span>Nombre</span></td>
                <td><?php echo $person->user_name; ?></td>
            </tr>
            <tr>
                <td><span>Email</span></td>
                <td><?php echo $person->user_email; ?></td>
                <td><span>Rol</span></td>
                <td><?php echo $person->user_role; ?></td>
            </tr>
        </table>
        <?php
        if ($role == ROLE_USER || $role == ROLE_ADMIN || $role == ROLE_OWNER) {
            ?>
            <p>User panel</p><br>
            <?php if ($role == ROLE_ADMIN || $role == ROLE_OWNER) { ?>
                <p>Admin panel</p><br>
                <?php if ($role == ROLE_OWNER) { ?>
                    <p>Owner panel</p><br>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </div>
</div>       
