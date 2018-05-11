// source --> http://127.0.0.1/redis/wp-content/themes/rediscover1/js/cokdiripple.js?ver=3 
jQuery( document ).ready(function( $ ) {
  
	var element = '.btn , .navbar-nav li a, paginate_button a',
	   current, 
	   ripple, 
	   d, 
	   x, 
	   y;

	$(element).click(function (e) {

		current = $(this);

		// Cria o elemento .ripple caso ele n�o exista
		if (current.find(".ripple").length === 0) {

		  // Prepara o pai para receber o elemento .ripple
		  current.addClass('prepare-ripple');

		  // Insere o elemento .ripple no conte�do
		  current.prepend("<span class='ripple'></span>");
		}

		// Define o .ripple criado em uma vari�vel
		ripple = current.find(".ripple");

		// Em caso de cliques duplos r�pidos, para a anima��o anterior
		ripple.removeClass("on-animate");

		// Define o tamanho do .ripple
		if (!ripple.height() && !ripple.width()) {

		  // Usa a largura ou a altura do pai 
		  // O que for maior para fazer um c�rculo que pode cobrir todo o elemento.
		  d = Math.max(current.outerWidth(), current.outerHeight());

		  ripple.css({
			height: d,
			width: d
		  });
		}

		// Coordenadas do clique
		// L�gica = Coordenadas em rela��o a p�gina 
		// - Do pai, posi��o relativa para a p�gina
		x = e.pageX - current.offset().left - ripple.width() / 2;
		y = e.pageY - current.offset().top - ripple.height() / 2;

		// Define a posi��o e adiciona a classe .on-animate
		ripple.css({
		  top: y + 'px',
		  left: x + 'px'
		}).addClass("on-animate");
	});
});