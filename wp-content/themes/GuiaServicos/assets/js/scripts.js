$(function () {
	$('.mobile-nav-button').on('click', function () {
		// Toggles a class on the menu button to transform the burger menu into a cross
		$(".mobile-nav-button .mobile-nav-button__line:nth-of-type(1)").toggleClass("mobile-nav-button__line--1");
		$(".mobile-nav-button .mobile-nav-button__line:nth-of-type(2)").toggleClass("mobile-nav-button__line--2");
		$(".mobile-nav-button .mobile-nav-button__line:nth-of-type(3)").toggleClass("mobile-nav-button__line--3");

		// Toggles a class that slides the menu into view on the screen
		$('.mobile-menu-three').toggleClass('mobile-menu--open');
		$(this).toggleClass('close-menu');
		$(".header-col-logo img").toggleClass('show-logo');

		return false;
	});

	var $carousel = $('.carousel-banner-home').flickity({
		cellSelector: '.banners-cell',
		imagesLoaded: true,
		percentPosition: true,
		wrapAround: true,
		pauseAutoPlayOnHover: false,
		pageDots: true,
		initialIndex: 0,
		prevNextButtons: false,
		contain: true,
		cellAlign: 'left',
		autoPlay: 5000,
	});

	var $carousel = $('.carousel-posts').flickity({
		cellSelector: '.posts-cell',
		imagesLoaded: true,
		percentPosition: true,
		wrapAround: true,
		pauseAutoPlayOnHover: false,
		pageDots: true,
		initialIndex: 0,
		prevNextButtons: true,
		contain: true,
		cellAlign: 'center',
		autoPlay: 3000,
	});

    if (window.innerWidth < 1024) {
        var $carousel = $('.carousel-comercios').flickity({
            cellSelector: '.comercio',
            imagesLoaded: true,
            percentPosition: true,
            wrapAround: true,
            pauseAutoPlayOnHover: false,
            pageDots: true,
            initialIndex: 0,
            prevNextButtons: true,
            contain: true,
            cellAlign: 'center',
            autoPlay: 3000,
        });

         var $carousel = $('.carousel-planos').flickity({
            cellSelector: '.item-plano',
            imagesLoaded: true,
            percentPosition: true,
            wrapAround: true,
            pauseAutoPlayOnHover: false,
            pageDots: true,
            initialIndex: 0,
            prevNextButtons: true,
            contain: true,
            cellAlign: 'center',
            // autoPlay: 3000,
        });        
    }

	var options = {
		cellSelector: '.carousel-cell',
		imagesLoaded: true,
		percentPosition: true,
		pauseAutoPlayOnHover: false,
		pageDots: true,
		initialIndex: 0,
		prevNextButtons: false,
		contain: true,
		cellAlign: 'left'
	}

	var optionsdecola = {
		cellSelector: '.carousel-cell',
		imagesLoaded: true,
		percentPosition: true,
		pauseAutoPlayOnHover: false,
		pageDots: true,
		initialIndex: 0,
		prevNextButtons: false,
		contain: true,
		cellAlign: 'left'
	}

	var $fundochegajunto = $('.carousel-fundochegajunto').flickity({
		cellSelector: '.carousel-cell',
		fullscreen: true,
		imagesLoaded: true,
		percentPosition: true,
		wrapAround: true,
		pauseAutoPlayOnHover: false,
		// pageDots: false,
		initialIndex: 0,
		prevNextButtons: true,
		contain: true,
		autoPlay: 3000,
		cellAlign: 'center'
	});

	var $conhecacarousel = $('.carousel-fotos').flickity({
		cellSelector: '.carousel-cell',
		fullscreen: true,
		imagesLoaded: true,
		percentPosition: true,
		wrapAround: true,
		pauseAutoPlayOnHover: false,
		// pageDots: false,
		initialIndex: 0,
		prevNextButtons: true,
		contain: true,
		autoPlay: 3000,
		cellAlign: 'center'
	});

	var $lpcnh = $('.carousel-passos-cnh').flickity({
		cellSelector: '.carousel-cell',
		fullscreen: true,
		imagesLoaded: true,
		percentPosition: true,
		wrapAround: false,
		pauseAutoPlayOnHover: false,
		// pageDots: false,
		initialIndex: 0,
		prevNextButtons: true,
		contain: false,
		autoPlay: false,
		cellAlign: 'left'
	});
	if(matchMedia('screen and (min-width: 1024px)').matches) {
	  options.groupCells = 2;
	}

	$('.carousel-jeitoentregar').flickity(options);  
	$('.carousel-decola').flickity(optionsdecola); 

	$('.close-modal').on('click', function () {
		$('.modal').fadeOut();
		$('#video-frame').attr('src', '');
	})

	$('.play-video').on('click', function () {
		var video = $(this).attr('data-video');
		$('.modal').fadeIn();
		$('#video-frame').attr('src', video);
	})

	// $('.item-vantagens').on('click', function () {
	// 	$('.item-vantagens').removeClass('active');
	// 	$(this).addClass('active');

	// 	var item = $(this).attr('id');
	// 	$('.content-vantagens').hide();
	// 	$('#content-' + item).show();
	// })

	$('.up-text').on('click', function () {
		var tamanho = $(this).attr('data-text');
		tamanho = parseInt(tamanho);

		if (tamanho <= 4) {
			var up = tamanho + 1;
			var down = tamanho - 1;
			$('.up-text').attr('data-text', up);
			$('.down-text').attr('data-text', down);
			$('#text-post').removeClass();
			$('#text-post').addClass('text-' + tamanho);
		}
	})

	$('.down-text').on('click', function () {
		var tamanho = $(this).attr('data-text');
		tamanho = parseInt(tamanho);

		if (tamanho >= 0) {
			var up = tamanho + 1;
			var down = tamanho - 1;
			$('.up-text').attr('data-text', up);
			$('.down-text').attr('data-text', down);
			$('#text-post').removeClass();
			$('#text-post').addClass('text-' + tamanho);
		}
	})

	$('.lupa').on('click', function () {
		$('#busca-topo').toggle();
	})

	$('.fechar').on('click', function () {
		$('#busca-topo').fadeOut();
	})

	$('.j_perguntas').click(function(){
    $("html, body").animate({scrollTop: $('#sec-perguntas').position().top-100}, 1000);
  })

  $('.play-video').click(function(){
  	$('.modal-chegajunto').fadeIn();
    var id_video = $('#frame-chegajunto').attr('data-video');
    $('#frame-chegajunto').attr('src', 'https://www.youtube.com/embed/'+id_video+'?autoplay=1;rel=0&amp;showinfo=0');
  })

  $('.j_closevideo').click(function(){
  	$('.modal-chegajunto').fadeOut();
  	$('#frame-chegajunto').attr('src', '');
  })

	var accept = readCookie('location');
	if (!accept) {
		$('#location').show();
	}

	var accept2 = readCookie('tipo_acesso');
	if (!accept2) {
		$('#tipo_acesso').show();
	}

	var direcao = readCookie('fechar_direcao');
	if (!direcao) {
		$('#modal-direcao').show();
	}

	var SPMaskBehavior = function (val) {
	    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
	  },
	  spOptions = {
	    onKeyPress: function(val, e, field, options) {
	        field.mask(SPMaskBehavior.apply({}, arguments), options);
	      }
	  };

  	$('.telefone').mask(SPMaskBehavior, spOptions);
  	$('.whatsapp').mask(SPMaskBehavior, spOptions);
  	$('.validate_card').mask("99/9999");
  	$('.cep').mask("99999-999");
  	$('.ccv_card').mask("9999");
  	$('.number_card').mask("9999.9999.9999.9999");
  	$('.cpf').mask("999.999.999-99");
  	$('.cnpj').mask("99.999.999/9999-99");

  	$('#first-item').addClass('active');
});


