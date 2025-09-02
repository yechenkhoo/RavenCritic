document.addEventListener("DOMContentLoaded", function ()
{
// Code to be executed when the DOM is ready (i.e. the document is
// fully loaded):

  registerEvents();
  scrollAnimation();
  scoreCol();
  scrollSetup();
  returnToTop();
  gameOnClick();
  changeImage();
  animateCounters();

});


//animation for live counter at about us 
function animateCounters() {

  $('.counter').each(function() {
    // counter animation code 
      $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 3000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
  });

}



function registerEvents() {
  const testBtn = document.getElementsByClassName("btn");

  for (i = 0; i < testBtn.length; i++) {
    testBtn[i].addEventListener("click", changeImage);
  }
}





function scoreCol() {
  $('.number').each(function() {
    // Get the text content of text under number class.
    var score = parseFloat($(this).text(), 10);
    
    // Purple: high rating 
    if (score >= 8.5) {
      // ratingColor = "#00ce7a";
      ratingColor = "rgb(125,108,209)";
      $(this).closest('.col-auto').css('background-color', ratingColor);
    }

    // Blue: mid rating
    else if (score >= 4.5 && score < 8.5) {
      ratingColor = "rgb(90, 147, 203)";
      $(this).closest('.col-auto').css('background-color', ratingColor);
    }

    // Red: low rating
    else if (score >= 0 && score < 4.5){
      ratingColor = "rgb(236, 68, 68)";
      $(this).closest('.col-auto').css('background-color', ratingColor);
    }

    // NULL rating: tbd
    else {
      ratingColor = "grey";
      $(this).closest('.col-auto').css('background-color', ratingColor);
    }


    var col = $(this).closest('.col');
    var card = col.find('.card');
    card.css('background', 'linear-gradient(to bottom, ' + ratingColor + ' 30%, rgb(233, 233, 240) 30%)');
    
  });
}


// Sliders
function loadSliders() {
  $(window).on('load', function() {
    $('.header-slide').not('.slick-initialized').slick({
      dots: true,
      infinite: true,
      speed: 500,
      fade: true,
      cssEase: 'linear',
      autoplay: true,
      autoplaySpeed: 2000,
      arrows: true,
      prevArrow: $('.prev'),
      nextArrow: $('.next'),
    });

    $('.slider, .slider-bestof, .upcoming').not('.slick-initialized').slick({
      // variableWidth: true,
      dots: true,
      infinite: false,
      speed: 300,
      slidesToShow: 5,
      slidesToScroll: 5,
      arrows: true,
      responsive: [
        {
          breakpoint: 1340,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 4,
          }
        },
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
          }
        },
      ]
    });
  });
}
loadSliders();

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


function changeImage(e) {
  const bestOfImages = document.querySelectorAll(['.best-of-img']);
  const bestOfName = document.querySelectorAll(['.filter-name']);
  const bestOfScore = document.querySelectorAll(['.filter-score']);

  if (e && e.target) {
    // XBox radio button is clicked.
    if (e.target.id == "xbox") {
      let index = 0;
      fetch('get_xbox.php')
      .then(response => response.json())
      .then(data => {
        data.forEach((game, index) => {
          if (bestOfImages[index] && bestOfName[index] && bestOfScore[index]) {
            bestOfImages[index].src = game.ImagePath;
            bestOfImages[index].alt = game.Name;
            bestOfImages[index].title = game.Name;

            bestOfName[index].textContent = game.Name;
            bestOfScore[index].textContent = game.Score;
            scoreCol();
          }
        });
      })
      .catch(error => console.error('Error fetching Xbox games:', error));
    }

    // Switch radio button is clicked.
    if (e.target.id == "switch") {
      let index = 0;
      fetch('get_switch.php')
      .then(response => response.json())
      .then(data => {
        data.forEach((game, index) => {
          if (bestOfImages[index] && bestOfName[index] && bestOfScore[index]) {
            bestOfImages[index].src = game.ImagePath;
            bestOfImages[index].alt = game.Name;
            bestOfImages[index].title = game.Name;

            bestOfName[index].textContent = game.Name;
            bestOfScore[index].textContent = game.Score;
            scoreCol();
          }
        });
      })
      .catch(error => console.error('Error fetching Switch games:', error));
    }

    // PlayStation radio button is clicked.
    if (e.target.id == "ps") {
      let index = 0;
      fetch('get_ps.php')
      .then(response => response.json())
      .then(data => {
        data.forEach((game, index) => {
          if (bestOfImages[index] && bestOfName[index] && bestOfScore[index]) {
            bestOfImages[index].src = game.ImagePath;
            bestOfImages[index].alt = game.Name;
            bestOfImages[index].title = game.Name;

            bestOfName[index].textContent = game.Name;
            bestOfScore[index].textContent = game.Score;
            scoreCol();
          }
        });
      })
      .catch(error => console.error('Error fetching PlayStation games:', error));
    }

    // PC radio button is clicked.
    if (e.target.id == "pc") {
      let index = 0;
      fetch('get_pc.php')
      .then(response => response.json())
      .then(data => {
        data.forEach((game, index) => {
          if (bestOfImages[index] && bestOfName[index] && bestOfScore[index]) {
            bestOfImages[index].src = game.ImagePath;
            bestOfImages[index].alt = game.Name;
            bestOfImages[index].title = game.Name;

            bestOfName[index].textContent = game.Name;
            bestOfScore[index].textContent = game.Score;
            scoreCol();
          }
        });
      })
      .catch(error => console.error('Error fetching PC games:', error));
    }
  }
}

// Function so that clicking on Best Games navbar link on a different page works.
// Kind of works like a scrollspy but with the url.
navbarLinksLoad();

function navbarLinksLoad() {
  document.addEventListener("DOMContentLoaded", function() {

    // Wait for the content to appear
    var targetElement = document.getElementById("bestgames");
    var observer = new IntersectionObserver(function(entries) {
      if (entries[0].isIntersecting) {

        // Content is visible, scroll to the anchor link
        window.location.href = "#bestgames";
      }
      else {
        // Content is not visible, remove the anchor link
        if (window.location.href.includes("#bestgames")) {
          history.replaceState({}, document.title, window.location.pathname + window.location.search);
        }
      }
    });
    observer.observe(targetElement);
  });
}