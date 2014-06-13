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
        <script language="JavaScript" type="text/javascript">
            //<!--

            function Persona(id, nombre, mesa, silla) {
                this.id = id;
                this.nombre = nombre;
                this.mesa = mesa;
                this.silla = silla;
            }

            function Mesa(numero, sillas) {
                this.numero = numero;
                this.sillas = new Array(sillas);
            }

            var mesas = [];
            mesas.push(new Mesa(1, 10));
            mesas.push(new Mesa(2, 14));
            mesas.push(new Mesa(3, 12));
            mesas.push(new Mesa(4, 8));

            var idInterval;
            var intervalTime = 200;

            var elementosGuest = new Array();
            var elementosSelected = new Array();

            function cargar_datos() {
                var inviteListArray = <?php echo json_encode($this->inviteList); ?>;
                for (var i = 0; i < inviteListArray.length; i++) {
                    elementosGuest.push(new Persona(inviteListArray[i].user_id, inviteListArray[i].user_fullname, inviteListArray[i].user_table, inviteListArray[i].user_seat));
                    if (elementosGuest[elementosGuest.length - 1].mesa != 0 && elementosGuest[elementosGuest.length - 1].silla != 0) {
                        loadPersonDistribution(elementosGuest[elementosGuest.length - 1].mesa, elementosGuest[elementosGuest.length - 1].silla);
                    }
                }
                escribir_capas();

            }

            function loadPersonDistribution(mesa, sillas) {
                var idi = "m" + mesa + "i" + sillas;
                var mi = document.getElementById(idi);
                var personaSeleccionado = elementosGuest.pop();
                mesas[mesa - 1].sillas[sillas - 1] = personaSeleccionado;
                mi.src = changeSeatUnselectedToSelected(mi.src);
            }

            function escribir_capas() {
                var cadena1 = '';
                var cadena2 = '';
                for (var i = 0; i < elementosGuest.length; i++) {
                    cadena1 += '<a href=javascript:changeToSelected(' + i + ')>' + elementosGuest[i].nombre + '</a><br>';
                }
                for (var i = 0; i < elementosSelected.length; i++) {
                    cadena2 += (i + 1) + ". " + '<a href=javascript:changeToGuest(' + i + ')>' + elementosSelected[i].nombre + '</a><br>';
                }
                document.getElementById('listGuests').innerHTML = cadena1;
                document.getElementById('listSelectedGuests').innerHTML = cadena2;
            }