function Fechar() {
	createCookie('fechar_direcao', '1', 1);
	$('#modal-direcao').fadeOut();
}
function Fechar2() {
	$('#tipo_acesso').fadeOut();
}


function checkTelefone(telefone){
    var result = telefone.indexOf("(55)") > -1;
    if(result == true)
      return false;
    if (telefone.length < 14)
    return false;
    console.log(telefone);
   //var regex = new RegExp('^\\(((1[1-9])|([2-9][0-9]))\\)((3[0-9]{3}-[0-9]{4})|(9[0-9]{3}-[0-9]{5}))$');
   if (telefone == "(12) 3456-7890" ||
   telefone == "(00) 0000-00000" ||
   telefone == "(00) 0000-0000" ||
   telefone == "(11) 1111-11111" ||
   telefone == "(11) 1111-1111" ||
   telefone == "(22) 2222-22222" ||
   telefone == "(22) 2222-2222" ||
   telefone == "(33) 3333-33333" ||
   telefone == "(33) 3333-3333" ||
   telefone == "(44) 4444-44444" ||
   telefone == "(44) 4444-4444" ||
   telefone == "(55) 5555-55555" ||
   telefone == "(55) 5555-5555" ||
   telefone == "(66) 6666-66666" ||
   telefone == "(66) 6666-6666" ||
   telefone == "(77) 7777-77777" ||
   telefone == "(77) 7777-7777" ||
   telefone == "(88) 8888-88888" ||
   telefone == "(88) 8888-8888" ||
   telefone == "(99) 9999-9999" ||
   telefone == "(99) 9999-99999")
    return false;
      return true;
  }

