

document.addEventListener("DOMContentLoaded", function () {
  fetch("../backend/controllers/transacoes.php")
    .then((response) => response.json())
    .then((transacoes) => {

       const tbody = document.getElementById('movimento'); // Acessando pelo ID único
      transacoes.forEach((transacao, index) => {
        const row = tbody.insertRow();
        row.innerHTML = `
                            <th scope="row">${index + 1}</th>
                            <td>${transacao.cliente}</td>
                            <td>${transacao.tipo_transacao}</td>
                            <td>${transacao.produto}</td>
                            <td>${transacao.quantidade_total} un</td>
                            <td>R$ ${transacao.valor_total}</td>
                        `;
      });
    })
    .catch((error) => {
      console.error("Erro ao buscar dados:", error);
    });
});

document.addEventListener('DOMContentLoaded', function () {
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        const currentLocation = location.href; // Pega a URL atual

        navLinks.forEach((navLink) => {
            if (navLink.href === currentLocation) {
                // Adiciona a classe 'active' ao link que corresponde ao arquivo atual
                navLink.classList.add('active');
            } else {
                // Remove a classe 'active' se por acaso estiver setada em algum outro item
                navLink.classList.remove('active');
            }
        });
    });
