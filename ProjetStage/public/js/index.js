
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

function aff_adresse()
{
    if (document.getElementById("livraison").checked)
    {
        $("#ad_paiement").addClass("d-none");
    }
    else
    {
        $("#ad_paiement").removeClass("d-none");
    }
}

$("#livraison").on("click",aff_adresse);

function aff_coord()
{
    if (document.getElementById("paypal").checked)
    {
        $("#bouton_paypal").removeClass("d-none");
        $("#coord_bancaire").addClass("invisible");
        $("#bouton_cb").addClass("d-none");
    }
    else if(document.getElementById("cb").checked)
    {
        $("#bouton_cb").removeClass("d-none");
        $("#coord_bancaire").removeClass("invisible");
        $("#bouton_paypal").addClass("d-none");
    }
}

$("#paypal").on("click",aff_coord);
$("#cb").on("click",aff_coord);

function controle_inscription()
{

    var email=document.getElementById("email").value;
    var email_conf=document.getElementById("conf_email").value;
    var mdp=document.getElementById("mdp").value;
    var conf_mdp=document.getElementById("conf_mdp").value;
    var test_mdp=/^[a-zA-Z0-9.-_]*[A-Z]{1}[a-zA-Z0-9.-_]*$/;
    var test_mail=/^[a-zA-Z]{1}[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-z]{2,6}$/;
    var testForm = true;

    if(!test_mail.test(email))
    {
        testForm=false;
        alert('Format de l\'adresse mail non valide');
    }
    else if(!(email === email_conf))
    {
        testForm=false;
        alert("Erreur lors de la confirmation du mail");
    }
    else if (mdp.length<8)
    {
        testForm=false;
        alert("Mot de passe trop court, il faut 8 caractères minimum");
    }
    else if( mdp !== conf_mdp)
    {
        testForm=false;
        alert("Erreur lors de la confirmation du mot de passe");
    }
    else if (!document.getElementById("robot").checked)
    {
        testForm=false;
        alert("Vous devez cocher la case");
    }
    else if(!test_mdp.test(mdp))
    {
        testForm=false;
        alert("Le mot de passe doit contenir une majuscule");
    }
   return testForm;
}
$("#inscription").on("click",controle_inscription);

function controle_contact()
{
    var email=document.getElementById("mail").value;
    var contact_mail=/^[a-zA-Z0-9]{1}[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-z]{2,6}$/;

   if(!contact_mail.test(email))
    {
        alert('Format de l\'adresse mail non valide, réessayer.');
        return false;
    }
    else
    {
        return true;
    }
}
$("#btn_contact").on("click",controle_contact);

function controle_cafe()
{
    var prix=document.getElementById("prix").value;
    var decimal=/^[0-9]{1,3}\.?[0-9]{0,2}$/;


    if(!decimal.test(prix))
    {
        alert('Un nombre décimal ou entier est attendu.');
        return false;
    }
    else
    {
        return true;
    }
}
$("#ajout_cafe").on("click",controle_cafe);
$("#modif_cafe").on("click",controle_cafe);