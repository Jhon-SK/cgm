// $( ".btn-more" ).click(function() {
//     $(".text-2").toggleClass("more-text");
//     if($(".btn-more").text() === "Leer más") {
//         $(".btn-more").text() = "Leer menos";
//     } else {
//         $(".btn-more").text() = "Leer más";
//     }
//   });


$(document).ready(function(){
    $(".btn-more").click(function(e){
       $(this).parent().prev().find('.more').fadeToggle();
       $(this).parent().prev().find('.dots').toggle();
       $(this).toggleClass('active')
       if($(this).hasClass('active')){
        $(this).text('Leer menos');
       }
       else{
        $(this).text('Leer más');
       }
    });

    $('.project-slick').slick({
      slidesToShow: 3,
      dots:true,
      arrows: true,
      infinite: false,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
      });
      
      $('.btn-submit').on('click',function(){

      })
      $('#numero_documento').maxlength({max: 8, showFeedback: false});
      $('#nombre').maxlength({max: 50, showFeedback: false});
      $('#telefono').maxlength({max: 9, showFeedback: false});
      $('#lugar').maxlength({max: 50, showFeedback: false});
      $('#requerimientos').maxlength({max: 200, showFeedback: false});
      
      $("#tipo_documento").change(function(){
          $("#divInputTipDoc").html("");
          $("#divInputTipDoc").html('<input type="number" class="form-control" placeholder="DNI O RUC" style="background-color: #F4F7FB; color:#373737; font-weight: bold;" id="numero_documento" name="numero_documento" required>' +
                                      '<label for="floatingInput" style="color: #B2B1B9; font-weight: bold;" required>DNI O RUC</label>');
          if( $(this).val() == "DNI" )
          {
              $('#numero_documento').maxlength({max: 8, showFeedback: false});
          }
          else 
          {
              $('#numero_documento').maxlength({max: 11, showFeedback: false});
          }
      });
      
      $('#nombre').keypress(function(){
          lettersOnly();
      });
      
      function lettersOnly(e) 
      {
          var charCode = e.keyCode;
          if ((charCode > 64 && charCode < 91) || charCode == 32 || (charCode > 96 && charCode < 123) || charCode == 8)
              return true;
          else
              return false;
      
      }
 });

