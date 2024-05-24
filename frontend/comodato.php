<?php require_once "_verifica_login.php"; ?>
<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comodato - Empréstimo e Devolução</title>
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
          <h5>Clientes</h5>
          <!-- Botão para abrir o modal de adicionar cliente -->
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdicionarCliente">
            Emprestar produto
          </button>

          <!-- Modal de Adicionar Cliente -->
          <div class="modal fade" id="modalAdicionarCliente" tabindex="-1" aria-labelledby="modalAdicionarClienteLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalAdicionarClienteLabel">Criação de comodato</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <!-- Formulário de Adição de Cliente -->
                  <form id="formComodato">
                    <div class="mb-3">
                      <label for="produto" class="form-label">Produto:</label>
                      <select class="form-select" id="produto" name="produto">
                        <!-- Os produtos serão inseridos aqui dinamicamente via JavaScript -->
                      </select>
                    </div>
                    <!-- Quantidade -->
                    <div class="mb-3">
                      <label for="quantidade" class="form-label">Quantidade:</label>
                      <input type="number" class="form-control" id="quantidade" name="quantidade" required>
                    </div>
                    <!-- Cliente -->
                    <div class="mb-3">
                      <label for="cliente" class="form-label">Cliente:</label>
                      <select class="form-select" id="cliente" name="cliente">
                        <!-- Os clientes serão inseridos aqui dinamicamente via JavaScript -->
                      </select>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-primary" onclick="criarComodato()">Criar Comodato</button>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-light rounded h-100 p-4">
              <div class="input-group mb-3">
  <input type="text" id="filtroCliente" class="form-control" placeholder="Filtrar por nome do cliente" oninput="fetchComodatos()">
  <button class="btn btn-outline-secondary" type="button" onclick="fetchComodatos()">Filtrar</button>
</div>


            <div class="table-responsive">
              <table class="table" id="listaClientes">
                <thead>
                  <tr>
                    <th>Produto</th>
                    <th>Cliente</th>
                    <th>QTD</th>
                    <th>Devolvido</th>
                    <th>Devolução</th>
                  </tr>
                </thead>
                <tbody id="corpoListaComodato">
                  <!-- Os comodatos serão inseridos aqui dinamicamente via JavaScript -->
                </tbody>
              </table>
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
  <script src="js/perso.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      fetchClientes();
      fetchProdutos();
      fetchComodatos();


    });


    document.addEventListener('DOMContentLoaded', () => {
      document.getElementById('listaClientes').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        if (form.classList.contains('devolucaoForm')) {
          const formData = new FormData(form);
          // converter pra JSON
          const dados = {
            emprestimoId: formData.get('emprestimoId'),
            quantidadeDevolvida: formData.get('quantidadeDevolvida')
          };
          fetch('../backend/controllers/comodato/devolucao.php', {
              method: 'POST',
              body: JSON.stringify(dados),
            })
            .then(response => response.json())
            .then(data => {
              if (data.sucesso) {
                alert(data.mensagem);
                fetchComodatos(); // Atualizar a lista após a devolução
              } else {
                alert('Erro: ' + data.mensagem);
              }
            })
            .catch(error => {
              console.error('Erro na requisição:', error);
              alert('Falha ao enviar dados.');
            });
        }
      });
    });

    function fetchComodatos() {
  const filtroCliente = document.getElementById('filtroCliente').value;

  fetch('../backend/controllers/comodato/buscarComodatos.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ filtro: filtroCliente })
  })
  .then(response => response.json())
  .then(comodatos => {
    const tbody = document.getElementById('corpoListaComodato');
    tbody.innerHTML = ''; // Limpa o corpo da tabela antes de adicionar novos dados
    comodatos.forEach(comodato => {
      const maxDevolucao = comodato.quantidade - comodato.devolvido;
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${comodato.nome_produto}</td>
        <td>${comodato.nome_cliente}</td>
        <td>${comodato.quantidade}</td>
        <td>${comodato.devolvido}</td>
        <td>
        <form class="devolucaoForm d-flex align-items-center" style="gap: 10px;">
            <input type="hidden" name="emprestimoId" value="${comodato.id}">
            <input type="number" class="form-control" style="min-width: 40px;" name="quantidadeDevolvida" placeholder="QTD" min="0" max="${maxDevolucao}" required>
            <button type="submit" class="btn btn-success">Enviar</button>
          </form>
        </td>
      `;
      tbody.appendChild(tr);
    });
  })
  .catch(error => console.error('Erro ao buscar comodatos:', error));
}



    function fetchProdutos() {
      fetch('../backend/controllers/listarProdutos.php')
        .then(response => response.json())
        .then(produtos => {
          produtos.forEach((produto, index) => {
            // Adicionar no modal de criar comodato
            const option = document.createElement('option');
            option.value = produto.id;
            option.innerText = produto.descricao;
            document.getElementById('produto').appendChild(option);

          });
        })
        .catch(error => console.error('Erro ao buscar produtos:', error));
    }

    function fetchClientes() {
      fetch('../backend/controllers/buscarClientes.php')
        .then(response => response.json())
        .then(clientes => {
          clientes.forEach(cliente => {
            // Adicionar no modal de criar comodato
            const option = document.createElement('option');
            option.value = cliente.id;
            option.innerText = cliente.nome_razao_social;
            document.getElementById('cliente').appendChild(option);
          });
        });
    }

    function criarComodato() {
      // Captura os valores dos campos do formulário
      const produto = document.getElementById('produto').value;
      const quantidade = document.getElementById('quantidade').value;
      const cliente = document.getElementById('cliente').value;

      // Cria um objeto com os dados
      const dadosComodato = {
        produto,
        quantidade,
        cliente
      };

      // Envia a requisição
      fetch('../backend/controllers/comodato/criarComodato.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(dadosComodato)
        })
        .then(response => response.json())
        .then(data => {
          if (data.sucesso) {
            alert(data.mensagem);
            $('#modalAdicionarCliente').modal('hide');
            // Atualiza a lista de clientes/comodatos após adicionar um novo
            fetchComodatos();
          } else {
            alert('Erro: ' + data.mensagem);
          }
        })
        .catch(error => {
          console.error('Erro na requisição:', error);
          alert('Falha ao enviar dados.');
        });
    }
  </script>

</body>

</html>