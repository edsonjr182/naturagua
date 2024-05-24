<?php require_once "_verifica_login.php"; ?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimento - Controle de Estoque</title>
    <?php
    require_once "_head.php";
    ?>

<body>
    <!-- Topo e Sidebar -->
    <?php require_once "_sidebar.php"; ?>
    <!-- Topo e sidebar End -->

    <div class="content">
        <!-- Navbar Start -->
        <?php require_once "_navbar.php"; ?>
        <!-- Navbar End -->


        <!-- Movimento resumo -->
        <?php require_once "_registrotransacao.php"; ?>
        <?php require_once "_movimento.php"; ?>

        <!-- Movimento resumo End -->


        <!-- Footer Start -->
        <?php require_once "_footer.php"; ?>
        <!-- Footer End -->
    </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="js/persona.js"></script>


</body>

</html>