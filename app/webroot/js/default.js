$(document).ready(function() {

  $('.select_button').each(function() {


    $(this).click(function() {
      
      $(this).parent().toggleClass('selected');

      var url = $(this).attr('href') + '/' + $(this).parent().hasClass('selected');
      $.ajax({ 'url': url });
      
      return false;

    });//$(this).click


  });//$('.select_button').each



  $("a[rel=images_group]").fancybox({
    'transitionIn'    : 'none',
    'transitionOut'   : 'none',
    'overlayColor'    : '#EEE',
    'overlayOpacity'  : '0.5',
    'titlePosition'   : 'inside',
    'titleFormat'   : function(title, currentArray, currentIndex, currentOpts)
    {
        return false; //MORGEN. ;)
        var linkElement = $($("a[rel=images_group]")[currentIndex]).parent().parent().children("a");
        var link = linkElement.attr('href');
        return '<span id="fancybox-title-over">' + (title.length ? ' &nbsp; ' + title : '') + '<a class="select_button" href="' + link + '">LIKE</a></span>';
    }
  });


});//$(document).ready
