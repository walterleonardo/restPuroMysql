$(document).ready(function(){


$("#libros").on('click', function(){

$.getJSON("http://walii.local.es/REST/Biblioteca/libros/lista")
    .done(function(datos_del_webServices){
    $("#resultadosLibro ul").html("");
    $.each(datos_del_webServices, function(indice, valor){
            $("#resultadosLibro ul").append("<li>" + valor.titulo + "</li>");
        });

    });
});


$("#autores").on('click', function(){

$.getJSON("http://walii.local.es/REST/Biblioteca/autores/lista")
    .done(function(datos_del_webServices){
    $("#resultadosAutor ul").html("");
    $.each(datos_del_webServices, function(indice, valor){
            $("#resultadosAutor ul").append("<li>" + valor.autor + "</li>");
        });

    });
});


});