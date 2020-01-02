// hide/show mini tables on adminArea
$('.adminArea table thead').click(function(){
  $(this).next('tbody').slideToggle();
});

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
    myInput.parentElement.previousElementSibling.innerHTML += "*";
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

// hide/show add-new btn
var addNew = document.querySelector('.add-new');
if (addNew) {
  if(document.body.clientHeight < window.innerHeight){
    addNew.style.display = 'none';
  } else {
    addNew.style.display = 'block';
  }
}

// sorting selects
var selectContainer = document.getElementById('sorting-container');
if(selectContainer) {
  var selects = selectContainer.querySelectorAll('select');
  for(select of selects) {
    select.onchange = function(){
      window.location.href = this.value;
      this.setAttribute('selected');
    };
  }
}

/*
// form validation
var theForm = document.forms[0];
if (theForm){
  theForm.onsubmit = function() {
    var fields = theForm.querySelectorAll('input,textarea');
    var i;

    for (i = 0; i < fields.length; i++) {
      theForm.innerHTML += "<br/><br/><br/>";
      if(fields[i].hasAttribute('required')){
        if(fields[i].value == ""){
          theForm.innerHTML += 
            "<div class='alert alert-danger' role='alert'>" + 
            "<i class='fa fa-times'></i> the " + 
            fields[i].placeholder + 
            " cant be empty</div>";
        } 
        return false;
      } else {
        return true;
      }
    }
  };
}*/