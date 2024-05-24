<?php require_once "_verifica_login.php"; ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios - Controle de Estoque</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Controle de Estoque</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="paginaInicial.php">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cadastroCliente.php">Cadastro de Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cadastroProduto.php">Cadastro de Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registroTransacao.php">Registro de Transações</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="relarorio.php">Relatórios</a>
                    </li>
                    <!-- Adicione mais itens de menu conforme necessário -->
                </ul>
            </div>
        </div>
    </nav>
<div class="container">
    <h2>Relatórios de Estoque</h2>
    
    <!-- Seção de Filtros -->
    <div class="mb-3">
        <label for="tipoRelatorio" class="form-label">Tipo de Relatório</label>
        <select class="form-select" id="tipoRelatorio" name="tipoRelatorio">
            <option value="estoqueTotal">Estoque Total por Tipo</option>
            <option value="emprestadosCliente">Produtos Emprestados por Cliente</option>
            <option value="emprestadosTipo">Produtos Emprestados por Tipo</option>
        </select>
        <button class="btn btn-primary mt-2" onclick="gerarRelatorio()">Gerar Relatório</button>
    </div>
    
    <!-- Área de Resultados do Relatório -->
    <div id="resultadoRelatorio">
        <!-- Os resultados do relatório serão exibidos aqui -->
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/rela.js"></script> <!-- Script para carregar e exibir os relatórios -->
</body>
</html>
