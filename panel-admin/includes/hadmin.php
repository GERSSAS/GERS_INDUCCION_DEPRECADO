<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../includes/sesion/session_check.php';
// Conexión a la base de datos
$conexion = mysqli_connect("database", "root", "docker", "administrador");

// Consulta para obtener las notificaciones no leídas
$query_notificaciones = "SELECT * FROM notificaciones WHERE leido = 0 ORDER BY fecha DESC";
$result_notificaciones = mysqli_query($conexion, $query_notificaciones);

// Contar el número de notificaciones no leídas
$num_notificaciones = mysqli_num_rows($result_notificaciones);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administrador</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../package/dist/sweetalert2.css">
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../css/style.css">

    <script src="../js/jquery.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../../index/index.php">
                <div class="sidebar-brand-text mx-3">Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            

        

            <!-- Nav Item - Pages Collapse Menu
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw  fa-folder-open"></i>
                    <span>Examenes</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Opciones</h6>
                        <a class="collapse-item" href="../views/inventario.php">Inducción</a>
                        <a class="collapse-item" href="../views/inventario.php">Reinducción</a>
                        
                    </div>
                </div>
            </li>
            Se implementa a futuro -->

            

            <!-- Nav Item - Tables -->
            


                
                <li class="nav-item">
                  <a class="nav-link" href="../views/usuarios.php">
                      <i class="fas fa-users fa-table"></i>
                      <span>Usuarios</span></a>
              </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>



        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <img class="logoTop" style="width: 15%;" src="../../assets/imagenes/gers_azul.png">


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
<li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <!-- Counter - Alerts -->
        <span class="badge badge-danger badge-counter">
            <?php echo $num_notificaciones > 0 ? $num_notificaciones . '+' : '0'; ?>
        </span>
    </a>
    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">Notificaciones</h6>

        <?php
        // Si hay notificaciones no leídas
        if ($num_notificaciones > 0) {
            while ($notificacion = mysqli_fetch_assoc($result_notificaciones)) {
                echo '<div class="dropdown-item d-flex align-items-center">';
                echo '<div class="mr-3">';
                echo '<div class="icon-circle bg-primary">';
                echo '<i class="fas fa-file-alt text-white"></i>';
                echo '</div>';
                echo '</div>';
                echo '<div>';
                echo '<div class="small text-gray-500">' . $notificacion['fecha'] . '</div>';
                echo '<span class="font-weight-bold">' . $notificacion['mensaje'] . '</span>';
                echo '</div>';
                echo '<button class="btn btn-sm btn-success ml-auto marcar-leido" data-id="' . $notificacion['id'] . '">Marcar como leído</button>';
                echo '</div>';
            }
        } else {
            echo '<div class="dropdown-item text-center small text-gray-800">No hay nuevas notificaciones</div>';
        }
        ?>
        
        <a class="dropdown-item text-center small text-gray-800" href="#">Cerrar</a>
    </div>
</li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo $_SESSION['usuario']; ?>
                                </span>
                                <img class="img-profile rounded-circle" src="../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="../views/profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-600"></i>
                                    Perfil
                                </a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-600"></i>
                                    Cerrar Sesión
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <?php include "../views/salir.php"; ?>

                <script>
$(document).ready(function() {
    $('.marcar-leido').on('click', function() {
        var notificacionId = $(this).data('id');
        
        $.ajax({
            url: '../views/marcar_leido_ajax.php',
            method: 'POST',
            data: { id: notificacionId },
            success: function(response) {
                if (response == 'success') {
                    // Remover la notificación de la lista
                    location.reload();  // Puedes actualizar la página o remover la notificación con JS
                } else {
                    alert('Error al marcar la notificación como leída.');
                }
            }
        });
    });
});
</script>
