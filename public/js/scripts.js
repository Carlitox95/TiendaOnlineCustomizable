//Inicializo los select
document.addEventListener('DOMContentLoaded', function() {
 var elems = document.querySelectorAll('select');
 var instances = M.FormSelect.init(elems, {});
});

//Inicializar el sidenav
document.addEventListener('DOMContentLoaded', function() {
 var elems = document.querySelectorAll('.sidenav');
 var instances = M.Sidenav.init(elems,{});
});

//Inicializar el Carousel
document.addEventListener('DOMContentLoaded', function() {
 var elems = document.querySelectorAll('.carousel');
 var instances = M.Carousel.init(elems, opcionesCarousel);
});

let opcionesCarousel= { 
 numVisible:'5',
 indicators: true,
 noWrap: false,
 full_width: true,
}

//Inicializar el Slider
document.addEventListener('DOMContentLoaded', function() {
 var elems = document.querySelectorAll('.slider');
 var instances = M.Slider.init(elems, opcionesSlider);
});

let opcionesSlider= {
 indicators:true,
 height:800,
 duration:500,
 interval:600,
}

$(document).ready(function(){
 //Initialize dropdown
 $(".dropdown-trigger").dropdown();
});

$(document).ready(function() {
    $('#tabla').DataTable(  { 
     lengthMenu: [[50,100,-1], [50,100,"Todos"]],
     //dom: "<lf<t>ip>",
     dom: "Blfrtip",
         buttons: ['excel','csv',          
                {
                 extend: 'pdfHtml5',
                 orientation: 'landscape',
                 pageSize: 'LEGAL'
                },
            ],
     order: [[ 0, "asc" ]],             
     search: {return: true},
     pagingType: "full_numbers",
        language: {
         lengthMenu: "Mostrar _MENU_ registros",
         zeroRecords: "No se encontraron resultados",
         emptyTable: "No existen registros",
         loadingRecords: "cargando...",
         processing:     "procesando....",
         search:         "Busqueda:",
            paginate: {
             first:"Primera",
             last:"Ultima",
             next:"Siguiente ",
             previous: " Anterior"
            },
         //info: "Pagina _PAGE_ de _PAGES_",
         //infoEmpty: "No records available",
         //infoFiltered : "(Buscando entre _MAX_ registros)"
         sInfo:"Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
         sInfoEmpty:"Mostrando desde 0 hasta 0 de 0 registros",
         sInfoFiltered:"(filtrado de _MAX_ registros en total)",
         sInfoPostFix:  ""
        }       
    });
 //Voy a configurar los botones
 $(".dt-buttons").removeClass().addClass('col s4 cajaBotones').prepend("<br>");
 //Le voy a dar clase al filtro de cantidad a mostrar por pagina
 $('#tabla_length').removeClass();
 $('#tabla_length').addClass("col s4 dataTables_length");
 $('#tabla_length').prepend("<br>"); //inserto salto de linea para que quede alineado
 //Le voy a dar su clase al filtro de busqueda que no aparece
 $('#tabla_filter').removeClass();
 $('#tabla_filter').addClass("col s4");           
});    

//Funcion para quitar los acentos
function quitarAcentos(cadena){
 const acentos = {'á':'a','é':'e','í':'i','ó':'o','ú':'u','Á':'A','É':'E','Í':'I','Ó':'O','Ú':'U'};
 return cadena.split('').map( letra => acentos[letra] || letra).join('').toString();    
}

//Funcion para buscar productos
function buscadorProducto() {
//Obtengo los productos
productos= document.getElementsByName("productos");
//Obtengo el valor ingresado en el input del buscador
let valorIngresado=document.getElementById("parametroBusquedaProducto").value.toUpperCase();
valorIngresado=quitarAcentos(valorIngresado);
let coincidencias=0;
    //Vamos a iterar 1 a 1 con todas las busquedas
    for (let i = 0; i < productos.length; i++) {   
     let nombreProducto=productos[i].getAttribute("productoNombre"); 
        if (nombreProducto) {
            if (nombreProducto.toUpperCase().indexOf(valorIngresado) > -1) {
             //Si el parametro coincide con la busqueda lo dejo visible
             productos[i].style.display="block";
             coincidencias++;
             //Quito el cartel de aviso
             document.getElementById("mensajeBuscador").innerHTML=null;
            } 
            else {
             //Si no coincide con la busqueda oculto el contenido
             productos[i].style.display="none";
            }
        }                               
    }    
    //Si la caja de tramites me queda vacia... no hay resultadas de la busqueda
    if (coincidencias==0) {
     document.getElementById("mensajeBuscador").innerHTML="<strong><i class='material-icons'>error</i> No se encontraron resultados para la busqueda</strong>";
    }      
}


