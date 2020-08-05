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
    if (block.clientHeight < screen.availHeight) {
        block2.css('height', '91vh');

    } else {
        block2.css('height', block.height);
    }
}
hauteur(document.getElementById('second'),$('#second'));
hauteur(document.getElementById('third'),$('#third'));
hauteur(document.getElementById('fourth'),$('#fourth'));
hauteur(document.getElementById('fifth'),$('#fifth'));
hauteur(document.getElementById('fifth'),$('#sixth'));

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
