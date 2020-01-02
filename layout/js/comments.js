function singlePageApplication(page, info){
var xPage = new XMLHttpRequest();

  xPage.onreadystatechange = function(){
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById('boxAjax').innerHTML = xPage.responseText;
    }
  }
xPage.open('POST', page, true);
xPage.setRequestHeader('content-type','application/x-www-form-urlencoded');
xPage.send(info);
}