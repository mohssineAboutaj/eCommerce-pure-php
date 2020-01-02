function singlePageApplication(page){
var xPage = new XMLHttpRequest();

xPage.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
                document.getElementById('boxAjax').innerHTML = xPage.responseText;
        }
}
xPage.open('GET', page, true);
xPage.send();
}