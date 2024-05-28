
let search = '';
let option = '';
let url = '';
let idpag = document.getElementById('pag');
$("#search").on("keyup", function () {
    search = $(this).val();
    option = $("#option").val();
    url = `/search?search=${search}&option=${option}`;
    idpag ? idpag.remove() : '';
    idpag = false;
    peticiones(url);

});
$(document).on("click", '.pagination a', function (e) {
    
    if(!idpag){
        e.preventDefault();
        page = $(this).attr("href");
        url = page;
        peticiones(url);
    }
   
 });
const peticiones = (url) => {
    fetch(url, { method: 'GET', headers: { 'X-CSRF-Token': $('meta[name="_token"]').attr('content') } })
        .then(response => response.text())
        .then(html => {
            document.getElementById(`table${option}`).innerHTML = html;
           
        });
}

// const dataView = (option, url) => {
//     switch (option) {
//         case 'Negocios':
//             peticiones(url);
//             break;

//         case 'Sucursales': 
//             peticiones(url);
//             break;

//         case 'Usuarios':
//             peticiones(url);
//             break;

//         case 'Almacenes':
//             peticiones(url);
//             break;

//         case 'Categorias':
//             peticiones(url);
//             break;
            
//         case 'Proveedores':
//             peticiones(url);
//             break;

//         case 'Productos':
//             peticiones(url);
//             break;

//         case 'Servicios':
//             peticiones(url);
//             break;
//         case 'Clientes':
//             peticiones(url);
//             break;

//         case 'Creditos':
//             peticiones(url);
//             break;

//         case 'Ventas':
//             peticiones(url);
//             break;

//         case 'Cotizaciones':
//             peticiones(url);
//             break;

//         case 'Gastos':
//             peticiones(url);
//             break;

//         default:
//             break;
//     }
// }