function showInfo(id){
	$('.border-'+id).show();
	$('.inner-'+id).addClass('rotate');
	$('.box-'+id).hide();
}

function backInfo(id){
	$('.border-'+id).hide();
	$('.inner-'+id).removeClass('rotate');
	$('.box-'+id).show();
}
function AlterTab(tab) {
	$('.nav-link').removeClass('active');
	$('#tab-'+tab).addClass('active');
	$('.tab-pane').removeClass('active');
	$('#'+tab).addClass('active');
}

function checkMail(mail){
    var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
    if(typeof(mail) == "string"){
      if(er.test(mail)){ return true; }
    }else if(typeof(mail) == "object"){
      if(er.test(mail.value)){ 
        return true; 
      }
    }else{
      return false;
    }
}

function EnviaEmail() {
    var n = $('#form-contato .required').length;
    var errors=0;

     $('#form-contato .required').each(function(i) {
      if ($(this).val() == '') {
        errors++;
        if (errors == 1) {
          $(this).focus();
        }
        $(this).addClass('error-form');
        $(this).removeClass('valide-form');
        $(this).next('.error').show();
      }else{
        $(this).removeClass('error-form');
        $(this).addClass('valide-form');
        $(this).next('.error').hide();
      }
     })

      if(checkMail($('#email').val())!=true){
          $('#email').addClass('error-form');
          $('#email').removeClass('valide-form');
          $('.error-email').show();          
          errors++;
      } else {
          $('#email').addClass('valide-form');
          $('#email').removeClass('error-form');
          $('.error-email').hide();          
      }      

    if (errors == 0) {
      var dados = $('#form-contato').serialize();
      
      $.ajax({
        type: 'POST',
        data: dados,
        url:'/wp-content/themes/GuiaServicos/contato.php',
        success: function(){
          $('#form-contato').hide();
          $('#sucesso').show();
        }
      });
    } 
}

function Cadastro() {
    var n = $('#form-cadastro .required').length;
    var errors=0;

     $('#form-cadastro .required').each(function(i) {
      if ($(this).val() == '') {
        errors++;
        if (errors == 1) {
          $(this).focus();
        }
        $(this).addClass('error-form');
        $(this).removeClass('valide-form');
        $(this).next('.error').show();
      }else{
        $(this).removeClass('error-form');
        $(this).addClass('valide-form');
        $(this).next('.error').hide();
      }
     })

      if(checkMail($('#email').val())!=true){
          $('#email').addClass('error-form');
          $('#email').removeClass('valide-form');
          $('.error-email').show();          
          errors++;
      } else {
          $('#email').addClass('valide-form');
          $('#email').removeClass('error-form');
          $('.error-email').hide();          
      }      

      var password = $('#password').val();
      var repassword = $('#repassword').val();

      if(password != repassword || password == ''){
          $('#password').addClass('error-form');
          $('#repassword').addClass('error-form');
          $('#password').removeClass('valide-form');
          $('#repassword').removeClass('valide-form');
          $('.error-senha').show();          
          errors++;
      } else {
          $('#password').removeClass('error-form');
          $('#repassword').removeClass('error-form');
          $('#password').addClass('valide-form');
          $('#repassword').addClass('valide-form');
          $('.error-senha').hide();          
      } 

    if (errors == 0) {
      var dados = $('#form-cadastro').serialize();
      
      $.ajax({
        type: 'POST',
        data: dados,
        url:'/wp-json/custom-api/v1/register/',
        success: function(){
          $('#form-cadastro').hide();
          $('#sucesso').show();
        },
        error: function(){
          $('.exists').show();
        },
      });
    } 
}

