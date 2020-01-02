var ajaxFolder = 'adminIncludes/ajax/';
var output = $('#pageContent');
var btn = $('#show-all');
if(output && btn){
  var loader = document.createElement('div');
  $(loader).css({
    margin: '0 auto',
    textAlign: 'center'
  });
  var loadingImg = '<img src="adminLayout/img/ajax-loader.gif" alt="ajax-loader" />';

  $(btn).click(function(){
    var pageName = output.attr('data-request');
    $.ajax({
      url: ajaxFolder + 'fetch.php?fetching=' + pageName,
      data: 'html',
      beforeSend: function(){ loader.innerHTML = 'loading '+ loadingImg; },
      success: function(data){
        $(btn).hide();
        $(loader).hide();
        $(output).html(data);
      }
    });
  });
}

setInterval(function(){
  $.ajax({
    url: ajaxFolder + 'stats.php',
    data: 'html',
    success: function(data){
      $("#all-stats").html(data);
    }
  });
}, 2000);



