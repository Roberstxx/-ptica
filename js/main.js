function cargarSeccion(seccion) {
    fetch('funciones.php?seccion=' + seccion)
        .then(response => response.text())
        .then(data => {
            document.getElementById('contenido').innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
}
