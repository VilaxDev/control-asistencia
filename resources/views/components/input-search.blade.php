<form class="d-flex col-md-6 mb-3" role="search" onsubmit="return false;">
    <input id="searchInput" class="form-control me-2" type="search" placeholder="Buscar..." aria-label="Search">
    <button class="btn btn-outline-success" type="submit">Buscar</button>
</form>
<script>
    // Espera a que el DOM se cargue completamente
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('tbody tr');

        // Escucha el evento de entrada (input) en el campo de búsqueda
        searchInput.addEventListener('input', function() {
            const searchValue = searchInput.value.toLowerCase();

            tableRows.forEach(row => {
                // Busca dentro de las celdas de la fila
                const rowText = row.textContent.toLowerCase();

                // Si el texto de la fila incluye el valor de búsqueda, muéstrala, de lo contrario, escóndela
                if (rowText.includes(searchValue)) {
                    row.style.display = ''; // Mostrar fila
                } else {
                    row.style.display = 'none'; // Ocultar fila
                }
            });
        });
    });
</script>
