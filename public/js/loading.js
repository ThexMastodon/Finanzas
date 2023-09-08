$(document).ready(function () {
  // La página ha terminado de cargarse, ocultar el mensaje de carga
  $('#loading-screen').css('display', 'none');

  // Obtener todos los botones que tienen la clase "loading-button"
  var buttons = $('.loading-button');

  // Agregar un evento de clic a cada botón
  buttons.on('click', function () {
    // Mostrar el mensaje de carga
    $('#loading-screen').css('display', 'flex');
  });
});

