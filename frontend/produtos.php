<?php require_once "_verifica_login.php"; ?>
<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produtos - Controle de Estoque</title>
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
          <h5>Produtos</h5>
          <!-- Botão para abrir o modal de adicionar produto -->
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdicionarProduto">
            Adicionar Produto
          </button>

          <?php
          if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1) {
            echo '<div class="alert alert-success mt-3" role="alert">
                      Produto cadastrado com sucesso!
                    </div>';
          }
          ?>

          <!-- Modal de Adicionar Produto -->
          <!-- Inclua aqui o HTML do modal, similar ao modal de adicionar cliente -->
          <!-- Modal de Adicionar Produto -->
          <div class="modal fade" id="modalAdicionarProduto" tabindex="-1" aria-labelledby="modalAdicionarProdutoLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalAdicionarProdutoLabel">Adicionar Novo Produto</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="../backend/controllers/produtoController.php" method="POST">
                    <div class="mb-3">
                      <label for="tipo" class="form-label">Tipo</label>
                      <select class="form-select" id="tipo" name="tipo">
                        <option value="Galao20L">Galão 20L</option>
                        <option value="P13">P13</option>
                        <option value="P45">P45</option>
                        <option value="P20">P20</option>

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
              </div>
            </div>
          </div>

          <!-- Modal de Editar Produto -->
          <div class="modal fade" id="modalEditarProduto" tabindex="-1" aria-labelledby="modalEditarProdutoLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalEditarProdutoLabel">Editar Produto</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form id="formEditarProduto">
                    <input type="hidden" id="produtoId" name="produtoId"> <!-- Campo oculto para ID -->
                    <div class="mb-3">
                      <label for="descricao_edit" class="form-label">Descrição</label>
                      <input type="text" class="form-control" id="descricao_edit" name="descricao">
                    </div>
                    <div class="mb-3">
                      <label for="valor_edit" class="form-label">Valor de Custo</label>
                      <input type="text" class="form-control" id="valor_edit" name="valor_custo" required>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-primary" onclick="salvarEdicaoProduto()">Salvar Alterações</button>
                </div>
              </div>
            </div>
          </div>


          <!-- Tabela de produtos -->
          <table class="table" id="tabelaProdutos">
            <thead>
              <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Disponível</th>
                <th>Valor Unitário</th>
                <th>Valor total</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody id="corpoTabelaProdutos">
              <!-- Os produtos serão inseridos aqui dinamicamente via JavaScript -->
            </tbody>
          </table>
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
    document.addEventListener('DOMContentLoaded', function() {
      fetchProdutos();
    });

    function fetchProdutos() {
      fetch('../backend/controllers/listarProdutos.php')
        .then(response => response.json())
        .then(produtos => {
          const tbody = document.querySelector('#tabelaProdutos tbody');
          tbody.innerHTML = ''; // Limpa a lista atual
          produtos.forEach((produto, index) => {
            const tr = tbody.insertRow();
            tr.innerHTML = `
              <td>${produto.descricao}</td>
              <td>${produto.quantidade}</td>
              <td>${produto.quantidade-produto.quantidade_emprestada}</td>
              <td>R$ ${parseFloat(produto.valor_custo).toFixed(2)}</td>
              <td>R$ ${produto.valor_total}</td> <!-- Exibe o valor total calculado -->
              <td>
                  <button type="button" class="btn btn-sm btn-sm-square btn-outline-primary m-2" onclick="editarProduto(${produto.id})"><i class="fa fa-edit"></i></button>
                  
                  <button type="button" class="btn btn-sm btn-sm-square btn-outline-primary m-2" onclick="confirmarDelecaoProduto(${produto.id})"><i class="fa fa-trash"></i></button>
              </td>`;

          });
        })
        .catch(error => console.error('Erro ao buscar produtos:', error));
    }

    function confirmarDelecaoProduto(produtoId) {
      const confirmacao = confirm("Tem certeza que deseja deletar este produto?");
      if (confirmacao) {
        fetch('../backend/controllers/deletarProdutos.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
              produtoId
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.sucesso) {
              alert(data.mensagem);
              fetchProdutos(); // Recarrega a lista de produtos
            } else {
              alert(data.mensagem);
            }
          })
          .catch(error => {
            console.error('Erro ao deletar produto:', error);
            alert('Erro ao deletar produto.');
          });
      }
    }

    function editarProduto(produtoId) {
      fetch(`../backend/controllers/buscarProduto.php?id=${produtoId}`)
        .then(response => response.json())
        .then(produto => {
          if (produto.message) {
            alert(produto.message);
          } else {
            // Preenche os campos do formulário no modal com os dados do produto
            document.getElementById('produtoId').value = produtoId;
            document.getElementById('descricao_edit').value = produto.descricao;
            document.getElementById('valor_edit').value = produto.valor_custo;

            // Abre o modal de edição
            var modalEditarProduto = new bootstrap.Modal(document.getElementById('modalEditarProduto'));
            modalEditarProduto.show();
          }
        })
        .catch(error => {
          console.error('Erro ao buscar dados do produto:', error);
        });
    }

    function salvarEdicaoProduto() {
      const produtoId = document.getElementById('produtoId').value; // Certifique-se de ter um campo oculto para o ID no formulário
      const descricao = document.getElementById('descricao_edit').value;
      const valor_custo = document.getElementById('valor_edit').value;

      // Objeto com os dados do produto para enviar ao back-end
      const dadosProduto = {
        produtoId,
        descricao,
        valor_custo
      };

      fetch('../backend/controllers/atualizarProduto.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(dadosProduto)
        })
        .then(response => response.json())
        .then(data => {
          // Verifica se a atualização foi bem-sucedida e fecha o modal
          if (data.sucesso) {
            alert("Produto atualizado com sucesso!");
            var modalEditarProduto = bootstrap.Modal.getInstance(document.getElementById('modalEditarProduto'));
            modalEditarProduto.hide();
            // Atualiza a tabela de produtos para refletir as mudanças
            fetchProdutos();
          } else {
            // Trata possíveis erros, como validações do lado do servidor
            alert("Erro ao atualizar o produto: " + data.mensagem);
          }
        })
        .catch((error) => {
          console.error('Erro:', error);
          alert("Erro ao atualizar o produto.");
        });
    }


    // Implemente a função editarProduto de forma similar à editarCliente
  </script>

</body>

</html>