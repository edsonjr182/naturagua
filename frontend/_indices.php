<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<div class="container-fluid pt-3 px-3">
    <h2>Barracão</h2>
    <div class="row g-3">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-balance-scale fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Galão 20L</p>
                    <h5 id="diferenca-Galao20L" class="mb-0">...</h5>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-balance-scale fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">P13</p>
                    <h5 id="diferenca-P13" class="mb-0">...</h5>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-balance-scale fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">P45</p>
                    <h5 id="diferenca-P45" class="mb-0">...</h5>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-balance-scale fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">P20</p>
                    <h5 id="diferenca-P20" class="mb-0">...</h5>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="container-fluid pt-3 px-3">
    <h2>Emprestados</h2>
    <div class="row g-3">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-line fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Galão 20L Emprestado</p>
                    <h5 id="quantidade-Galao20L-comodato" class="mb-0">...</h5>
                    <h6 id="valor-Galao20L-comodato" class="mb-0">...</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-bar fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">P13 Emprestado</p>
                    <h5 id="quantidade-P13-comodato" class="mb-0">...</h5>
                    <h6 id="valor-P13-comodato" class="mb-0">...</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-area fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">P45 Emprestado</p>
                    <h5 id="quantidade-P45-comodato" class="mb-0">...</h5>
                    <h6 id="valor-P45-comodato" class="mb-0">...</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-area fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">P20 Emprestado</p>
                    <h5 id="quantidade-P20-comodato" class="mb-0">...</h5>
                    <h6 id="valor-P20-comodato" class="mb-0">...</h6>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="container-fluid pt-3 px-3">
    <h2>Estoque total</h2>
    <div class="row g-3">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-line fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Galão 20L</p>
                    <h5 id="quantidade-Galao20L" class="mb-0">...</h5>
                    <h6 id="valor-Galao20L" class="mb-0">...</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-bar fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total P13</p>
                    <h5 id="quantidade-P13" class="mb-0">...</h5>
                    <h6 id="valor-P13" class="mb-0">...</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-area fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total P45</p>
                    <h5 id="quantidade-P45" class="mb-0">...</h5>
                    <h6 id="valor-P45" class="mb-0">...</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-area fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total P20</p>
                    <h5 id="quantidade-P20" class="mb-0">...</h5>
                    <h6 id="valor-P20" class="mb-0">...</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Função para carregar os dados dos produtos
        function loadData() {
            $.ajax({
                url: '../backend/controllers/indiceProdutos.php', // Ajuste o caminho conforme necessário
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Itera sobre os dados recebidos e atualiza a página
                    data.forEach(function(produto) {
                        // Calcula a quantidade disponível no barracão (total - emprestado)
                        let disponivelNoBarracao = produto.quantidade_total - produto.quantidade_emprestada;

                        // Atualiza os elementos do DOM com os valores calculados
                        $('#diferenca-' + produto.tipo).text(disponivelNoBarracao);
                        $('#quantidade-' + produto.tipo + '-comodato').text(produto.quantidade_emprestada);
                        $('#valor-' + produto.tipo + '-comodato').text('R$ ' + (produto.quantidade_emprestada * 10)); // Exemplo de cálculo de valor
                        $('#quantidade-' + produto.tipo).text(produto.quantidade_total);
                        $('#valor-' + produto.tipo).text('R$ ' + (produto.quantidade_total * 10)); // Exemplo de cálculo de valor
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Erro ao obter dados: " + error);
                }
            });
        }

        // Chama a função loadData quando a página é carregada
        loadData();
    });
</script>