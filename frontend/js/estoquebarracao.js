document.addEventListener('DOMContentLoaded', function() {
    function calcularDiferenca(quantidadeTotalId, quantidadeComodatoId, resultadoId) {
        const total = parseInt(document.getElementById(quantidadeTotalId).textContent, 10);
        const comodato = parseInt(document.getElementById(quantidadeComodatoId).textContent, 10);
        document.getElementById(resultadoId).textContent = total - comodato;
    }

    calcularDiferenca('quantidade-Galao20L', 'quantidade-Galao20L-comodato', 'diferenca-Galao20L');
    calcularDiferenca('quantidade-P13', 'quantidade-P13-comodato', 'diferenca-P13');
    calcularDiferenca('quantidade-P45', 'quantidade-P45-comodato', 'diferenca-P45');
});
