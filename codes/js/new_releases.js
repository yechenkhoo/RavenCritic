document.addEventListener("DOMContentLoaded", function ()
{
// Code to be executed when the DOM is ready (i.e. the document is
// fully loaded):

 scrollAnimation();
 scrollSetup();
 returnToTop();
 gameOnClick();

});



function scrollAnimation() {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("show");
      }
    });
  });


  const hiddenElements = document.querySelectorAll(".hidden-side, .hidden, .hidden-top");
  hiddenElements.forEach((el) => observer.observe(el));
}


function scrollSetup() {
  // Get button
  let mybutton = document.getElementById("return-to-top");

  // When user scrolls down 20px from the top, show the button
  window.onscroll = function() {scrollFunction()};

  function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      mybutton.style.display = "block";
    } else {
      mybutton.style.display = "none";
    }
  }
}


function returnToTop() {
  document.body.scrollTop = 0; 
  document.documentElement.scrollTop = 0;
}

function gameOnClick() {
  document.querySelectorAll('.clickable').forEach(item => {
    item.addEventListener('click', event => {
        var imageId = event.target.getAttribute('id');
        
        // Make a GET request to the backend PHP script, passing the image ID as a query parameter
        window.location.href = 'itempage.php?id=' + imageId;
    });
  });
}



