<?php
require_once '../backend/config/conn.php';

// Buscar produtos
$stmtProdutos = $pdo->query("SELECT id, descricao FROM produtos");
$produtos = $stmtProdutos->fetchAll();
?>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>


<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-left rounded p-4">
        <div class="col-12">
            <h5>Registro de Movimento</h5>
            <div class="bg-light rounded h-100 p-4">
                <div class="container">
                    <form action="../backend/controllers/transacaoController.php" method="POST">
                        <div class="mb-3">
                            <label for="produto_id" class="form-label">Produto</label>
                            <select class="form-select" id="produto_id" name="produto_id" required>
                                <option>Escolha um produto...</option>
                                <?php foreach ($produtos as $produto) : ?>
                                    <option value="<?= $produto['id']; ?>"><?= $produto['descricao']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tipo_transacao" class="form-label">Tipo de Transação</label>
                            <select class="form-select" id="tipo_transacao" name="tipo_transacao" required>
                                <option>Escolha uma opção abaixo...</option>
                                <option value="venda">Venda</option>
                                <option value="avaria">Avaria</option>
                                <option value="compra">Compra</option>
                                <!-- Adicione outras opções aqui conforme necessário -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="quantidade" class="form-label">Quantidade</label>
                            <input type="number" class="form-control" id="quantidade" name="quantidade" required min="0">
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar Transação</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Tratar a submissão do formulário
        $('form').submit(function(event) {
            event.preventDefault(); // Prevenir a submissão padrão do formulário

            var formData = $(this).serialize(); // Serializar os dados do formulário
            const dataJson = {
                produto_id: $('#produto_id').val(),
                tipo_transacao: $('#tipo_transacao').val(),
                quantidade: $('#quantidade').val()
            };


            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: JSON.stringify(dataJson),
                success: function(response) {
                    var data = JSON.parse(response); // Parsear a resposta JSON
                    if (data.sucesso) {
                        alert(data.mensagem); // Exibir mensagem de sucesso
                        location.reload(); // Recarregar a página
                    } else {
                        alert(data.mensagem); // Exibir mensagem de erro
                    }
                },
                error: function() {
                    alert('Erro ao processar a transação.'); // Mensagem de erro genérica
                }
            });
        });
    });
</script>