function Login() {
    var n = $('#form-cadastro .required').length;
    var errors=0;

     $('#form-cadastro .required').each(function(i) {
      if ($(this).val() == '') {
        errors++;
        if (errors == 1) {
          $(this).focus();
        }
        $(this).addClass('error-form');
        $(this).removeClass('valide-form');
        $(this).next('.error').show();
      }else{
        $(this).removeClass('error-form');
        $(this).addClass('valide-form');
        $(this).next('.error').hide();
      }
     })

    if (errors == 0) {
      var dados = $('#form-cadastro').serialize();
      
      $.ajax({
        type: 'POST',
        data: dados,
        url:'/wp-json/custom/v1/login',
        success: function(response){
        	sessionStorage.setItem('authToken', response.token);
        	window.location = '/meu-perfil/'
        },
        error: function(){
        	$('#form-error').show();
        }
      });
    } 
}

// Função de validação geral
function validateForm(formId) {
    var errors = 0;
    $(formId + ' .required').each(function() {
        if ($(this).val() === '') {
            $(this).addClass('error-form');
            $(this).removeClass('valide-form');
            $(this).next('.error').show();
            errors++;
        } else {
            $(this).removeClass('error-form');
            $(this).addClass('valide-form');
            $(this).next('.error').hide();
        }
    });
    return errors === 0;
}

// Atualiza Dados Pessoais
function updatePersonal() {
    if (validateForm('#form-personal')) {
        var dados = $('#form-personal').serialize();
        var token = sessionStorage.getItem('authToken');

        $.ajax({
            type: 'POST',
            url: '/wp-json/custom/v1/update-user/personal',
            data: dados,
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function() {
                $('#personal-sucess').show();
            },
            error: function() {
                $('#personal-error').show();
            }
        });
    }
}

// Atualiza Senha
function updatePassword() {
    var password = $('#password').val();
    var repassword = $('#repassword').val();

    if (password !== repassword || password === '') {
        $('.error-senha').show();
        $('#password, #repassword').addClass('error-form');
        return;
    } else {
        $('.error-senha').hide();
        $('#password, #repassword').removeClass('error-form');
    }

    if (validateForm('#form-password')) {
        var dados = $('#form-password').serialize();
        var token = sessionStorage.getItem('authToken');
        $.ajax({
            type: 'POST',
            url: '/wp-json/custom/v1/update-user/password',
            data: dados,
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function() {
                $('#password-sucess').show();
            },
            error: function() {
                $('#password-error').show();
            }
        });
    }
}

// Atualiza Dados de Pagamento
function updatePayment() {
    if (validateForm('#form-payment')) {
        var dados = $('#form-payment').serialize();
        var token = sessionStorage.getItem('authToken');
        $.ajax({
            type: 'POST',
            url: '/wp-json/custom/v1/update-user/payment',
            data: dados,
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function() {
                $('#payment-sucess').show();
            },
            error: function() {
                $('#payment-error').show();
            }
        });
    }
}

function loadPaymentData() {
    const token = sessionStorage.getItem('authToken');

    $.ajax({
        type: 'GET',
        url: '/wp-json/custom/v1/payment/get',
        headers: {
            'Authorization': 'Bearer ' + token
        },
        success: function(response) {
            $('#name_card').val(response.name_card);
            $('#number_card').val(response.number_card);
            $('#validate_card').val(response.validate_card);
            $('#ccv_card').val(response.ccv_card);
        },
        error: function(xhr) {
            if (xhr.status == 401) {
                sessionStorage.removeItem('authToken');
                window.location = '/';
            } else {
                alert('Erro ao carregar os dados de pagamento.');
            }
        }
    });
}

