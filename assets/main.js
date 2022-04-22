const hamburger=document.getElementById('hamburger');
const navwrap=document.getElementById('ul-and-btn-wrapper');
hamburger.addEventListener('click',()=>{
  console.log("hello");
  navwrap.classList.toggle('show');
});

 


$('.header-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    infinite: true,
    autoplay: true, 
    // arrows: true,
    prevArrow:"<button type='button' class='slick-prev pull-left '><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
    nextArrow:"<button type='button' class='slick-next pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>"
        
  });
 
  
$('.header-slider2').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    infinite: true,
    autoplay: true, 
    // arrows: true,
    prevArrow:"<button type='button' class='slick-prev pull-left-phn'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
            nextArrow:"<button type='button' class='slick-next pull-right-phn'><i class='fa fa-angle-right' aria-hidden='true'></i></button>"
});
  


var modal = document.getElementById("myModal");


var btn = document.getElementsByClassName("myBtn");


var span = document.getElementsByClassName("close")[0];

function adListner(i) {
  btn[i].onclick = function() {
    modal.style.display = "block";
  }
}
for (var i = 0; i < btn.length; i++) {
  adListner(i);
}
span.onclick = function() {
  modal.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

