<?php
/*
 * Author: Liang Shan Ji
 */
?>

<div  id="divc">
    <div class="divcont tabActivities" >
        <div class="activityTitle">
            <?php if (empty($this->listActivities)) { ?>           
                <p id="title">No activities</p>
            </div>
            <?php
        } else {
            ?>
            <p id="title">Activities</p>       
        </div>
        <?php
        foreach ($this->listActivities as $key => $value) {
            ?>  
            <table>
                <tr>
                    <td><span>Nombre</span></td>
                    <td><?php echo $value->workshop_name; ?></td>
                    <td><span>Fecha</span></td>
                    <td><?php echo $value->workshop_date; ?></td>
                </tr>
                <tr>
                    <td><span>Descripci&oacute;n</span></td>
                    <td colspan="3"><?php echo $value->workshop_description; ?></td>
                </tr>
                <tr>
                    <td><span>Enlaces</span></td>
                    <td colspan="3">
                        <?php
                        $urlWeb = explode('[{()}]', rtrim($value->workshop_url_web, '[{()}]'));
                        foreach ($urlWeb as $keyWeb => $valueWeb) {
                            ?>
                            <a href="<?php echo URL . REDIRECT_URL . $valueWeb; ?>"><?php echo $valueWeb; ?></a><br>
                        <?php }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><span>Documentos</span></td>
                    <td colspan="3">                        
                        <?php
                        $urlFile = explode('[{()}]', rtrim($value->workshop_url_file, '[{()}]'));
                        foreach ($urlFile as $keyFile => $valueFile) {
                            ?>
                            <a href="<?php echo URL . REDIRECT_URL . $valueFile; ?>"><?php echo $valueFile; ?></a><br>
                        <?php }
                        ?>
                    </td>
                </tr>
            </table>
            <?php
        }
    }
    ?>
</div>     
