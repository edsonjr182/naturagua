
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
        </select>
       
        <button class="btn btn-secondary mt-2" onclick="gerarPDF()">Imprimir em PDF</button>

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>


    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    
    
    <script>
    
    function gerarRelatorio() {
    const tipoRelatorio = document.getElementById('tipoRelatorio').value;
    let url = `../../backend/controllers/relatorios/${tipoRelatorio}.php`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const resultado = document.getElementById('resultadoRelatorio');
            resultado.innerHTML = ''; // Limpa resultados anteriores

            // Cria e configura a tabela
            const tabela = document.createElement('table');
            tabela.className = 'table table-striped'; // Classes do Bootstrap

            // Cria o cabeçalho da tabela dinamicamente
            const thead = tabela.createTHead();
            const row = thead.insertRow();
            const colunas = ['Cliente', 'Tipo_de_produto', 'Quantidade_em_comodato', 'Custo_total'];

            colunas.forEach(coluna => {
                const th = document.createElement('th');
                th.textContent = coluna.replace('_', ' ').toUpperCase(); // Transforma chave em texto legível
                row.appendChild(th);
            });

            // Preenche o corpo da tabela com os dados
            const tbody = tabela.createTBody();
            data.forEach(item => {
                const row = tbody.insertRow();
                colunas.forEach(coluna => {
                    const cell = row.insertCell();
                    cell.textContent = item[coluna] ? item[coluna] : 'Não fornecido'; // Insere dados ou uma mensagem padrão
                });
            });

            // Adiciona a tabela preenchida ao DOM
            resultado.appendChild(tabela);
        })
        .catch(error => {
            console.error('Erro ao buscar dados:', error);
            document.getElementById('resultadoRelatorio').innerHTML = `<p>Erro ao carregar o relatório: ${error.message}</p>`;
        });
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('tipoRelatorio').addEventListener('change', gerarRelatorio);
});

    
    
    
    
    
function gerarPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Seleciona a tabela HTML que você deseja converter em PDF
    const tabela = document.getElementById('resultadoRelatorio').getElementsByTagName('table')[0];

    // Configurações adicionais para autoTable
    doc.autoTable({
        html: tabela,
        theme: 'striped', // Temas: 'striped', 'grid', 'plain', 'css'
        startY: 20, // Inicia a tabela 10 unidades para baixo do topo da página
        styles: {
            fontSize: 8, // Tamanho da fonte dos dados da tabela
            cellPadding: 2, // Espaçamento interno das células
        },
        columnStyles: {
            0: {cellWidth: 30}, // Largura específica para a primeira coluna
            1: {cellWidth: 40}, // Largura específica para a segunda coluna
            2: {cellWidth: 'auto'}, // Largura automática para a terceira coluna
        },
        didDrawPage: function (data) {
            // Adiciona cabeçalho ou rodapé em cada página
            doc.text('Relatório vasilhame emprestado por cliente', 14, 15);
        },
        margin: {top: 20, right: 10, bottom: 10, left: 10}, // Margens da página
        tableWidth: 'auto' // Largura automática para ajustar ao conteúdo
    });

    // Salva o documento PDF
    doc.save('relatorio.pdf');
}



    </script>
   

</body>
</html>
