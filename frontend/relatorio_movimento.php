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
    <div class="bg-light  rounded p-4">
        <div class="col-12">
            <h1 class="mb-4">Extrato de movimentações</h1>
            <form id="filtroForm" class="mb-3">
                <div class="mb-3">
                    <label class="form-label" for="tipoTransacao">Tipo de Transação:</label>
                    <select class="form-select" id="tipoTransacao" name="tipoTransacao">
                        <option value="todos">Todos</option>
                        <option value="compra">Compra</option>
                        <option value="comodato">Comodato</option>
                        <option value="avaria">Avaria</option>
                        <option value="venda">Venda</option>
                        <option value="comodato_retorno">Retorno de Comodato</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="intervalo">Intervalo de Data:</label>
                    <select class="form-select" id="intervalo" name="intervalo">
                        <option value="7dias">Últimos 7 Dias</option>
                        <option value="15dias">Últimos 15 Dias</option>
                        <option value="mensal">Último Mês</option>
                        <option value="anual">Último Ano</option>
                    </select>
                </div>
                <button class="btn btn-secondary" type="button" onclick="loadData()">Gerar Relatório</button>
                <button class="btn btn-primary mr-10" id="pdfButton" style="display: none;" onclick="generatePDF()">Gerar PDF</button>

            </form>
            <table id="relatorioTable" class="table table-striped table-hover table-bordered">
                <thead class="table">
                    <tr>
                        <th>Data</th>
                        <th>Tipo de Transação</th>
                        <th>Nome do Cliente</th>
                        <th>Nome do Produto</th>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Os dados do relatório serão inseridos aqui -->
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
  <!-- Template Javascript -->
  <script src="js/main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

  <script>
    function loadData() {
  var tipoTransacao = $("#tipoTransacao").val();
  var intervalo = $("#intervalo").val();

  $.ajax({
    url: "../../backend/controllers/relatorios/relatorioMovimento.php",
    type: "GET",
    dataType: "json",
    data: {
      tipoTransacao: tipoTransacao,
      intervalo: intervalo
    },
    success: function (data) {
      $("#relatorioTable tbody").empty();

      if (data.length > 0) {
        $.each(data, function (index, row) {
          $("#relatorioTable tbody").append(
            "<tr>" +
            "<td>" + row.Data + "</td>" +
            "<td>" + row.Tipo_de_Transacao + "</td>" +
            "<td>" + (row.Nome_Cliente || ' ') + "</td>" +
            "<td>" + row.Nome_Produto + "</td>" +
            "<td>" + row.Quantidade + "</td>" +
            "</tr>"
          );
        });
        // Mostrar o botão de gerar PDF somente após os dados serem carregados
        $("#pdfButton").show();
      } else {
        $("#relatorioTable tbody").append("<tr><td colspan='5' class='text-center'>Nenhuma transação encontrada para os critérios selecionados.</td></tr>");
        $("#pdfButton").hide();  // Esconder o botão se não há dados
      }
    },
    error: function (xhr, status, error) {
      console.error("Erro ao obter dados: " + xhr.responseText + "\nStatus: " + status + "\nError: " + error);
      $("#relatorioTable tbody").empty();
      $("#relatorioTable tbody").append("<tr><td colspan='5' class='text-center'>Erro ao carregar dados.</td></tr>");
      $("#pdfButton").hide();  // Esconder o botão em caso de erro
    }
  });
}


function getCurrentDateTime() {
  const now = new Date();
  const year = now.getFullYear().toString().slice(2); // Obtém os dois últimos dígitos do ano
  const month = (now.getMonth() + 1).toString().padStart(2, "0"); // Mês começa de 0
  const day = now.getDate().toString().padStart(2, "0");
  const hour = now.getHours().toString().padStart(2, "0");
  const minute = now.getMinutes().toString().padStart(2, "0");

  return `${day}${month}${year}_${hour}${minute}`;
}

function generatePDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();

  // Cabeçalhos e dados da tabela
  const headers = [
    [
      "Data",
      "Tipo de Transação",
      "Nome do Cliente",
      "Nome do Produto",
      "Quantidade"
    ]
  ];
  const data = Array.from(
    document.querySelectorAll("#relatorioTable tbody tr")
  ).map((tr) => {
    return Array.from(tr.querySelectorAll("td")).map((td) => td.innerText);
  });

  // Adiciona título e gera a tabela
  doc.text("Extrato de Transações", 14, 16);
  doc.setFontSize(11);
  doc.autoTable({
    head: headers,
    body: data,
    startY: 22,
    theme: "striped",
    styles: { font: "helvetica", fontSize: 10, halign: "left", cellPadding: 2 },
    headStyles: { fillColor: [22, 160, 133], textColor: [255, 255, 255] },
    margin: { top: 25 }
  });

  // Nome do arquivo com data e hora
  const dateTime = getCurrentDateTime();
  const fileName = `Extrato_movimento_${dateTime}.pdf`;

  // Salva o PDF
  doc.save(fileName);
}

  </script>

</body>

</html>