<?php if ($this->userActivity->workshop_request == 'N') { ?>
                function changeToSelected(i) {
                    elementosSelected.push(elementosGuest[i]);
                    elementosGuest.splice(i, 1);
                    escribir_capas();
                }

                function changeToGuest(i) {
                    elementosGuest.push(elementosSelected[i]);
                    elementosSelected.splice(i, 1);
                    escribir_capas();
                }

                function selectTable(mesa) {
                    if (countArrayEmpty(mesa) == mesas[mesa - 1].sillas.length && elementosSelected.length <= mesas[mesa - 1].sillas.length && elementosSelected.length != 0) {
                        count = 1;
                        for (var i = 0; i < mesas[mesa - 1].sillas.length; i++) {
                            var sil = i + 1;
                            var idi = "m" + mesa + "i" + sil;
                            var mi = document.getElementById(idi);
                            var personaSeleccionado = elementosSelected.shift();
                            personaSeleccionado.mesa = mesa;
                            personaSeleccionado.silla = sil;
                            mesas[mesa - 1].sillas[i] = personaSeleccionado;
                            mi.src = changeSeatUnselectedToSelected(mi.src);
                            escribir_capas();
                        }
                    } else if (countArrayEmpty(mesa) < mesas[mesa - 1].sillas.length && elementosSelected.length == 0) {
                        count = 1;
                        for (var i = 0; i < mesas[mesa - 1].sillas.length; i++) {
                            var sil = i + 1;
                            var idi = "m" + mesa + "i" + sil;
                            var mi = document.getElementById(idi);
                            if (mesas[mesa - 1].sillas[i] != undefined) {
                                var personaLiberado = mesas[mesa - 1].sillas[i];
                                mesas[mesa - 1].sillas[i] = undefined;
                                personaLiberado.mesa = 0;
                                personaLiberado.silla = 0;
                                elementosSelected.push(personaLiberado);
                                mi.src = changeSeatSelectedToUnselected(mi.src);
                                escribir_capas();
                            }
                        }
                    } else if (countArrayEmpty(mesa) < mesas[mesa - 1].sillas.length && elementosSelected.length > countArrayEmpty(mesa)) {
                        alert("Demasiado invitados!");
                    } else if (countArrayEmpty(mesa) < mesas[mesa - 1].sillas.length && elementosSelected.length <= countArrayEmpty(mesa)) {
                        count = 1;
                        for (var i = 0; i < mesas[mesa - 1].sillas.length; i++) {
                            if (mesas[mesa - 1].sillas[i] == undefined) {
                                var sil = i + 1;
                                var idi = "m" + mesa + "i" + sil;
                                var mi = document.getElementById(idi);
                                var personaSeleccionado = elementosSelected.shift();
                                personaSeleccionado.mesa = mesa;
                                personaSeleccionado.silla = sil;
                                mesas[mesa - 1].sillas[i] = personaSeleccionado;
                                mi.src = changeSeatUnselectedToSelected(mi.src);
                                escribir_capas();
                            }
                        }
                    }
                }

                function selectPerson(mesa, sillas) {
                    var idi = "m" + mesa + "i" + sillas;
                    var mi = document.getElementById(idi);
                    if (mesas[mesa - 1].sillas[sillas - 1] == undefined) {
                        if (elementosSelected.length == 0) {
                            alert("No hay personas SELECCIONADAS");
                        } else {
                            var personaSeleccionado = elementosSelected.shift();
                            personaSeleccionado.mesa = mesa;
                            personaSeleccionado.silla = sillas;
                            mesas[mesa - 1].sillas[sillas - 1] = personaSeleccionado;
                            console.log(mesas[mesa - 1].sillas[sillas - 1]);
                            mi.src = changeSeatUnselectedToSelected(mi.src);
                            escribir_capas();
                        }
                    } else {
                        var personaLiberado = mesas[mesa - 1].sillas[sillas - 1];
                        mesas[mesa - 1].sillas[sillas - 1] = undefined;
                        personaLiberado.mesa = 0;
                        personaLiberado.silla = 0;
                        elementosSelected.push(personaLiberado);
                        mi.src = changeSeatSelectedToUnselected(mi.src);
                        escribir_capas();
                    }
                }
<?php } ?>
            function changeSeatUnselectedToSelected(src) {
                return src.replace("Unselected", "");
            }

            function changeSeatSelectedToUnselected(src) {
                return src.replace(".png", "Unselected.png");
                ;
            }

            function showDetailsInterval(mesa, sillas) {
                idInterval = window.setInterval(function() {
                    showDetails(mesa, sillas)
                }, intervalTime);
            }

            function showDetails(mesa, sillas) {
                var idm = "m" + mesa + "s" + sillas;
                var idis = "m" + mesa + "i" + sillas;
                var info = "";
                if (mesas[mesa - 1].sillas[sillas - 1] != undefined) {
                    var nombre = mesas[mesa - 1].sillas[sillas - 1].nombre;
                    info = "<span> Mesa" + mesa + " Silla" + sillas + ": </span>" + nombre + "<br>";
                } else {
                    info = "<span> Mesa" + mesa + " Silla" + sillas + ": </span> Libre <br>";
                }
                document.getElementById(idm).style.marginLeft = (devuelveValores(document.getElementById(idis), "width") + 5) + "px";
                document.getElementById(idm).style.marginBottom = (devuelveValores(document.getElementById(idis), "height")) + "px";
                document.getElementById(idm).innerHTML = info;
                document.getElementById(idm).style.display = 'block';
            }

            function hideDetails(mesa, sillas) {
                clearInterval(idInterval);
                var idm = "m" + mesa + "s" + sillas;
                document.getElementById(idm).style.display = 'none';
            }

            function showTableDetailsInterval(mesa) {
                idInterval = window.setInterval(function() {
                    showTableDetails(mesa);
                }, intervalTime);
            }

            function showTableDetails(mesa) {
                var idm = "m" + mesa;
                var t = "t" + mesa;
                var info = "<h3 class='infoTitle'>Mesa " + mesa + "</h3><hr>";
                var nombre = "";
                var elementIdm = document.getElementById(idm);
                for (var i = 0; i < mesas[mesa - 1].sillas.length; i++) {
                    if (mesas[mesa - 1].sillas[i] == undefined) {
                        nombre = "Libre";
                    } else {
                        nombre = mesas[mesa - 1].sillas[i].nombre;
                    }
                    info += "<span>Silla" + (i + 1) + ": </span>" + nombre + "<br>";
                }
                elementIdm.style.marginLeft = (devuelveValores(document.getElementById(t), "width")) + "px";
                elementIdm.innerHTML = info;
                elementIdm.style.display = 'block';
            }

            function hideTableDetails(mesa) {
                clearInterval(idInterval);
                var idm = "m" + mesa;
                document.getElementById(idm).style.display = 'none';
            }

            function devuelveValores(elemento, propiedad) {
                var valor;
                if (elemento.currentStyle)
                    valor = elemento.currentStyle[propiedad];
                else
                    valor = window.getComputedStyle(elemento, null)[propiedad];
                return parseFloat(valor.match(/\d*/).toString());
            }

            function countArrayEmpty(mesa) {
                var count = 0;
                for (var i = 0; i < mesas[mesa - 1].sillas.length; i++) {
                    if (mesas[mesa - 1].sillas[i] == undefined) {
                        count++;
                    }
                }
                return count;
            }



            function send_value() {
                var arr = [];
                for (var i = 0; i < mesas.length; i++) {
                    for (var j = 0; j < mesas[i].sillas.length; j++) {
                        if (mesas[i].sillas[j] != undefined) {
                            arr.push(mesas[i].sillas[j]);
                        }
                    }
                }

                var aaaa = JSON.stringify(arr);
                document.getElementById("save").value = aaaa;
                console.log(document.getElementById("save").value);
            }
            //-->
        </script>
    </head>
    <body style="background-image: url('<?php echo URL . IMG_PATH; ?>background.png')" <?php echo!empty($this->userActivity) ? 'onload="cargar_datos()"' : '' ?>>
        <div id="view">
            <div id="header">
                <div id="login">
                    <?php if (Session::get('is_user_logged_in') == false) { ?>
                        <!-- login form box -->
                        <form method="post" action="<?php echo URL; ?>login/login" name="login" class="login">
                            <p class="loginText">
                                <label class="textstyle" for="user_id">User ID</label>
                                <input type="text" name="user_id" id="login_input_userid" placeholder="User ID" class="login_input" required>
                            </p>
                            <p class="loginText">
                                <label class="textstyle" for="user_password">Password</label>
                                <input type="password" name="user_password" id="login_input_password" placeholder="Password" class="login_input" autocomplete="off" required> 
                            </p>
                            <p class="loginText">
                                <input type="submit" name="login" value="Log in">
                            </p>       
                            <p class="loginText"> 
                                <input type="button" name="register" value="Register" onclick="alert('TODO')">
                            </p>     
                        </form>     
                    <?php } else { ?>          
                        <!-- user information -->
                        <div id="loggedin">
                            <table class="login">
                                <tr>
                                    <td class="tdr">
                                        <p class="fieldr textstyle">User ID:</p>
                                    </td>
                                    <td class="tdl">
                                        <p class='fieldl textstyle'><?php echo Session::get('user_id'); ?> <p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tdr">
                                        <p class="fieldr textstyle">Username:</p>
                                    </td>
                                    <td class="tdl">
                                        <p class='fieldl textstyle'><?php echo Session::get('user_name'); ?> <p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="tdf">
                                        <div class="button"><a href="<?php echo URL; ?>login/logout"><p>Logout</p></a></div>
                                    </td>
                                </tr>
                            </table>                
                        </div>
                    <?php } ?>
                </div>     

                <header>

                    <?php if (Session::get('is_user_logged_in') == true) { ?>
                        <div class="container" id="logo">
                            <a href="<?php echo URL; ?>index">
                                <img class="icon" id="logo_png" src="<?php echo URL . IMG_PATH; ?>logo_small.png">
                            </a>
                        <?php } else { ?>
                            <div class="container" id="logo_large">
                                <a href="<?php echo URL; ?>index">
                                    <img class="icon" id="logo_png_large" src="<?php echo URL . IMG_PATH; ?>logo_large.png">
                                </a>
                            <?php } ?>
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
                        <?php if (Session::get('is_user_logged_in') == true) { ?>
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

                            <div class="container" id="manager">                                                               
                                <a href="<?php echo URL; ?>manager">
                                    <img class="icon" src="<?php echo URL . IMG_PATH; ?>manager.png">
                                </a>
                                <p class="text">Manager</p>
                            </div>
                        <?php } ?>
                </header>
            </div>

            <div id="content">

                <div id="divh"></div>
                <div id="divc">
                    <div class="menuSelection divcont">
                        <div id='menuactionlinks'>
                            <ul>
                                <li><a href="<?php echo URL; ?>workshop/"><span>Activity info</span></a></li>
                                <li><a href="<?php echo URL; ?>workshop/manageActivity"><span>Manage activity</span></a></li>
                                <li><a href="<?php echo URL; ?>workshop/inviteUsers"><span>Invite users</span></a></li>
                                <li><a href="<?php echo URL; ?>workshop/distributeUsers"><span>Distribute users</span></a></li>
                                <li class='last'><a href="<?php echo URL; ?>workshop/confirmActivity"><span>Confirm activity</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="informationPanel">
                        <div class="distributeUsers" >     
                            <?php if (empty($this->userActivity)) { ?>
                                <div class="activityTitle">
                                    <p id="title">You don't have an activity</p>
                                </div>
                            <?php } else {
                                ?>
                                <div id="container">

                                    <div id="panels">
                                        <div id="panelGuests">
                                            <h2>Invitados</h2>
                                            <div class="contents">
                                                <div id="listGuests">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="panelSelectedGuests">
                                            <h2>Seleccionados</h2>
                                            <div class="contents">
                                                <div id="listSelectedGuests">
                                                </div>
                                            </div>
                                        </div>
                                        <?php if ($this->userActivity->workshop_request == 'N') { ?>
                                            <div id="saveDistribution">
                                                <form action="<?php echo URL . "workshop/distributeUsersSave"; ?>" method='post' onSubmit='send_value()'>
                                                    <input name='user_distribution' id="save" type='hidden' value=''>
                                                    <input id="saveDistributionButton" type='submit' value='Save'>
                                                </form>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <div class="room">
                                        <div class="d1 square">
                                            <table>
                                                <tr class="edgeRow">
                                                    <td></td>
                                                    <td>
                                                        <img class="mis" id="m1i1" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatTopUnselected.png" onclick="selectPerson(1, 1)" onmouseout="hideDetails(1, 1)" onmouseover="showDetailsInterval(1, 1)">
                                                        <div class="hiddenInformation" id="m1s1"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m1i2" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatTopUnselected.png" onclick="selectPerson(1, 2)" onmouseout="hideDetails(1, 2)" onmouseover="showDetailsInterval(1, 2)">
                                                        <div class="hiddenInformation" id="m1s2"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m1i3" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatTopUnselected.png" onclick="selectPerson(1, 3)" onmouseout="hideDetails(1, 3)" onmouseover="showDetailsInterval(1, 3)">
                                                        <div class="hiddenInformation" id="m1s3"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m1i4" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatTopUnselected.png" onclick="selectPerson(1, 4)" onmouseout="hideDetails(1, 4)" onmouseover="showDetailsInterval(1, 4)">
                                                        <div class="hiddenInformation" id="m1s4"></div>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="middleRow">
                                                    <td>
                                                        <img class="mis" id="m1i10" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatLeftUnselected.png" onclick="selectPerson(1, 10)" onmouseout="hideDetails(1, 10)" onmouseover="showDetailsInterval(1, 10)">
                                                        <div class="hiddenInformation" id="m1s10"></div>
                                                    </td>
                                                    <td colspan="4">
                                                        <div class="tables" id="t1" onclick="selectTable(1)" onmouseout="hideTableDetails(1)" onmouseover="showTableDetailsInterval(1)">
                                                            <p class="mesaNum">Mesa 1</p>
                                                        </div>
                                                        <div class="hiddenInformation" id="m1"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m1i5" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatRightUnselected.png" onclick="selectPerson(1, 5)" onmouseout="hideDetails(1, 5)" onmouseover="showDetailsInterval(1, 5)">
                                                        <div class="hiddenInformation" id="m1s5"></div>
                                                    </td>
                                                </tr>
                                                <tr class="edgeRow">
                                                    <td></td>
                                                    <td>
                                                        <img class="mis" id="m1i9" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatBottomUnselected.png" onclick="selectPerson(1, 9)" onmouseout="hideDetails(1, 9)" onmouseover="showDetailsInterval(1, 9)">
                                                        <div class="hiddenInformation" id="m1s9"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m1i8" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatBottomUnselected.png" onclick="selectPerson(1, 8)" onmouseout="hideDetails(1, 8)" onmouseover="showDetailsInterval(1, 8)">
                                                        <div class="hiddenInformation" id="m1s8"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m1i7" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatBottomUnselected.png" onclick="selectPerson(1, 7)" onmouseout="hideDetails(1, 7)" onmouseover="showDetailsInterval(1, 7)">
                                                        <div class="hiddenInformation" id="m1s7"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m1i6" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatBottomUnselected.png" onclick="selectPerson(1, 6)" onmouseout="hideDetails(1, 6)" onmouseover="showDetailsInterval(1, 6)">
                                                        <div class="hiddenInformation" id="m1s6"></div>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="d2 square">
                                            <table>
                                                <tr class="edgeRow">
                                                    <td></td>
                                                    <td>
                                                        <img class="mis" id="m2i1" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatTopUnselected.png" onclick="selectPerson(2, 1)" onmouseout="hideDetails(2, 1)" onmouseover="showDetailsInterval(2, 1)">
                                                        <div class="hiddenInformation" id="m2s1"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m2i2" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatTopUnselected.png" onclick="selectPerson(2, 2)" onmouseout="hideDetails(2, 2)" onmouseover="showDetailsInterval(2, 2)">
                                                        <div class="hiddenInformation" id="m2s2"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m2i3" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatTopUnselected.png" onclick="selectPerson(2, 3)" onmouseout="hideDetails(2, 3)" onmouseover="showDetailsInterval(2, 3)">
                                                        <div class="hiddenInformation" id="m2s3"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m2i4" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatTopUnselected.png" onclick="selectPerson(2, 4)" onmouseout="hideDetails(2, 4)" onmouseover="showDetailsInterval(2, 4)">
                                                        <div class="hiddenInformation" id="m2s4"></div>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="middleRow">
                                                    <td>
                                                        <img class="mis" id="m2i14" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatLeftUnselected.png" onclick="selectPerson(2, 14)" onmouseout="hideDetails(2, 14)" onmouseover="showDetailsInterval(2, 14)">
                                                        <div class="hiddenInformation" id="m2s14"></div>
                                                    </td>
                                                    <td colspan="4" rowspan="3">
                                                        <div class="tables" id="t2" onclick="selectTable(2)" onmouseout="hideTableDetails(2)" onmouseover="showTableDetailsInterval(2)">
                                                            <p class="mesaNum">Mesa 2</p>
                                                        </div>
                                                        <div class="hiddenInformation" id="m2"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m2i5" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatRightUnselected.png" onclick="selectPerson(2, 5)" onmouseout="hideDetails(2, 5)" onmouseover="showDetailsInterval(2, 5)">
                                                        <div class="hiddenInformation" id="m2s5"></div>
                                                    </td>
                                                </tr>
                                                <tr class="middleRow">
                                                    <td>
                                                        <img class="mis" id="m2i13" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatLeftUnselected.png" onclick="selectPerson(2, 13)" onmouseout="hideDetails(2, 13)" onmouseover="showDetailsInterval(2, 13)">
                                                        <div class="hiddenInformation" id="m2s13"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m2i6" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatRightUnselected.png" onclick="selectPerson(2, 6)" onmouseout="hideDetails(2, 6)" onmouseover="showDetailsInterval(2, 6)">
                                                        <div class="hiddenInformation" id="m2s6"></div>
                                                    </td>
                                                </tr>
                                                <tr class="middleRow">
                                                    <td>
                                                        <img class="mis" id="m2i12" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatLeftUnselected.png" onclick="selectPerson(2, 12)" onmouseout="hideDetails(2, 12)" onmouseover="showDetailsInterval(2, 12)">
                                                        <div class="hiddenInformation" id="m2s12"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m2i7" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatRightUnselected.png" onclick="selectPerson(2, 7)" onmouseout="hideDetails(2, 7)" onmouseover="showDetailsInterval(2, 7)">
                                                        <div class="hiddenInformation" id="m2s7"></div>
                                                    </td>
                                                </tr>
                                                <tr class="edgeRow">
                                                    <td></td>
                                                    <td>
                                                        <img class="mis" id="m2i11" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatBottomUnselected.png" onclick="selectPerson(2, 11)" onmouseout="hideDetails(2, 11)" onmouseover="showDetailsInterval(2, 11)">
                                                        <div class="hiddenInformation" id="m2s11"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m2i10" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatBottomUnselected.png" onclick="selectPerson(2, 10)" onmouseout="hideDetails(2, 10)" onmouseover="showDetailsInterval(2, 10)">
                                                        <div class="hiddenInformation" id="m2s10"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m2i9" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatBottomUnselected.png" onclick="selectPerson(2, 9)" onmouseout="hideDetails(2, 9)" onmouseover="showDetailsInterval(2, 9)">
                                                        <div class="hiddenInformation" id="m2s9"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m2i8" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatBottomUnselected.png" onclick="selectPerson(2, 8)" onmouseout="hideDetails(2, 8)" onmouseover="showDetailsInterval(2, 8)">
                                                        <div class="hiddenInformation" id="m2s8"></div>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="d3 square">
                                            <table>
                                                <tr class="edgeRow">
                                                    <td></td>
                                                    <td>
                                                        <img class="mis" id="m3i1" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatTopUnselected.png" onclick="selectPerson(3, 1)" onmouseout="hideDetails(3, 1)" onmouseover="showDetailsInterval(3, 1)">
                                                        <div class="hiddenInformation" id="m13s1"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m3i2" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatTopUnselected.png" onclick="selectPerson(3, 2)" onmouseout="hideDetails(3, 2)" onmouseover="showDetailsInterval(3, 2)">
                                                        <div class="hiddenInformation" id="m3s2"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m3i3" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatTopUnselected.png" onclick="selectPerson(3, 3)" onmouseout="hideDetails(3, 3)" onmouseover="showDetailsInterval(3, 3)">
                                                        <div class="hiddenInformation" id="m3s3"></div>
                                                    </td>

                                                    <td></td>
                                                </tr>
                                                <tr class="middleRow">
                                                    <td>
                                                        <img class="mis" id="m3i12" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatLeftUnselected.png" onclick="selectPerson(3, 12)" onmouseout="hideDetails(3, 12)" onmouseover="showDetailsInterval(3, 12)">
                                                        <div class="hiddenInformation" id="m3s12"></div>
                                                    </td>
                                                    <td colspan="3" rowspan="3">
                                                        <div class="tables" id="t3" onclick="selectTable(3)" onmouseout="hideTableDetails(3)" onmouseover="showTableDetailsInterval(3)">
                                                            <p class="mesaNum">Mesa 3</p>
                                                        </div>
                                                        <div class="hiddenInformation" id="m3"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m3i4" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatRightUnselected.png" onclick="selectPerson(3, 4)" onmouseout="hideDetails(3, 4)" onmouseover="showDetailsInterval(3, 4)">
                                                        <div class="hiddenInformation" id="m3s4"></div>
                                                    </td>
                                                </tr>
                                                <tr class="middleRow">
                                                    <td>
                                                        <img class="mis" id="m3i11" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatLeftUnselected.png" onclick="selectPerson(3, 11)" onmouseout="hideDetails(3, 11)" onmouseover="showDetailsInterval(3, 11)">
                                                        <div class="hiddenInformation" id="m3s11"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m3i5" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatRightUnselected.png" onclick="selectPerson(3, 5)" onmouseout="hideDetails(3, 5)" onmouseover="showDetailsInterval(3, 5)">
                                                        <div class="hiddenInformation" id="m3s5"></div>
                                                    </td>
                                                </tr>
                                                <tr class="middleRow">
                                                    <td>
                                                        <img class="mis" id="m3i10" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatLeftUnselected.png" onclick="selectPerson(3, 10)" onmouseout="hideDetails(3, 10)" onmouseover="showDetailsInterval(3, 10)">
                                                        <div class="hiddenInformation" id="m3s10"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m3i6" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatRightUnselected.png" onclick="selectPerson(3, 6)" onmouseout="hideDetails(3, 6)" onmouseover="showDetailsInterval(3, 6)">
                                                        <div class="hiddenInformation" id="m3s6"></div>
                                                    </td>
                                                </tr>
                                                <tr class="edgeRow">
                                                    <td></td>
                                                    <td>
                                                        <img class="mis" id="m3i9" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatBottomUnselected.png" onclick="selectPerson(3, 9)" onmouseout="hideDetails(3, 9)" onmouseover="showDetailsInterval(3, 9)">
                                                        <div class="hiddenInformation" id="m3s9"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m3i8" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatBottomUnselected.png" onclick="selectPerson(3, 8)" onmouseout="hideDetails(3, 8)" onmouseover="showDetailsInterval(3, 8)">
                                                        <div class="hiddenInformation" id="m3s8"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m3i7" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatBottomUnselected.png" onclick="selectPerson(3, 7)" onmouseout="hideDetails(3, 7)" onmouseover="showDetailsInterval(3, 7)">
                                                        <div class="hiddenInformation" id="m3s7"></div>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="d4 square">
                                            <table>
                                                <tr class="edgeRow">
                                                    <td></td>
                                                    <td>
                                                        <img class="mis" id="m4i1" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatTopUnselected.png" onclick="selectPerson(4, 1)" onmouseout="hideDetails(4, 1)" onmouseover="showDetailsInterval(4, 1)">
                                                        <div class="hiddenInformation" id="m4s1"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m4i2" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatTopUnselected.png" onclick="selectPerson(4, 2)" onmouseout="hideDetails(4, 2)" onmouseover="showDetailsInterval(4, 2)">
                                                        <div class="hiddenInformation" id="m4s2"></div>
                                                    </td>

                                                    <td></td>
                                                </tr>
                                                <tr class="middleRow">
                                                    <td>
                                                        <img class="mis" id="m4i8" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatLeftUnselected.png" onclick="selectPerson(4, 8)" onmouseout="hideDetails(4, 8)" onmouseover="showDetailsInterval(4, 8)">
                                                        <div class="hiddenInformation" id="m4s8"></div>
                                                    </td>
                                                    <td colspan="2" rowspan="2">
                                                        <div class="tables" id="t4" onclick="selectTable(4)" onmouseout="hideTableDetails(4)" onmouseover="showTableDetailsInterval(4)">
                                                            <p class="mesaNum">Mesa 4</p>
                                                        </div>
                                                        <div class="hiddenInformation" id="m4"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m4i3" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatRightUnselected.png" onclick="selectPerson(4, 3)" onmouseout="hideDetails(4, 3)" onmouseover="showDetailsInterval(4, 3)">
                                                        <div class="hiddenInformation" id="m4s3"></div>
                                                    </td>
                                                </tr>
                                                <tr class="middleRow">
                                                    <td>
                                                        <img class="mis" id="m4i7" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatLeftUnselected.png" onclick="selectPerson(4, 7)" onmouseout="hideDetails(4, 7)" onmouseover="showDetailsInterval(4, 7)">
                                                        <div class="hiddenInformation" id="m4s7"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m4i4" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatRightUnselected.png" onclick="selectPerson(4, 4)" onmouseout="hideDetails(4, 4)" onmouseover="showDetailsInterval(4, 4)">
                                                        <div class="hiddenInformation" id="m4s4"></div>
                                                    </td>
                                                </tr>
                                                <tr class="edgeRow">
                                                    <td></td>
                                                    <td>
                                                        <img class="mis" id="m4i6" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatBottomUnselected.png" onclick="selectPerson(4, 6)" onmouseout="hideDetails(4, 6)" onmouseover="showDetailsInterval(4, 6)">
                                                        <div class="hiddenInformation" id="m4s6"></div>
                                                    </td>
                                                    <td>
                                                        <img class="mis" id="m4i5" src="<?php echo URL . IMG_PATH ?>areaWorkshopImg/seatBottomUnselected.png" onclick="selectPerson(4, 5)" onmouseout="hideDetails(4, 5)" onmouseover="showDetailsInterval(4, 5)">
                                                        <div class="hiddenInformation" id="m4s5"></div>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>  
                </div>  
            </div>
            <div id="footer"></div>
        </div>
    </body>
</html>