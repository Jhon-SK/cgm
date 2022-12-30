// $( ".btn-more" ).click(function() {
//     $(".text-2").toggleClass("more-text");
//     if($(".btn-more").text() === "Leer más") {
//         $(".btn-more").text() = "Leer menos";
//     } else {
//         $(".btn-more").text() = "Leer más";
//     }
//   });


$(document).ready(function(){
    $(".btn-more").click(function(){
       $(this).parent().prev().find('.more').fadeToggle();
       $(this).parent().prev().find('.dots').toggle();
       if($(this).text()=='Leer más'){
     $(this).text('leer menos');
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
 });