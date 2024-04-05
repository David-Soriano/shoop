window.addEventListener("load", function () {
    document.getElementById("venpro").addEventListener("click", function () {
        alert("Producto subido exitosamente")
    })
})
window.addEventListener("load", function () {
    document.getElementById("btntrash").addEventListener("click", function () {
        confirm("¿Está seguro de querer eliminar el producto?")
    })
    document.getElementById("btnedit").addEventListener("click", function () {
        confirm("¿Está seguro de querer hacer cambios en el producto?")
    })
})

window.addEventListener('load', function () {
    document.getElementById("btn-conf-ped").addEventListener("click", function () {
        confirm("¿Desea confirmar el envío?")
    })
})