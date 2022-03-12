// Agrega credenciales de SDK
const PublicKey="TEST-0ff443a1-c8c8-42d0-b5ac-521fc9fed8a7";
const AccessToken="TEST-2913430827228064-030200-e97bc2e6bbed40438dae7af5f6d0b693-59366921";


//Defino la variable de Mercado Pago
const mp = new MercadoPago(PublicKey, {
    locale: "es-AR",
});



//Funcion que realiza el carrito de compras
function realizarPago(idVenta,idContenedorMp) {
 let contenedorMp=document.getElementById(idContenedorMp);
 let ventaMp=idVenta;


	// Inicializa el checkout
    mp.checkout({
        preference: {
         id: ventaMp,
        },
        render: {
         container: ".contenedorMp", // Indica el nombre de la clase donde se mostrará el botón de pago
         label: "Pagar", // Cambia el texto del botón de pago (opcional)
        },
    });

    
    

}
  