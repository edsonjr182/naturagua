
<?php require_once "_verifica_login.php"; ?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios - Controle de Estoque</title>
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
   

<div class="container-fluid pt-4 px-4">
                <div class="bg-light text-left rounded p-4">
                    <div class="col-12">
                        <h5>Relatórios</h5>
                        <div class="bg-light rounded h-100 p-4">
                            <label for="tipoRelatorio" class="form-label">Tipo de Relatório</label>
        <select class="form-select" id="tipoRelatorio" name="tipoRelatorio">
            <option value="estoqueTotal">Estoque Total por Tipo</option>
            <option value="emprestadosCliente">Produtos Emprestados por Cliente</option>
            <option value="emprestadosTipo">Produtos Emprestados por Tipo</option>
        </select>
        <button class="btn btn-primary mt-2" onclick="gerarRelatorio()">Gerar Relatório</button>
                            <div class="table-responsive">
                                <div id="resultadoRelatorio">
        <!-- Os resultados do relatório serão exibidos aqui -->
    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
    <script src="js/personalizacao.js"></script>
    <script src="js/rela.js"></script>
   

</body>
</html>
