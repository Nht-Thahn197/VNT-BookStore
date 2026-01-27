


setTimeout(function(){
    location.reload();
}, 60* 1000);

//Get the button
var mybutton = document.getElementById("myBtn-scroll");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

document.addEventListener("DOMContentLoaded", function () {
  var menuWrap = document.querySelector(".header__nav-menu-wrap");
  if (!menuWrap) return;

  function setOpenState(isOpen) {
    menuWrap.classList.toggle("is-open", isOpen);
    menuWrap.setAttribute("aria-expanded", isOpen ? "true" : "false");
  }

  menuWrap.addEventListener("click", function (event) {
    if (event.target.closest(".header__nav-dropdown-item")) {
      setOpenState(false);
      return;
    }
    setOpenState(!menuWrap.classList.contains("is-open"));
  });

  menuWrap.addEventListener("keydown", function (event) {
    if (event.key === "Enter" || event.key === " ") {
      event.preventDefault();
      setOpenState(!menuWrap.classList.contains("is-open"));
    }
    if (event.key === "Escape") {
      setOpenState(false);
    }
  });

  document.addEventListener("click", function (event) {
    if (!menuWrap.contains(event.target)) {
      setOpenState(false);
    }
  });
});
