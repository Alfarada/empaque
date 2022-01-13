<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <title>Document</title>
</head>

<body>
    <div class="row">
        <div class="container">
            <h3 class="title center-align">Empaque</h3>
            <h4 class="grey-text center-align">Gestión de cajas</h4>

            <!-- card notice -->
            <div class="col s12">
                <div class="card notice hide">
                    <div class="card-content white-text center-align">
                        <i class="medium material-icons">
                            <span class="material-icons-outlined">
                                notification_important
                            </span></i>
                        <span class="card-title">¡ IMPORTANTE !</span>
                        <h6></h6>
                    </div>
                </div>
            </div>
            <!-- card notice -->

            <!-- button logout -->
            <a id="scale-demo" href="#!" class="remove btn-floating btn-large scale-transition scale-out red">
                <i class="icon-remove material-icons">logout</i>
            </a>
            <!-- button logout -->

            <!-- modal -->
            <div id="idModal" class="modal modal-fixed-footer">
                <div class="modal-content center">
                    <h4>¡ ATENCION !</h4>
                    <p></p>
                </div>
                <div class="modal-footer">
                    <a href="#!" class="modal-close waves-effect waves-light btn accept-modal">Aceptar</a>
                    <a href="#!" class="modal-close red btn">Cancelar</a>
                </div>
            </div>
            <!-- modal -->

            <section id="section1" class="crud center-align">
                <article>
                    <!-- <h4 class="crud_title">Agregar registro</h4> -->
                    <form class="crud_form col s12 l3 card">
                        <span class="card-title crud_title">
                            <h5>Formulario</h5>
                        </span>
                        <div class="input-field">
                            <label for="fecha"></label>
                            <input type="date" id="fecha" class="validate fecha" name="registry" id="registry" value="<?php echo date("Y-m-d");?>">
                        </div>
                        <div class="input-field">
                            <label for="ingress">Ingreso</label>
                            <input type="number" id="ingress" class="validate ingress" name="ingress" value="0" maxlength="5">
                        </div>
                        <div class="input-field">
                            <label for="egrees">Egreso</label>
                            <input type="number" id="egrees" name="egrees" class="validate egrees" value="0" placeholder="egreso" maxlength="5">
                        </div>
                        <div class="input-field">
                            <label for="stock">Stock</label>
                            <input type="number" id="stock" class="validate stock" name="stock" readonly="readonly" value="0" maxlength="5">
                        </div>

                        <div class="switch">
                            <!-- <p class="logo-text">¿ Cajas con logo ?</p> -->
                            <label>
                                Sin logo
                                <input class="logo-switch validate" type="checkbox" name="logo">
                                <span class="lever"></span>
                                Con logo
                            </label>

                        </div>
                        <input type="hidden" name="id">
                        <button class="btn waves-effect waves-light blue submit" name="submit" type="submit">Agregar</button>
                        <button class="btn btn-reset none waves-effect waves-light red" type="reset">Cancelar edición</button>
                        <div class="alert-container none">
                            <span class="helper-text red-text"><b>Porfavor rellene los campos correctamente</b></span>
                        </div>
                    </form>
                </article>
                <!-- <article class="show col s12 l9"> -->
                <article>
                    <div class="card container-table show col s12 l8 offset-l1">
                        <span class="table_title">
                            <h4>Tabla de registros</h4>
                            <!-- Buttons Logo -->
                            <section class="row section_table">
                                <article class="btn-logo col s6 is-actived">
                                    <p class="flow-text">Con logo</p>
                                </article>
                                <article class="btn-without-logo blue-text col s6">
                                    <p class="flow-text">Sin logo</p>
                                </article>
                            </section>
                            <!-- Buttons Logo -->
                        </span>

                        <!-- empty database short description -->
                        <div class="short-description hide">
                            <i class="large material-icons">
                                <span class="material-icons-outlined" style="color:#e0e0e0;">
                                    visibility_off
                                </span>
                            </i>
                            <p>No hay registros en la base de datos.</p>
                        </div>
                        <!-- empty database short description -->

                        <!-- Loader -->
                        <div id="loader" class=" col s12 l8 offset-l1 hide">
                            <div class="preloader-wrapper big active" style="margin: 2rem;">
                                <div class="spinner-layer spinner-blue-only">
                                    <div class="circle-clipper left">
                                        <div class="circle"></div>
                                    </div>
                                    <div class="gap-patch">
                                        <div class="circle"></div>
                                    </div>
                                    <div class="circle-clipper right">
                                        <div class="circle"></div>
                                    </div>
                                </div>
                            </div>
                            <h6 style="padding-bottom: 2rem;">Cargando ...</h6>
                        </div>
                        <!-- Loader -->
                        <table class="crud_table centered responsive-table">
                            <thead>
                                <tr>
                                    <th scope="col">fecha</th>
                                    <th scope="col">Ingreso</th>
                                    <th scope="col">Egreso</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Logo</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </article>
            </section>
            <section class="paginate ">
                <ul class="pagination center col l12">
                </ul>
            </section>
            <template id="crud_template">
                <tr>
                    <td class="registry"></td>
                    <td class="ingress"></td>
                    <td class="egrees"></td>
                    <td class="stock"></td>
                    <td class="logo"></td>
                    <td>
                        <a href="#section1"><i class="small material-icons edit ">create</i></a>
                        <a class="modal-trigger edit" href="#idModal"><i class="small material-icons delete-icon">delete</i></a>
                    </td>
                </tr>
            </template>

        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let $exitButton = document.getElementById("scale-demo");
            setTimeout(() => {
                $exitButton.classList.remove("scale-out");
            }, 300);
        });

        document.addEventListener("click", (e) => {
            let $exitButton = document.getElementById("scale-demo");
            if (e.target.matches(".icon-remove")) {
                $exitButton.classList.add("scale-out");
                location.href = "<?php echo url('close.php'); ?>";
            }
        });
    </script>
    <script src="../js/index.js" type="module"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>

</html>