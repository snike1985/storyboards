const burger = document.querySelector(".c-hamburger");
const wrap = document.querySelector('.wrapper');

burger.addEventListener('click', () => {
  burger.classList.toggle('active');
   wrap.classList.toggle('fixed')
})

//
// (function() {
//
//   "use strict";
//
//   var toggles = document.querySelectorAll(".option-element");
//
//   for (var i = toggles.length - 1; i >= 0; i--) {
//     var toggle = toggles[i];
//     toggleHandler(toggle);
//   };
//
//   function toggleHandler(toggle) {
//     toggle.addEventListener( "click", function(e) {
//       e.preventDefault();
//       (this.classList.contains("is-active") === true) ? this.classList.remove("is-active") : this.classList.add("is-active");
//     });
//   }
//
// })();
