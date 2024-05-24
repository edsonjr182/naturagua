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

            // Cria o cabeçalho da tabela dinamicamente baseado no tipo de relatório
            const thead = tabela.createTHead();
            const row = thead.insertRow();
            const colunas = Object.keys(data[0]); // Pega as chaves do primeiro objeto para o cabeçalho

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
