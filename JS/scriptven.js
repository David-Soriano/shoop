new DataTable('#tpro');

window.addEventListener("load", function(){
    document.getElementById("venpro").addEventListener("click", function(){
        alert("Producto subido exitosamente")
    })
})

window.addEventListener("load", function(){
    document.getElementById("btntrash").addEventListener("click", function(){
        confirm("¿Esta seguro de querer eliminar el producto?")
    })
})

window.addEventListener("load", function(){
    document.getElementById("btnedit").addEventListener("click", function(){
        confirm("¿Esta seguro de querer hacer cambios en el producto?")
    })
})
