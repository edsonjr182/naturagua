<?php require_once "_verifica_login.php"; ?>
<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clientes - Controle de Estoque</title>
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
            Adicionar Cliente
          </button>

          <!-- Modal de Adicionar Cliente -->
          <div class="modal fade" id="modalAdicionarCliente" tabindex="-1" aria-labelledby="modalAdicionarClienteLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalAdicionarClienteLabel">Adicionar Novo Cliente</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <!-- Formulário de Adição de Cliente -->
                  <form id="formAdicionarCliente">
                    <div class="mb-3">
                      <label for="nomeRazaoSocialAdicionar" class="form-label">Nome/Razão Social</label>
                      <input type="text" class="form-control" id="nomeRazaoSocialAdicionar" name="nomeRazaoSocial" required>
                    </div>
                    <div class="mb-3">
                      <label for="cpfCnpjAdicionar" class="form-label">CPF/CNPJ</label>
                      <input type="text" class="form-control" id="cpfCnpjAdicionar" name="cpfCnpj" required>
                    </div>
                    <div class="mb-3">
                      <label for="enderecoAdicionar" class="form-label">Endereço</label>
                      <input type="text" class="form-control" id="enderecoAdicionar" name="endereco" required>
                    </div>
                    <div class="mb-3">
                      <label for="telefoneAdicionar" class="form-label">Telefone</label>
                      <input type="text" class="form-control" id="telefoneAdicionar" name="telefone" required>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-primary" onclick="adicionarCliente()">Salvar Cliente</button>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-light rounded h-100 p-4">

            <div class="table-responsive">
              <table class="table" id="listaClientes">
                <thead>
                  <tr>
                    <th>Nome/Razão Social</th>
                    <th>CPF/CNPJ</th>
                    <th>Endereço</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody id="corpolistaClientes">
                  <!-- Os clientes serão inseridos aqui dinamicamente via JavaScript -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Modal de Edição de Cliente -->
    <div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-labelledby="modalEditarClienteLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEditarClienteLabel">Editar Cliente</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Formulário de Edição -->
            <form id="formEditarCliente">
              <input type="hidden" id="clienteId">
              <div class="mb-3">
                <label for="nomeRazaoSocial" class="form-label">Nome/Razão Social</label>
                <input type="text" class="form-control" id="nomeRazaoSocial" required>
              </div>
              <div class="mb-3">
                <label for="cpfCnpj" class="form-label">CPF/CNPJ</label>
                <input type="text" class="form-control" id="cpfCnpj" required>
              </div>
              <div class="mb-3">
                <label for="endereco" class="form-label">Endereço</label>
                <input type="text" class="form-control" id="endereco" required>
              </div>
              <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" required>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="salvarEdicaoCliente()">Salvar</button>
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


    });

    function fetchClientes() {
      fetch('../backend/controllers/buscarClientes.php')
        .then(response => response.json())
        .then(clientes => {
          const tbody = document.getElementById('corpolistaClientes'); // Acessando pelo ID único
          clientes.forEach(cliente => {
            const tr = tbody.insertRow();
            tr.innerHTML = `
                    <td>${cliente.nome_razao_social}</td>
                    <td>${cliente.cpf_cnpj}</td>
                    <td>${cliente.endereco}</td>
                    <td>${cliente.telefone}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-sm-square btn-outline-primary m-2" onclick="editarCliente(${cliente.id})"><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-sm btn-sm-square btn-outline-primary m-2"onclick="confirmarDelecao(${cliente.id}, '${cliente.nome_razao_social.replace(/'/g, "\\'")}')"><i class="fa fa-trash"></i></button>
                    </td>
                `;
          });
        });
    }

    function editarCliente(clienteId) {
      fetch(`../backend/controllers/buscarClientePorId.php?clienteId=${clienteId}`)
        .then(response => response.json())
        .then(cliente => {
          if (cliente.erro) {
            alert(cliente.erro);
          } else {
            // Preenche os campos do formulário no modal com os dados do cliente
            document.getElementById('clienteId').value = cliente.id;
            document.getElementById('nomeRazaoSocial').value = cliente.nome_razao_social;
            document.getElementById('cpfCnpj').value = cliente.cpf_cnpj;
            document.getElementById('endereco').value = cliente.endereco;
            document.getElementById('telefone').value = cliente.telefone;

            // Abre o modal de edição
            var modalEditarCliente = new bootstrap.Modal(document.getElementById('modalEditarCliente'));
            modalEditarCliente.show();

          }
        })
        .catch(error => {
          console.error('Erro ao buscar dados:', error);
        });
    }


    function salvarEdicaoCliente() {
      const clienteId = document.getElementById('clienteId').value;
      const nomeRazaoSocial = document.getElementById('nomeRazaoSocial').value;
      const cpfCnpj = document.getElementById('cpfCnpj').value;
      const endereco = document.getElementById('endereco').value;
      const telefone = document.getElementById('telefone').value;

      // Objeto com os dados do cliente para enviar ao back-end
      const dadosCliente = {
        clienteId,
        nomeRazaoSocial,
        cpfCnpj,
        endereco,
        telefone
      };

      fetch('../backend/controllers/atualizarCliente.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(dadosCliente)
        })
        .then(response => response.json())
        .then(data => {
          // Verifica se a atualização foi bem-sucedida e fecha o modal
          if (data.sucesso) {
            alert("Cliente atualizado com sucesso!");
            var modalEditarCliente = bootstrap.Modal.getInstance(document.getElementById('modalEditarCliente'));
            modalEditarCliente.hide();
            // Atualiza a tabela de clientes para refletir as mudanças
            location.reload();
          } else {
            // Trata possíveis erros, como validações do lado do servidor
            alert("Erro ao atualizar o cliente: " + data.mensagem);
          }
        })
        .catch((error) => {
          console.error('Erro:', error);
          alert("Erro ao atualizar o cliente.");
        });
    }


    function confirmarDelecao(clienteId, nomeCliente) {
      const confirmacao = confirm(`Tem certeza que deseja deletar o cliente ${nomeCliente}?`);
      if (confirmacao) {
        fetch('../backend/controllers/deletarCliente.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
              clienteId: clienteId
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.sucesso) {
              alert(data.mensagem);
              // Recarrega a lista de clientes para refletir a exclusão
              location.reload();
            } else {
              alert(data.mensagem); // Exibe mensagem de erro (cliente com movimentos)
            }
          })
          .catch(error => {
            console.error('Erro ao deletar cliente:', error);
            alert('Erro ao deletar cliente.');
          });
      }
    }

    function adicionarCliente() {
      const nomeRazaoSocial = document.getElementById('nomeRazaoSocialAdicionar').value;
      const cpfCnpj = document.getElementById('cpfCnpjAdicionar').value;
      const endereco = document.getElementById('enderecoAdicionar').value;
      const telefone = document.getElementById('telefoneAdicionar').value;

      // Objeto com os dados do cliente para enviar ao backend
      const dadosCliente = {
        nomeRazaoSocial,
        cpfCnpj,
        endereco,
        telefone
      };

      fetch('../backend/controllers/adicionarCliente.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(dadosCliente)
        })
        .then(response => response.json())
        .then(data => {
          if (data.sucesso) {
            alert("Cliente adicionado com sucesso!");
            var modalAdicionarCliente = bootstrap.Modal.getInstance(document.getElementById('modalAdicionarCliente'));
            modalAdicionarCliente.hide();
            // Atualiza a tabela de clientes para refletir a adição
            location.reload();
          } else {
            alert("Erro ao adicionar o cliente: " + data.mensagem);
          }
        })
        .catch(error => {
          console.error('Erro ao adicionar cliente:', error);
          alert('Erro ao adicionar cliente.');
        });
    }
  </script>

</body>

</html>