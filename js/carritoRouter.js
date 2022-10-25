$(document).ready(function(){

    $(".botonAgregar").click(function(){
        var codigo;
        var cantidad;

        //Estamos trabajando el front end para extraer la data de la fila 
        $(this).parent().siblings().each(function( index ) {
            if(index == 1){
                codigo = $(this).text()
              //  console.log( "codigo: " + codigo);
            }else if(index == 6){        
                cantidad = $(this).children().val();
               //console.log( "cantidad: " + cantidad );
            }
          });
        
        //Llamar al php ("carrito.php") y pasarle los datos, estos 2 datos son los unicos que se utilizan para ir a carrito.php
        var request = $.ajax({
            url: "carrito.php",
            method: "POST",
            data: { p_codigo : codigo , p_cantidad : cantidad},
            dataType: "text" //Porque en la funcion anterior se uso json para traer a código y cantidad
        });
      
      //Lo que se hace desupués de que la request haya sido efectiva
      request.done(function( msg ) {
          console.log(msg);
          $("#tableBody").html(msg);
      });
      
      //Si la llamada o petición falla
      request.fail(function( jqXHR, textStatus ) {
        //alert( "Request failed: " + textStatus );
        alert("fallo");
      });

      });

       
   
  
  });