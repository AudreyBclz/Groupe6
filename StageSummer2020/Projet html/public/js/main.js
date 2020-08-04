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
    } else {
        footer.classList.remove('sticky2');
    }
}


if (document.getElementById('second').clientHeight < screen.availHeight) {
    $("#second").css('height', '91vh');
    $("#second").css('z-index',0);
} else {
    $("#second").css('height', document.getElementById('second').height);
}


$('#first').on('mouseenter',function () {
$("#accueil").addClass('slide-in-left')
});
$('#first').on('mouseleave',function () {
    $("#accueil").removeClass('slide-in-left')
});


$('#second').on('mouseenter',function () {
    $("#titreBio").addClass('slide-in-left');
    $("#titreBio").removeClass('invisible')
});
$('#second').on('mouseleave',function () {
    $("#titreBio").removeClass('slide-in-left');
    $("#titreBio").addClass('invisible');
});


$('#second').on('mouseenter',function () {
    $("#col1Bio").addClass('slide-in-bottom');
    $("#col1Bio").removeClass('invisible');
});
$('#second').on('mouseleave',function () {
    $("#col1Bio").removeClass('slide-in-bottom');
    $("#col1Bio").addClass('invisible');
});


$('#second').on('mouseenter',function () {
    $("#col2Bio").addClass('slide-in-bottom');
    $("#col2Bio").removeClass('invisible');
});
$('#second').on('mouseleave',function () {
    $("#col2Bio").removeClass('slide-in-bottom');
    $("#col2Bio").addClass('invisible');
});

