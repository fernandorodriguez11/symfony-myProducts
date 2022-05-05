"use strict";

function addCarrito(id) {
  var cantidad = $("#" + id).val();
  console.log(id);
  console.log(cantidad);
  $.ajax({
    type: 'POST',
    url: Routing.generate('prueba'),
    data: {
      id: id,
      cantidad: cantidad
    },
    async: true,
    dataType: 'json',
    success: function success(data) {
      console.log(data); //windows.location.reload();
    }
  });
}