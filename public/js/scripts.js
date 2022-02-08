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

