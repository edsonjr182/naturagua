<?php require_once "_verifica_login.php"; ?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto</title>
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
                        <a class="nav-link" href="relatorios.php">Relatórios</a>
                    </li>
                    <!-- Adicione mais itens de menu conforme necessário -->
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2>Cadastro de Produto</h2>
        <form action="../backend/controllers/produtoController.php" method="POST">
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <select class="form-select" id="tipo" name="tipo">
                    <option value="P13">P13</option>
                    <option value="P45">P45</option>
                    <option value="Galao20L">Galão 20L</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <input type="text" class="form-control" id="descricao" name="descricao">
            </div>
            <div class="mb-3">
                <label for="quantidade" class="form-label">Quantidade</label>
                <input type="number" class="form-control" id="quantidade" name="quantidade" required>
            </div>
            <div class="mb-3">
                <label for="valor_custo" class="form-label">Valor de Custo</label>
                <input type="text" class="form-control" id="valor_custo" name="valor_custo" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>