$(document).ready(function() {
    const token = sessionStorage.getItem('authToken');

    // Função para carregar os dados do comércio
    var url = window.location.pathname;

    if(url == '/meu-perfil/'){
    	tinymce.init({
			    selector: 'textarea',
			    menubar: false,
			    plugins: 'lists link image preview',
			    toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image | preview',
			    branding: false,
			    language: 'pt_BR'
			});

	    function loadComercioData() {
			    const token = sessionStorage.getItem('authToken');

			    $.ajax({
			        type: 'GET',
			        url: '/wp-json/custom/v1/comercio/get',
			        headers: {
			            'Authorization': 'Bearer ' + token
			        },
			        success: function(response) {
			            const comercio = response.comercio_data;

			            // Verifica se existe um comércio associado
			            if (comercio) {
			                populateForm(comercio); // Popula o formulário com os dados do comércio
			            }

			            // Carregar as categorias e tags disponíveis, independentemente de existir um comércio ou não
			            loadTaxonomies(comercio ? comercio.categoria_ids : [], comercio ? comercio.tag_ids : []);
			        },
			        error: function(xhr) {
			            if (xhr.status == 401) {
			                sessionStorage.removeItem('authToken');
                            window.location = '/';
			            } else {
			                // Se não há comércio associado, ainda carregamos as taxonomias (categorias e tags)
			                loadTaxonomies([], []);
			            }
			        }
			    });
			}
	  }

		$('#cep').on('blur', function() {
        var cep = $(this).val().replace(/\D/g, ''); // Remove qualquer caractere que não seja número

        if (cep.length === 8) { // Verifica se o CEP tem 8 dígitos
            // Consulta o ViaCEP para obter o endereço
            $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(dados) {
                if (!dados.erro) {
                    // Atualiza o campo de endereço com os dados retornados
                    var endereco = `${dados.logradouro}, ${dados.bairro}, ${dados.localidade} - ${dados.uf}`;

                    // Verifica se o TinyMCE está ativo e atualiza o conteúdo
                    if (tinymce.get('endereco_completo')) {
                        tinymce.get('endereco_completo').setContent(endereco);
                    } else {
                        $('#endereco_completo').val(endereco); // Caso o TinyMCE não esteja inicializado
                    }
                } else {
                    alert('CEP não encontrado.');
                    tinymce.get('endereco_completo').setContent('');
                }
            }).fail(function() {
                alert('Erro ao consultar o CEP.');
                tinymce.get('endereco_completo').setContent('');
            });
        } else {
            alert('Por favor, insira um CEP válido.');
        }
    });

		// Função para preencher o formulário com os dados do comércio
		function populateForm(comercio) {
		    console.log(comercio);
		    $('#nome').val(comercio.nome);
		    $('#descricao').val(comercio.descricao);
		    $('#caracteristicas').val(comercio.caracteristicas);

		    // Pré-visualizar imagens
		    if (comercio.banner_destaque_url) {
		        $('#banner_destaque_preview').attr('src', comercio.banner_destaque_url);
		    }
		    if (comercio.logo_url) {
		        $('#logo_preview').attr('src', comercio.logo_url);
		    }
		    if (comercio.imagem_lista_url) {
		        $('#imagem_lista_preview').attr('src', comercio.imagem_lista_url);
		    }

		    // Contatos
		    $('#cep').val(comercio.cep);
		    $('#endereco_completo').val(comercio.endereco_completo);
		    $('#telefone').val(comercio.telefone);
		    $('#whatsapp').val(comercio.whatsapp);
		    $('#email').val(comercio.email);
		    $('#link_facebook').val(comercio.link_facebook);
		    $('#link_instagram').val(comercio.link_instagram);
		    $('#site').val(comercio.site);
		    $('#link_comercio').attr('href', comercio.permalink);

		    // Horários
		    if (comercio.horarios && comercio.horarios.length > 0) {
		        comercio.horarios.forEach(function(horario) {
		            addHorarioField(horario.dia, horario.horario);
		        });
		    }

		    // Taxonomia (Categorias e Tags)
		    loadTaxonomies(comercio.categoria_ids, comercio.tag_ids);

		    // Status
		    $('input[name="status"][value="' + comercio.status + '"]').prop('checked', true);

		    // Galeria de Imagens
		    if (comercio.galeria && comercio.galeria.length > 0) {
		        comercio.galeria.forEach(function(foto_url) {
		            addGalleryImage(foto_url);
		        });
		    }
		}

		// Função para adicionar campos de horário
		function addHorarioField(dia = '', horario = '') {
		    const horarioHtml = `
		        <div class="horario-item">
		            <input type="text" name="horarios_dia[]" class="form-control" placeholder="Dia da semana" value="${dia}">
		            <input type="text" name="horarios_horario[]" class="form-control" placeholder="Horário" value="${horario}">
		            <button type="button" class="btn btn-danger remove-horario-btn">Remover</button>
		        </div>
		    `;
		    $('#horarios-container').append(horarioHtml);
		}

		// Função para adicionar uma imagem da galeria dinamicamente
		function addGalleryImage(foto_url = '') {
		    const galleryHtml = `
		        <div class="gallery-item">
		            <input type="file" name="galeria_fotos[]" class="form-control gallery-input">
		            <button type="button" class="btn btn-danger remove-gallery-btn">Remover</button>
		            ${foto_url ? `<img src="${foto_url}" alt="Imagem da Galeria" class="gallery-preview" style="max-width: 150px;"/>` : ''}
		        </div>
		    `;
		    $('#galeria-container').append(galleryHtml);
		}

		// Evento para adicionar nova imagem da galeria
		$('#add-galeria-btn').click(function() {
		    addGalleryImage();
		});

		// Evento para remover uma imagem da galeria
		$('#galeria-container').on('click', '.remove-gallery-btn', function() {
		    $(this).closest('.gallery-item').remove();
		});

		// Evento para adicionar novo horário
		$('#add-horario-btn').click(function() {
		    addHorarioField();
		});

		// Evento para remover um horário
		$('#horarios-container').on('click', '.remove-horario-btn', function() {
		    $(this).closest('.horario-item').remove();
		});

		function loadTaxonomies(selectedCategorias = [], selectedTags = []) {
		    // Carregar categorias
		    $.ajax({
		        type: 'GET',
		        url: '/wp-json/wp/v2/categorias_comercio?per_page=100', // Ajuste o endpoint conforme sua estrutura
		        success: function(categorias) {
		            let categoriaSelect = $('select[name="categoria[]"]');
		            categoriaSelect.empty(); // Limpa o select de categorias

		            categorias.forEach(function(categoria) {
		                let selected = selectedCategorias.includes(categoria.id) ? 'selected' : '';
		                categoriaSelect.append(`<option value="${categoria.id}" ${selected}>${categoria.name}</option>`);
		            });
		        },
		        error: function() {
		            alert('Erro ao carregar categorias.');
		        }
		    });

		    // Carregar tags
		    $.ajax({
		        type: 'GET',
		        url: '/wp-json/wp/v2/tags?per_page=100', // Ajuste o endpoint conforme sua estrutura
		        success: function(tags) {
		            let tagsSelect = $('select[name="tags[]"]');
		            tagsSelect.empty(); // Limpa o select de tags

		            tags.forEach(function(tag) {
		                let selected = selectedTags.includes(tag.id) ? 'selected' : '';
		                tagsSelect.append(`<option value="${tag.id}" ${selected}>${tag.name}</option>`);
		            });
		        },
		        error: function() {
		            alert('Erro ao carregar tags.');
		        }
		    });
		}


    // Evento de submissão do formulário
    $('#form-comercio').submit(function(event) {
        event.preventDefault();
        tinymce.triggerSave();
        updateComercio();
    });

    // Função para atualizar o comércio
    function updateComercio() {
        const token = sessionStorage.getItem('authToken');

        var formData = new FormData($('#form-comercio')[0]);

        // Adicionar horários ao FormData
        $('input[name="horarios_dia[]"]').each(function(index) {
            formData.append('horarios[' + index + '][dia]', $(this).val());
        });

        $('input[name="horarios_horario[]"]').each(function(index) {
            formData.append('horarios[' + index + '][horario]', $(this).val());
        });

		    // Adicionar categorias ao FormData (IDs das categorias)
		    $('select[name="categoria[]"]').each(function() {
		        formData.append('categoria[]', $(this).val());
		    });

		    // Adicionar tags ao FormData (IDs das tags)
		    $('select[name="tags[]"]').each(function() {
		        formData.append('tags[]', $(this).val());
		    });        

        $.ajax({
            type: 'POST',
            url: '/wp-json/custom/v1/comercio/update',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#business-sucess').show();
                setTimeout(function() {
				    window.location.reload();
				}, 5000);
            },
            error: function(xhr) {
                if (xhr.status == 401) {
                    $('#business-error').show();
                } else {
                    $('#business-error').show();
                }
            }
        });
    }

    loadComercioData();
    loadPaymentData();
});

$('#forgot-password-link').click(function() {
    $('#form-resend').slideToggle();
});

$('#send-password-reset').click(function() {
    event.preventDefault();
    var email = $('#recover-email').val();

    if (!email) {
        $('#message').text('Por favor, insira um e-mail válido.');
        return;
    }

    $.ajax({
        url: '/wp-json/custom/v1/forgot-password',
        method: 'POST',
        data: { email: email },
        success: function(response) {
            $('#message').text('E-mail com nova senha enviado!');
        },
        error: function(xhr) {
            if (xhr.status == 404) {
                $('#message').text('E-mail não encontrado.');
            } else {
                $('#message').text('Erro ao enviar o e-mail.');
            }
        }
    });
});