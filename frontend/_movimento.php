<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-left rounded p-4">
        <div class="col-12">
            <h5>Movimento</h5>
            <div class="bg-light rounded h-100 p-4">

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Movimento</th>
                                <th scope="col">Produto</th>
                                <th scope="col">Qtd</th>
                                <th scope="col">Valor total</th>
                            </tr>
                        </thead>
                        <tbody id="movimento">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('../backend/controllers/transacoes.php') // Ajuste este caminho para onde está hospedado seu script PHP que retorna o JSON
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('movimento');
                tbody.innerHTML = ''; // Limpa o conteúdo existente, se houver

                data.forEach((transacao, index) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                    <th scope="row">${index + 1}</th>
                    <td>${transacao.cliente}</td>
                    <td>${transacao.tipo_transacao}</td>
                    <td>${transacao.produto}</td>
                    <td>${transacao.quantidade_total}</td>
                    <td>R$ ${transacao.valor_total}</td>
                `;
                    tbody.appendChild(tr);
                });
            })
            .catch(error => console.error('Erro ao carregar transações:', error));
    });
</script>