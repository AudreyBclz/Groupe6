
function cacher()
{
    $("#navigation").fadeOut();
    $("#croix").hide();
    $("#plus").removeClass("d-none");

}

function afficher()
{
    $("#navigation").removeClass("d-none");
    $("#navigation").fadeIn();
    $("#croix").show();
    $("#croix").removeClass("d-none");
    $("#plus").addClass("d-none");
}

$("#plus").on("click",afficher);
$("#croix").on("click",cacher);