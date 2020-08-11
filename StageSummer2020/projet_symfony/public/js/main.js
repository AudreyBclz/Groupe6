document.getElementById("footer").classList.add('sticky2');

// When the user scrolls the page, execute myFunction
window.onscroll = function() {myFunction()};

// Get the header
var header = document.getElementById("nav");

var footer = document.getElementById('footer');

// Get the offset position of the navbar
var sticky = header.offsetTop;
var sticky2=footer.offsetTop;

// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
  if (window.pageYOffset <= sticky2) {

    footer.classList.add('sticky2');
  }
}

function hauteur(block,block2)
{
  if(block.clientHeight < screen.availHeight && window.innerWidth<768)
  {
    $("#instaligne").css('height', '150%');
  }
  else if (block.clientHeight < screen.availHeight) {
    block2.css('height', '91vh');

  } else {
    block2.css('height', '100%');
  }
}
window.onresize=function () {
  hauteur(document.getElementById('second'),$('#second'));
  hauteur(document.getElementById('third'),$('#third'));
  hauteur(document.getElementById('fourth'),$('#fourth'));
  hauteur(document.getElementById('fifth'),$('#fifth'));
  hauteur(document.getElementById('sixth'),$('#sixth'));
  hauteur(document.getElementById('seventh'),$('#seventh'));
  hauteur(document.getElementById('seventh'),$('#eight'));
};
hauteur(document.getElementById('second'),$('#second'));
hauteur(document.getElementById('third'),$('#third'));
hauteur(document.getElementById('fourth'),$('#fourth'));
hauteur(document.getElementById('fifth'),$('#fifth'));
hauteur(document.getElementById('sixth'),$('#sixth'));
hauteur(document.getElementById('seventh'),$('#seventh'));
hauteur(document.getElementById('seventh'),$('#eight'));


$('a[href="https://elfsight.com/instagram-feed-instashow/?utm_source=websites&utm_medium=clients&utm_content=instagram-feed&utm_term=undefined&utm_campaign=free-widget"]').css('display','none !important');

$('#first').on('click',function () {
  $("#accueil").addClass('slide-in-left')
});
$('#first').on('mouseenter',function () {
  $("#accueil").addClass('slide-in-left')
});
$('#first').on('mouseleave',function () {
  $("#accueil").removeClass('slide-in-left')
});

$('#second').on('click',function () {
  $("#titreBio").addClass('slide-in-left');
  $("#titreBio").removeClass('invisible')
});
$('#second').on('mouseenter',function () {
  $("#titreBio").addClass('slide-in-left');
  $("#titreBio").removeClass('invisible')
});
$('#second').on('mouseleave',function () {
  $("#titreBio").removeClass('slide-in-left');
  $("#titreBio").addClass('invisible');
});

$('#second').on('click',function () {
  $("#col1Bio").addClass('slide-in-bottom');
  $("#col1Bio").removeClass('invisible');
});
$('#second').on('mouseenter',function () {
  $("#col1Bio").addClass('slide-in-bottom');
  $("#col1Bio").removeClass('invisible');
});
$('#second').on('mouseleave',function () {
  $("#col1Bio").removeClass('slide-in-bottom');
  $("#col1Bio").addClass('invisible');
});

$('#second').on('click',function () {
  $("#col2Bio").addClass('slide-in-bottom');
  $("#col2Bio").removeClass('invisible');
});
$('#second').on('mouseenter',function () {
  $("#col2Bio").addClass('slide-in-bottom');
  $("#col2Bio").removeClass('invisible');
});
$('#second').on('mouseleave',function () {
  $("#col2Bio").removeClass('slide-in-bottom');
  $("#col2Bio").addClass('invisible');
});


$('#third').on('click',function () {
  $("#gta").addClass('slide-in-top');
  $("#gta").removeClass('invisible')
});
$('#third').on('mouseenter',function () {
  $("#gta").addClass('slide-in-top');
  $("#gta").removeClass('invisible')
});
$('#third').on('mouseleave',function () {
  $("#gta").removeClass('slide-in-top');
  $("#gta").addClass('invisible');
});

