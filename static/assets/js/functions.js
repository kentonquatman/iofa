var resizeSmoothScroll = function() {
  if ($('header').css('position') == 'fixed'){ $('.faq-list a').smoothScroll({offset: -83}); }
  else { $('.faq-list a').smoothScroll(); }
};

var Site = window.Site || {};
(function($) {
  $(function() {

    // PLACEHOLDER

    $('input, textarea').placeholder();
    
    // PANEL NAV
    
    $('.wrapper').click(function(){
      if ($('body').hasClass('open-nav')){
        $('body').removeClass('open-nav');
      }
    });
    
    $('header .nav-toggle').click(function(){
      event.stopPropagation();
      $('body').toggleClass('open-nav');
      return false;
    });
    
    // SMOOTH-SCROLL

    resizeSmoothScroll();

    // FLEXSLIDER
    
    $('.slideshow').flexslider({
      animation:'slide',
      start: function(slider){
        $('.slideshow').removeClass('loading');
      }
    });

  });
})(jQuery);