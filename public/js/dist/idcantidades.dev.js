"use strict";

var id;
var valor;

function decrementar(e) {
  id = e;
  valor = parseInt($("#" + id).val());

  if (valor == 1) {
    alert("No puedes añadir cantidades 0 o negativos");
  } else {
    $("#" + id).val(valor - 1);
  }
}

function incrementar(e) {
  id = e;
  valor = parseInt($("#" + id).val());
  $("#" + id).val(valor + 1);
}

function guardarCesta(e) {
  console.log(e);
  $("#" + e).submit(function () {
    console.log("Enviado correctamente");
  });
}