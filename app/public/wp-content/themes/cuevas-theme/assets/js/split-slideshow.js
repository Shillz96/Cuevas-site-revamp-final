/**
 * Split Slideshow for Cuevas Western Wear Theme
 * 
 * Implements a split screen vertical slideshow with synchronized text transitions.
 */

jQuery(document).ready(function($) {
  // Only initialize if the slideshow container exists
  if ($('.split-slideshow').length === 0) return;
  
  var $slider = $('.slideshow .slider'),
      maxItems = $('.item', $slider).length,
      dragging = false,
      tracking,
      rightTracking;
  
  // Flag to prevent scroll interference
  var isSlideAnimating = false;
  var slideAnimationTimeout;
  
  // Function to set animation state with auto-reset
  function setSlideAnimating(duration) {
    isSlideAnimating = true;
    clearTimeout(slideAnimationTimeout);
    slideAnimationTimeout = setTimeout(function() {
      isSlideAnimating = false;
    }, duration || 1000); // Match this with slide transition speed
  }

  // Create right slideshow
  var $sliderRight = $('.slideshow').clone().addClass('slideshow-right').appendTo($('.split-slideshow'));
  
  // Reverse items for right slideshow
  var rightItems = $('.item', $sliderRight).toArray();
  var reverseItems = rightItems.reverse();
  $('.slider', $sliderRight).html('');
  for (var i = 0; i < maxItems; i++) {
    $(reverseItems[i]).appendTo($('.slider', $sliderRight));
  }

  // Add slide indicator
  var $slideIndicator = $('<div class="slide-indicator"></div>').appendTo($('.split-slideshow'));
  function updateSlideIndicator(current) {
    $slideIndicator.text((current + 1) + ' / ' + maxItems);
  }
  
  // Add scroll cue that disappears after first scroll
  var $scrollCue = $('<div class="scroll-cue">Scroll</div>').appendTo($('.split-slideshow'));
  setTimeout(function() {
    // Hide scroll cue after 5 seconds
    $scrollCue.fadeOut(1000);
  }, 5000);

  // Initialize left slideshow
  $slider.addClass('slideshow-left');
  $('.slideshow-left').slick({
    vertical: true,
    verticalSwiping: true,
    arrows: false,
    infinite: false,
    dots: true,
    speed: 1000,
    cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)'
  }).on('beforeChange', function(event, slick, currentSlide, nextSlide) {
    // Set animating flag with longer duration to prevent quick successive slides
    setSlideAnimating(1200);
    
    // Handle navigation between slides
    $('.slideshow-right .slider').slick('slickGoTo', maxItems - 1 - nextSlide);
    $('.slideshow-text').slick('slickGoTo', nextSlide);
    
    // Update slide indicator and hide scroll cue on slide change
    updateSlideIndicator(nextSlide);
    $scrollCue.fadeOut(400);
  }).on("wheel", function(event) {
    // If body has the animated scrolling class, don't handle wheel events
    if (document.body.classList.contains('is-animated-scrolling')) {
      event.preventDefault();
      return;
    }
    
    // Only handle wheel events if we're not currently animating
    if (isSlideAnimating) {
      event.preventDefault();
      return;
    }
    
    // Determine scroll direction
    var delta = event.originalEvent.deltaY;
    
    // Get current slide and total slides
    var currentSlide = $('.slideshow-left').slick('slickCurrentSlide');
    var isLastSlide = currentSlide === maxItems - 1;
    var isFirstSlide = currentSlide === 0;
    
    // Handle mousewheel navigation with improved direction detection
    event.preventDefault();
    
    if (delta < 0) {
      // Scrolling up
      if (!isFirstSlide) {
        $(this).slick('slickPrev');
      } else {
        // If at first slide and scrolling up, go to previous section
        var prevSection = $('.split-slideshow').prev('.homepage-section');
        $('.split-slideshow').addClass('transitioning');
        
        if (prevSection.length && typeof window.moveToPrevSection === 'function') {
          // Mark as transitioning
          window.moveToPrevSection();
          // Remove transitioning class after animation completes
          setTimeout(function() {
            $('.split-slideshow').removeClass('transitioning');
          }, 1500);
        }
      }
    } else if (delta > 0) {
      // Scrolling down
      if (isLastSlide) {
        // If at the last slide and scrolling down, move to next section
        var nextSection = $('.split-slideshow').next('.homepage-section');
        $('.split-slideshow').addClass('transitioning');
        
        if (nextSection.length && typeof window.moveToNextSection === 'function') {
          // Call the transition function
          window.moveToNextSection();
          // Remove transitioning class after animation completes
          setTimeout(function() {
            $('.split-slideshow').removeClass('transitioning');
          }, 1500);
        }
      } else {
        // Not the last slide, proceed as normal
        $(this).slick('slickNext');
      }
    }
    
    // Hide scroll cue on first scroll
    $scrollCue.fadeOut(400);
  }).on('mousedown touchstart', function() {
    // Track dragging start
    dragging = true;
    tracking = $('.slick-track', $slider).css('transform');
    tracking = parseInt(tracking.split(',')[5]);
    rightTracking = $('.slideshow-right .slick-track').css('transform');
    rightTracking = parseInt(rightTracking.split(',')[5]);
    
    // Hide scroll cue on interaction
    $scrollCue.fadeOut(400);
  }).on('mousemove touchmove', function() {
    // Handle drag movement
    if (dragging) {
      var newTracking = $('.slideshow-left .slick-track').css('transform');
      newTracking = parseInt(newTracking.split(',')[5]);
      var diffTracking = newTracking - tracking;
      $('.slideshow-right .slick-track').css({'transform': 'matrix(1, 0, 0, 1, 0, ' + (rightTracking - diffTracking) + ')'});
    }
  }).on('mouseleave touchend mouseup', function() {
    // End dragging
    dragging = false;
  }).on('init reInit afterChange', function(event, slick, currentSlide) {
    // Update slide indicator on initialization and after changes
    var i = (currentSlide ? currentSlide : 0);
    updateSlideIndicator(i);
  });

  // Initialize right slideshow
  $('.slideshow-right .slider').slick({
    swipe: false,
    vertical: true,
    arrows: false,
    infinite: false,
    speed: 950,
    cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)',
    initialSlide: maxItems - 1
  });
  
  // Initialize text slideshow
  $('.slideshow-text').slick({
    swipe: false,
    vertical: true,
    arrows: false,
    infinite: false,
    speed: 900,
    cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)'
  });
  
  // Completely stop propagation of wheel events inside the gallery
  $('.split-slideshow').on('wheel touchmove', function(event) {
    // This prevents the browser's default scroll behavior inside the gallery
    // which would otherwise interfere with snap scrolling
    event.stopPropagation();
    
    // Do not prevent default here - let the slider's wheel handler decide
    // if it should prevent default based on animation state
  });
  
  // Add navigation buttons with improved visibility and positioning
  var $navContainer = $('<div class="slideshow-nav"></div>').appendTo($('.split-slideshow'));
  $('<button class="prev-slide" aria-label="Previous slide"><i class="fas fa-chevron-left"></i></button>').appendTo($navContainer).on('click', function(e) {
    e.preventDefault();
    
    // If body has the animated scrolling class, don't handle clicks
    if (document.body.classList.contains('is-animated-scrolling')) {
      return;
    }
    
    if (!isSlideAnimating) {
      var currentSlide = $('.slideshow-left').slick('slickCurrentSlide');
      var isFirstSlide = currentSlide === 0;
      
      if (isFirstSlide) {
        // If at first slide, go to previous section
        var prevSection = $('.split-slideshow').prev('.homepage-section');
        $('.split-slideshow').addClass('transitioning');
        
        if (prevSection.length && typeof window.moveToPrevSection === 'function') {
          window.moveToPrevSection();
          // Remove transitioning class after animation completes
          setTimeout(function() {
            $('.split-slideshow').removeClass('transitioning');
          }, 1500);
        }
      } else {
        // Go to previous slide
        $('.slideshow-left').slick('slickPrev');
      }
      $scrollCue.fadeOut(400);
    }
  });
  
  $('<button class="next-slide" aria-label="Next slide"><i class="fas fa-chevron-right"></i></button>').appendTo($navContainer).on('click', function(e) {
    e.preventDefault();
    
    // If body has the animated scrolling class, don't handle clicks
    if (document.body.classList.contains('is-animated-scrolling')) {
      return;
    }
    
    if (!isSlideAnimating) {
      // Check if we're at the last slide
      var currentSlide = $('.slideshow-left').slick('slickCurrentSlide');
      var isLastSlide = currentSlide === maxItems - 1;
      
      if (isLastSlide) {
        // If at the last slide, move to the next section
        var nextSection = $('.split-slideshow').next('.homepage-section');
        $('.split-slideshow').addClass('transitioning');
        
        if (nextSection.length && typeof window.moveToNextSection === 'function') {
          window.moveToNextSection();
          // Remove transitioning class after animation completes
          setTimeout(function() {
            $('.split-slideshow').removeClass('transitioning');
          }, 1500);
        }
      } else {
        // Otherwise go to next slide
        $('.slideshow-left').slick('slickNext');
      }
      $scrollCue.fadeOut(400);
    }
  });
  
  // Make sure slideshow is properly initialized
  setTimeout(function() {
    // Force a resize event to ensure Slick recalculates dimensions properly
    $(window).trigger('resize');
    
    // Force slider to redraw after small delay
    $('.slideshow-left').slick('refresh');
    $('.slideshow-right .slider').slick('refresh');
    $('.slideshow-text').slick('refresh');
    
    // Initialize slide indicator
    updateSlideIndicator($('.slideshow-left').slick('slickCurrentSlide'));
  }, 100);
  
  // Expose methods for ScrollTrigger integration
  window.splitSlideshow = {
    getSlideCount: function() {
      return maxItems;
    },
    getCurrentSlide: function() {
      return $('.slideshow-left').slick('slickCurrentSlide');
    },
    isAnimating: function() {
      return isSlideAnimating;
    },
    goToSlide: function(index) {
      if (index >= 0 && index < maxItems) {
        $('.slideshow-left').slick('slickGoTo', index);
      }
    },
    refresh: function() {
      $('.slideshow-left').slick('refresh');
      $('.slideshow-right .slider').slick('refresh');
      $('.slideshow-text').slick('refresh');
    }
  };
  
  // Make slick gallery adapt to screen size changes
  $(window).on('resize', function() {
    setTimeout(function() {
      $('.slideshow-left').slick('refresh');
      $('.slideshow-right .slider').slick('refresh');
      $('.slideshow-text').slick('refresh');
    }, 50);
  });
});