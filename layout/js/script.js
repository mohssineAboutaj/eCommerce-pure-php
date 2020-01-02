/*
  * Description   : This is file javaScript give your website more dynamic elements
  * Author        : Mohssine Aboutaj
  * Date of const : 11/11/2017
  * File content  : functions {
                ===> headerFullScreen
                ===> addClassActive
                ===> projectFixedHeight
                ===> centeringContent
                ===> displayMiniNavbar
                ===> sliderShow
              } + more applications
*/
// header Functions

"use strict";

$('.loginPage span').click(function(){
  $(this).addClass('selected');
  $(this).siblings().removeClass('selected');
});

// toggle forms login/signUp
var log = document.getElementById('log'),
    sig = document.getElementById('sig'),
    formLog = document.querySelector('.loginForm'),
    formSig = document.querySelector('.signUpForm');

if(log && sig){
  log.addEventListener("click",function(){
    formLog.style.display = 'block';
    formSig.style.display = 'none';
  });

  sig.addEventListener("click",function(){
    formSig.style.display = 'block';
    formLog.style.display = 'none';
  });
}
// clear Placholder
document.querySelectorAll('input,textarea').forEach(function(myInput){
  // clear Placholder on focus
  myInput.addEventListener("focus",function(){
    this.setAttribute('data-holder',this.getAttribute('placeholder'));
    this.setAttribute('placeholder','');
  });

  // restore Placholder on blur
  myInput.addEventListener("blur",function(){
    this.setAttribute('placeholder',this.getAttribute('data-holder'));
    this.setAttribute('data-holder','');
  });
},this);

// add star aside required inputs
document.querySelectorAll('input,textarea').forEach(function(myInput){
  if (myInput.hasAttribute('required')) {
    myInput.parentElement.previousElementSibling.innerHTML += 
    "<span style='color:red'>*</span>";
  }
},this);

// confirm are you sure
document.querySelectorAll('.confirm').forEach(function(confirmBtn) {
  if (confirmBtn) {
    confirmBtn.onclick = function(e){
      return confirm('Are you sure you want to delete ?');
      e.preventDefault();
    };
  }
});

// show/hide password function
function showPassword(inputName){
  document.querySelector('input[name="'+ inputName +'"]').setAttribute('type','text');
  this.classList.add('fa-eye-slash');
  this.classList.remove('fa-eye');
};

function hidePassword(inputName){
  document.querySelector('input[name="'+ inputName +'"]').setAttribute('type','password');
  this.classList.remove('fa-eye-slash');
  this.classList.add('fa-eye');
};

// custom the input file
if (document.querySelector('.input-file')) {
  var inputFile = document.querySelector('.input-file'),
      customInputFile = document.createElement('span');
      inputFile.style.visibility = 'hidden',
      inputFile.parentElement.style.position = 'relative';
  $(customInputFile).css({
      backgroundColor: '#4B77BE',
      display: 'block',
      position: 'absolute',
      height: '100%',
      width: '100%',
      bottom: '0px',
      right: '0px',
      left: '10px',
      top: '0px',
      color: '#fff',
      textAlign: 'center',
      borderRadius: '5px',
      padding: '5px',
      cursor: 'pointer'
  }).html('<i class="fa fa-upload"></i> upload');

  customInputFile.onclick = function(){inputFile.click();}
  // append the custom input file on parent input
  inputFile.parentElement.appendChild(customInputFile);
  // check if the input empty , if true change the icon
  inputFile.onchange = function(){
    customInputFile.innerHTML = 
      '<i class="fa fa-check"></i> upload <u style="font-size: .5em">' +
      inputFile.value + '</u>';
  };
}

// fix footer to page bottom
var footer = document.querySelector('footer');
if (footer) {
  if(document.body.clientHeight < window.innerHeight + footer.clientHeight){
    footer.style.position = 'fixed';
  } else {
    footer.style.position = 'relative';
  }
}


// live preview
function livePreview(theInput, theOutput){
  var myInput = document.querySelector(theInput),
      myOutput = document.querySelector(theOutput);
  function inputOutput() {
    myOutput.innerHTML = this.value;
  }

  myInput.onkeyup = inputOutput;
  myInput.onblur = inputOutput;
}
if (document.querySelector('.live-preview')) {
  livePreview('#name','h3');
  livePreview('#desc','p');
  livePreview('#price','.price');
}

// change profile img
function changeImg(){
  document.querySelector('.change-img').click();
}

// fix footer to page bottom
var footer = document.querySelector('footer');
if (footer) {
  if(document.body.clientHeight < window.innerHeight + footer.clientHeight){
    footer.style.position = 'fixed';
    footer.style.bottom = '0';
    footer.style.right = '0';
    footer.style.left = '0';
    footer.style.width = '100%';
  }
}