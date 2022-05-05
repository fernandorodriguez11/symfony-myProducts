"use strict";

var seleccionados = []; //función para seleccionar el producto de la cesta concreto.

function seleccionar(e) {
  var id = e;

  if (seleccionados.includes(id)) {
    for (var i = 0; i < seleccionados.length; i++) {
      //Elimino el elemento del array para quitar la seleccion
      if (id == seleccionados[i]) {
        seleccionados.splice(i, 1);
        $("#seleccion" + id).css("border", "1px solid #FFB35E");
        $("#seleccion" + id).css("background", "#FFB35E");
        $("#i" + id).remove();
      }
    }
  } else {
    seleccionados.push(id);
    $("#seleccion" + id).css("border", "#6EC9F2");
    $("#seleccion" + id).css("background", "#6EC9F2");
    var input = $("<input/>", {
      id: "i" + id,
      name: "id" + id,
      value: id,
      type: "hidden"
    });
    $("#seleccion" + id).append(input);
  } //Aplicamos el efecto del botón comprar


  if (seleccionados.length != 0) {
    $("#pie").removeClass("desaparecer");
    $("#pie").addClass("aparecer");
  } else {
    $("#pie").removeClass("aparecer");
    $("#pie").addClass("desaparecer");
  }
}

function eliminar(id) {
  console.log(id);
  $("#" + id).css("display", "flex");
}