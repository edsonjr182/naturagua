

    <h2>Cadastro de Cliente</h2>
    <form action="../backend/controllers/clienteController.php" method="POST">
        <div class="mb-3">
            <label for="nome_razao_social" class="form-label">Nome/Razão Social</label>
            <input type="text" class="form-control" id="nome_razao_social" name="nome_razao_social" required>
        </div>
        <div class="mb-3">
            <label for="cpf_cnpj" class="form-label">CPF/CNPJ</label>
            <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" required>
        </div>
        <div class="mb-3">
            <label for="endereco" class="form-label">Endereço</label>
            <input type="text" class="form-control" id="endereco" name="endereco" required>
        </div>
        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="telefone" name="telefone" required>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
