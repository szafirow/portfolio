//Powiekszanie menu w zależności od scrolla
$(window).scroll(function() {
    if ($(".navbar").offset().top > 50) {
        $(".navbar-fixed-top").addClass("top-nav-collapse");
    } else {
        $(".navbar-fixed-top").removeClass("top-nav-collapse");
    }
});

// Highlight nav when scroll
 

//Smooth scroll 
$(".page-scroll a").on('click', function(event) {
            if (this.hash !== "") {
              event.preventDefault();
              var hash = this.hash;
              $('html, body').animate({
                scrollTop: $(hash).offset().top-130
              }, 800, function(){
           
                window.location.hash = hash;
              });
            } 
          });
	 
 

//Back to top
  $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
  


//Animated number counter
$('.count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 4000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});


//Form MD

$('.input').on("focus blur", function() {
  if ($(this).val().length > 0 || $('.input').is(':focus')) {
    $(this).siblings().addClass('active');
    $(this).parent().addClass('active');

  } else {
    $(this).siblings().removeClass('active').addClass('not');
    $(this).parent().removeClass('active').addClass('not');
  }

  if ($(this).val().length < 2 && $('.input').is(':focus') != true && $(this).is(':invalid') || $(this).is(':invalid') && $('.input').is(':focus') != true) {
    $(this).parent().addClass('invalid');
    $(this).siblings().addClass('invalid');
  } else {
    $(this).parent().removeClass('invalid');
    $(this).siblings().removeClass('invalid');
  }

  if ($(this).val().length > 0 && $(this).is(':valid') && $('.input').is(':focus') != true) {
    $(this).parent().addClass('valid');
    $(this).siblings().addClass('valid');
  } else {
    $(this).parent().removeClass('valid');
    $(this).siblings().removeClass('valid');
  }

});

$('#d').change(enableBtn);
$('.input').blur(enableBtn);

function enableBtn() {
  if ($('#d').is(':checked') == false || $('.input').parent('.input-wrap').hasClass('invalid') == true || $('.input').val().length < 2) {
    $("#confirm").prop("disabled", true);
  } else {
    $("#confirm").prop("disabled", false);
  }
}
enableBtn();

$('#confirm').click(function() {
  $('form').submit(function(event) {
    $('.card').addClass('end');
    $('.ending').addClass('showed');
    event.preventDefault();
  });
});

