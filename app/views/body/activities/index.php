<?php
/*
 * Author: Liang Shan Ji
 */
?>

<div  id="divc">
    <div class="divcont tabActivities" >
        <?php if (empty($this->listActivities)) { ?>
            <div class="activitiesTitle">
                <h1>No hay actividades</h1>
            </div>
            <?php
        } else {
            ?>
            <div class="activitiesTitle">
                <h1>Actividades</h1>
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
                                <a href="<?php echo URL . REDIRECT_URL . $valueWeb; ?>" target="_blank"><?php echo $valueWeb; ?></a><br>
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
                                <a href="<?php echo URL . REDIRECT_URL . $valueFile; ?>" target="_blank"><?php echo $valueFile; ?></a><br>
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
</div>       
