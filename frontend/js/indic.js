document.addEventListener("DOMContentLoaded", () => {
  atualizarIndices().then(() => {
    atualizarEstoqueTotal().then(() => {
      calcularDiferencas();
    });
  });
});

function atualizarIndices() {
  return fetch("../backend/controllers/indiceProdutos.php") // Ajuste o caminho conforme necessário
    .then((response) => response.json())
    .then((data) => {
      Object.entries(data).forEach(([tipo, produto]) => {
        // Atualiza a quantidade
        const quantidadeElemento = document.getElementById(`quantidade-${tipo}`);
        if (quantidadeElemento) {
          quantidadeElemento.textContent = `${produto.quantidade} un`;
        }
        // Atualiza o valor total
        const valorElemento = document.getElementById(`valor-${tipo}`);
        if (valorElemento) {
          valorElemento.textContent = `R$ ${produto.valor_total}`;
        }
      });
    })
    .catch((error) => {
      console.error("Erro ao buscar dados:", error);
    });
}

function atualizarEstoqueTotal() {
  return fetch("../backend/controllers/estoqueTotal.php")
    .then((response) => response.json())
    .then((data) => {
      const totalUnidadesElemento = document.getElementById("estoque-total-unidades");
      const totalValorElemento = document.getElementById("estoque-total-valor");
      if (totalUnidadesElemento) {
        totalUnidadesElemento.textContent = `${data.totalUnidades} un`;
      }
      if (totalValorElemento) {
        totalValorElemento.textContent = `R$ ${data.totalValor}`;
      }
    })
    .catch((error) => {
      console.error("Erro ao buscar dados:", error);
    });
}

function calcularDiferencas() {
  // Lista de produtos para calcular diferenças
  const produtos = ['Galao20L', 'P13', 'P45'];

  produtos.forEach(produto => {
    const total = document.getElementById(`quantidade-${produto}`).textContent;
    const comodato = document.getElementById(`quantidade-${produto}-comodato`).textContent;

    // Removendo ' un' e convertendo para número, definindo 0 como padrão se o parse falhar
    const totalNum = parseInt(total.replace(' un', ''), 10) || 0;
    const comodatoNum = parseInt(comodato.replace(' un', ''), 10) || 0;

    // Calculando diferença ou usando o total se não houver empréstimos
    const diferenca = (comodatoNum > 0) ? totalNum - comodatoNum : totalNum;
    document.getElementById(`diferenca-${produto}`).textContent = `${diferenca} un`;
  });
}