$('#third').on('click',function () {
  $("#col1gta").addClass('slide-in-left');
  $("#col1gta").removeClass('invisible');
});
$('#third').on('mouseenter',function () {
  $("#col1gta").addClass('slide-in-left');
  $("#col1gta").removeClass('invisible');
});
$('#third').on('mouseleave',function () {
  $("#col1gta").removeClass('slide-in-left');
  $("#col1gta").addClass('invisible');
});

$('#third').on('click',function () {
  $("#col2gta").addClass('slide-in-right');
  $("#col2gta").removeClass('invisible');
});
$('#third').on('mouseenter',function () {
  $("#col2gta").addClass('slide-in-right');
  $("#col2gta").removeClass('invisible');
});
$('#third').on('mouseleave',function () {
  $("#col2gta").removeClass('slide-in-right');
  $("#col2gta").addClass('invisible');
});


$('#fifth').on('click',function () {
  $("#insta").addClass('slide-in-top');
  $("#insta").removeClass('invisible')
});
$('#fifth').on('mouseenter',function () {
  $("#insta").addClass('slide-in-top');
  $("#insta").removeClass('invisible')
});
$('#fifth').on('mouseleave',function () {
  $("#insta").removeClass('slide-in-top');
  $("#insta").addClass('invisible');
});

$('#fifth').on('click',function () {
  $("#instaligne").addClass('slide-in-left');
  $("#instaligne").removeClass('invisible');
});
$('#fifth').on('mouseenter',function () {
  $("#instaligne").addClass('slide-in-left');
  $("#instaligne").removeClass('invisible');
});


$('#sixth').on('click',function () {
  $("#g2a").addClass('slide-in-left');
  $("#g2a").removeClass('invisible')
});
$('#sixth').on('mouseenter',function () {
  $("#g2a").addClass('slide-in-left');
  $("#g2a").removeClass('invisible')
});
$('#sixth').on('mouseleave',function () {
  $("#g2a").removeClass('slide-in-left');
  $("#g2a").addClass('invisible');
});

$('#sixth').on('click',function () {
  $("#lien").addClass('slide-in-right');
  $("#lien").removeClass('invisible')
});
$('#sixth').on('mouseenter',function () {
  $("#lien").addClass('slide-in-right');
  $("#lien").removeClass('invisible')
});
$('#sixth').on('mouseleave',function () {
  $("#lien").removeClass('slide-in-right');
  $("#lien").addClass('invisible');
});



$('#fourth').on('click',function () {
  $("#ytb").addClass('slide-in-top');
  $("#ytb").removeClass('invisible')
});
$('#fourth').on('mouseenter',function () {
  $("#ytb").addClass('slide-in-top');
  $("#ytb").removeClass('invisible')
});
$('#fourth').on('mouseleave',function () {
  $("#ytb").removeClass('slide-in-top');
  $("#ytb").addClass('invisible');
});

$('#fourth').on('click',function () {
  $("#ytbligne").addClass('slide-in-left');
  $("#ytbligne").removeClass('invisible');
});
$('#fourth').on('mouseenter',function () {
  $("#ytbligne").addClass('slide-in-left');
  $("#ytbligne").removeClass('invisible');
});


$('#seventh').on('click',function () {
  $("#contact").addClass('slide-in-right');
  $("#contact").removeClass('invisible');
});
$('#seventh').on('mouseenter',function () {
  $("#contact").addClass('slide-in-right');
  $("#contact").removeClass('invisible');
});
$('#seventh').on('mouseleave',function () {
  $("#contact").removeClass('slide-in-right');
  $("#contact").addClass('invisible');
});


$('#eight').on('click',function () {
  $("#Arozzi").addClass('slide-in-right');
  $("#Arozzi").removeClass('invisible')
});
$('#eight').on('mouseenter',function () {
  $("#Arozzi").addClass('slide-in-right');
  $("#Arozzi").removeClass('invisible')
});
$('#eight').on('mouseleave',function () {
  $("#Arozzi").removeClass('slide-in-right');
  $("#Arozzi").addClass('invisible');
});

$('#eight').on('click',function () {
  $("#lienA").addClass('slide-in-left');
  $("#lienA").removeClass('invisible')
});
$('#eight').on('mouseenter',function () {
  $("#lienA").addClass('slide-in-left');
  $("#lienA").removeClass('invisible')
});
$('#eight').on('mouseleave',function () {
  $("#lienA").removeClass('slide-in-left');
  $("#lienA").addClass('invisible');
});
