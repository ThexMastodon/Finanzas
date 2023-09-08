$(document).ready(function () {
  // Obtener todos los enlaces del menú con la clase 'nav-link' y que tengan un atributo 'href' no vacío
  var menuLinks = $('.navlink[href]:not([href=""]):not([href="#"]):not([href^="#"])');

  // Agregar la clase 'loading-button' a cada enlace del menú que cumpla con las condiciones
  menuLinks.addClass('loading-button');
});
