"use strict";

/**
 *	Custom jQuery Scripts
 *	Date Modified: 04.12.2022
 *	Developed by: Lisa DeBona
 */
jQuery(document).ready(function ($) {
  // const swiper = new Swiper('.slideshow .swiper', {
  //   // Optional parameters
  //   direction: 'vertical',
  //   loop: true,
  //   // If we need pagination
  //   pagination: {
  //     el: '.swiper-pagination',
  //   },
  //   // Navigation arrows
  //   navigation: {
  //     nextEl: '.swiper-button-next',
  //     prevEl: '.swiper-button-prev',
  //   },
  //   // And if we need scrollbar
  //   scrollbar: {
  //     el: '.swiper-scrollbar',
  //   },
  // });
  $('#menutoggle').on('click', function (e) {
    e.preventDefault();
    $(this).toggleClass('active');
    $('#site-navigation').toggleClass('active');
    $('body').toggleClass('mobile-menu-open');
  });
  $('li.menu-item-has-children a i').on('click', function (e) {
    e.preventDefault();
    $(this).parents('li').toggleClass('open-dropdown');
  });
  var swiper = new Swiper('.slideshow .swiper', {
    autoplay: {
      delay: 10000
    },
    speed: 500,
    loop: true,
    preventClicks: false,
    fadeEffect: {
      crossFade: true
    },
    effect: "fade",

    /*  "slide", "fade", "cube", "coverflow" or "flip" */
    pagination: {
      el: '.swiper-pagination',
      clickable: true
    },
    preventClicksPropagation: false,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev'
    }
  });

  if ($('a.popup').length) {
    $('a.popup').each(function () {
      var target = $(this);
      var link = $(this).attr('href');

      if (link.includes('youtu')) {
        target.addClass('video-link');
      }
    });
  }

  Fancybox.bind(".popup", {
    Image: {
      Panzoom: {
        zoomFriction: 0.7,
        maxScale: function maxScale() {
          return 5;
        }
      }
    },
    Html: {
      video: {
        autoplay: true
      }
    }
  });
  var owl = $('.owl-carousel');
  owl.owlCarousel({
    loop: true,
    margin: 0,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
        nav: false
      },
      600: {
        items: 4,
        nav: false
      },
      1000: {
        items: 6,
        nav: false,
        loop: false
      }
    },
    onInitialized: function onInitialized() {
      $('.owl-item.active').each(function () {
        if ($(this).find('img').length == 0) {
          $(this).remove();
        }
      });
    }
  });
  var wow = new WOW();
  wow.init();

  WOW.prototype.addBox = function (element) {
    this.boxes.push(element);
  };
  /* CIRCULAR ELEMENTS */
  // Inspired by https://codepen.io/davatron5000/pen/jzMmME
  // Get all the Meters


  var meters = document.querySelectorAll('svg[data-value] .meter');
  meters.forEach(function (path) {
    // Get the length of the path
    var length = path.getTotalLength(); // Just need to set this once manually on the .meter element and then can be commented out
    // path.style.strokeDashoffset = length;
    // path.style.strokeDasharray = length;
    // Get the value of the meter

    var value = parseInt(path.parentNode.getAttribute('data-value')); // Calculate the percentage of the total length

    var to = length * ((100 - value) / 100); // Trigger Layout in Safari hack https://jakearchibald.com/2013/animated-line-drawing-svg/

    path.getBoundingClientRect(); // Set the Offset

    path.style.strokeDashoffset = Math.max(0, to); //path.nextElementSibling.textContent = `${value}%`;
  });
  /* Homepage */

  if ($('.homerow4 .column-right img').length) {
    var home4_img = $('.homerow4 .column-right img').attr('src');
    $('.homerow4 .column-right').css('background-image', 'url(' + home4_img + ')');
  }
});