//Funcion para renderizar el menu
function renderizarMenu(jsonResponse) {
 //Obtengo el estado de las ventas del sistema
 let estadoVentas=jsonResponse.estadoVentas;
 //Obtengo el contenedor de los Links
 let contenedorLinks=document.getElementById("contenedorLinks");
 //Obtengo el primer hijo del contenedor de links
 let linksMenu=contenedorLinks.childNodes;

 //Obtengo el contenedor de los Links para la version Movil
 let contenedorLinksMovil=document.getElementById("mobile-demo");
  //Obtengo el primer hijo del contenedor de links para la version Movil
 let linksMenuMovil=contenedorLinksMovil.childNodes;

    //Si las ventas estas activas entonces genero los links del carrito y mis ventas
    if(estadoVentas == true) {
     //Link para las ventas del usuario
     let linkVentas=document.createElement("li");
     let aVentas=document.createElement("a");
     aVentas.setAttribute("href","/venta");
     aVentas.innerHTML="<i class='material-icons left'>shop</i> Mis Compras";
     linkVentas.appendChild(aVentas);
     //Link para el carrito de compras del usuario
     let linkCarrito=document.createElement("li");
     let aCarrito=document.createElement("a");
     aCarrito.setAttribute("href","/carrito");
     aCarrito.innerHTML="<i class='material-icons left'>add_shopping_cart</i> Carrito";
     linkCarrito.appendChild(aCarrito);
     //Inserto los Links despues del HOME
     contenedorLinks.insertBefore(linkVentas,linksMenu[2]);
     contenedorLinks.insertBefore(linkCarrito,linksMenu[2]);


     //Link para las ventas del usuario
     let linkVentasMovil=document.createElement("li");
     let aVentasMovil=document.createElement("a");
     aVentasMovil.setAttribute("href","/venta");
     aVentasMovil.innerHTML="<i class='material-icons left'>shop</i> Mis Compras";
     linkVentasMovil.appendChild(aVentasMovil);
     //Link para el carrito de compras del usuario
     let linkCarritoMovil=document.createElement("li");
     let aCarritoMovil=document.createElement("a");
     aCarritoMovil.setAttribute("href","/carrito");
     aCarritoMovil.innerHTML="<i class='material-icons left'>add_shopping_cart</i> Carrito";
     linkCarritoMovil.appendChild(aCarritoMovil);
     //Inserto los Links despues del HOME
     contenedorLinksMovil.insertBefore(linkVentasMovil,linksMenuMovil[2]);
     contenedorLinksMovil.insertBefore(linkCarritoMovil,linksMenuMovil[2]);
    }

}

//Funcion para renderizar el menu principal
function consultarEstadoVentas(urlApi,usuarioLogueado) {
    //Inicio la peticion del Request
    $.ajax({ 
     type: 'POST', 
       url: urlApi,           
        //Si la conexion es existosa 
        success: function(response) {        
            //Si hay un usuario logueado renderizo el menu
            if(usuarioLogueado==1) {
             renderizarMenu(response);  
            }           
        },
        //Si hay un error lo muestro
        error: function() {
         mostrarAlerta('Se ha producido un error al consultar el Menu');
         
        } 
    });
}

//Funcion para renderizar el mensaje de quienes somos
function consultarMensajeTienda(urlApi) {
    //Inicio la peticion del Request
    $.ajax({ 
     type: 'POST', 
       url: urlApi,           
        //Si la conexion es existosa 
        success: function(response) {        
            //Si hay un usuario logueado renderizo el menu            
            if(response.estado == true) {
             document.getElementById("mensajeHomeFooter").innerHTML=response.infoTienda;
            }       
        },
        //Si hay un error lo muestro
        error: function() {
         mostrarAlerta('Se ha producido un error al consultar el Menu');         
        } 
    });
}

//Funcion para obtener el nombre de la Tienda
function obtenerNombreTienda(urlApi) {
    //Inicio la peticion del Request
    $.ajax({ 
     type: 'POST', 
       url: urlApi,           
        //Si la conexion es existosa 
        success: function(response) {        
         //Obtengo el nombre de la tienda            
         document.title =response.nombreTienda;                  
        },
        //Si hay un error lo muestro
        error: function() {
         mostrarAlerta('Se ha producido un error al consultar el Menu');         
        } 
    });

}


