function cacher() {
    $("#navigation").fadeOut();
    $("#croix").hide();
    $("#plus").removeClass("d-none");

}

function afficher() {

    if (document.body.clientHeight < screen.availHeight) {
        $("#navigation").css('height', '100vh');
    } else {
        $("#navigation").css('height', document.body.clientHeight);
    }

    $("#navigation").removeClass("d-none");
    $("#navigation").fadeIn();
    $("#croix").show();
    $("#croix").removeClass("d-none");
    $("#plus").addClass("d-none");
}

$("#plus").on("click", afficher);
$("#croix").on("click", cacher);

function aff_adresse() {
    if (document.getElementById("livraison").checked) {
        $("#ad_paiement").addClass("d-none");
    } else {
        $("#ad_paiement").removeClass("d-none");
    }
}

$("#livraison").on("click", aff_adresse);

function aff_coord() {
    if (document.getElementById("paypal").checked) {
        $("#bouton_paypal").removeClass("d-none");
        $("#coord_bancaire").addClass("invisible");
        $("#bouton_cb").addClass("d-none");
    } else if (document.getElementById("cb").checked) {
        $("#bouton_cb").removeClass("d-none");
        $("#coord_bancaire").removeClass("invisible");
        $("#bouton_paypal").addClass("d-none");
    }
}

$("#paypal").on("click", aff_coord);
$("#cb").on("click", aff_coord);

function controle_inscription() {

    var email = document.getElementById("email").value;
    var email_conf = document.getElementById("conf_email").value;
    var mdp = document.getElementById("mdp").value;
    var conf_mdp = document.getElementById("conf_mdp").value;
    var test_mdp = /^[a-zA-Z0-9.-_*/&é"'êîïùèçà@]*[A-Z]{1}[a-zA-Z0-9.-_*/&é"'êîïùèçà@]*$/;
    var test_mail = /^[a-zA-Z0-9]{1}[a-zA-Z0-9._-]+@[a-zA-Z0-9]+\.[a-z]{2,6}$/;
    var testForm = true;

    if (!test_mail.test(email)) {
        testForm = false;
        alert('Format de l\'adresse mail non valide');
    } else if (!(email === email_conf)) {
        testForm = false;
        alert("Erreur lors de la confirmation du mail");
    } else if (mdp.length < 8) {
        testForm = false;
        alert("Mot de passe trop court, il faut 8 caractères minimum");
    } else if (mdp !== conf_mdp) {
        testForm = false;
        alert("Erreur lors de la confirmation du mot de passe");
    } else if (!document.getElementById("robot").checked) {
        testForm = false;
        alert("Vous devez cocher la case");
    } else if (!test_mdp.test(mdp)) {
        testForm = false;
        alert("Le mot de passe doit contenir une majuscule");
    }
    return testForm;
}

$("#inscription").on("click", controle_inscription);

function code_postal() {
    // on traite les 3 grandes villes qui n'apparaissent pas dans l'api (seul les "arrondissements" apparaissent)
    var cp = document.getElementById("codePost").value;
    if (cp == 13000) {
        document.getElementById("ville").value = "Marseille";
        document.getElementById("ville").innerText = "Marseille";
        document.getElementById("pays").value = "France";
    } else if (cp == 75000) {
        document.getElementById("ville").value = "Paris";
        document.getElementById("ville").innerText = "Paris";
        document.getElementById("pays").value = "France";
    } else if (cp == 69000) {
        document.getElementById("ville").value = "Lyon";
        document.getElementById("ville").innerText = "Lyon";
        document.getElementById("pays").value = "France";
    } else {
        $("#form_ins").submit();
    }
}

//on submit au changement pour utiliser l'api
$("#codePost").on("change", code_postal);


function controle_contact() {
    var email = document.getElementById("mail").value;
    var contact_mail = /^[a-zA-Z0-9]{1}[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-z]{2,6}$/;

    if (!contact_mail.test(email)) {
        alert('Format de l\'adresse mail non valide, réessayer.');
        return false;
    } else {
        return true;
    }
}

$("#btn_contact").on("click", controle_contact);

function controle_cafe() {
    var prix = document.getElementById("prix").value;
    var stock = document.getElementById("stock").value;

    var decimal = /^[0-9]{1,3}\.?[0-9]{0,2}$/;
    var entier = /^[0-9]{1,}$/;


    if (!decimal.test(prix)) {
        alert('Le prix doit être un nombre décimal (2 chiffres après la virgule) ou entier, inférieur à 1000.');
        return false;
    }
    if (!entier.test(stock)) {
        alert('Le stock doit être un nombre entier.');
        return false;
    } else {
        return true;
    }
}

$("#ajout_cafe").on("click", controle_cafe);
$("#modif_cafe").on("click", controle_cafe);

function controle_panier(quantite) {
    var test_quantite = /^[1-9]+[0-9]*$/;
    if (!test_quantite.test(quantite)) {
        alert('Veuillez entrer un nombre entier positif');
        return false;
    } else {
        $("#form_panier").submit();
    }
}

$(".quantite").on("change", function () {
    controle_panier(this.value);
});

function controle_adresse() {
    if (!$('#livraison').prop('checked')) {
        var nom = document.getElementById('nom').value,
            prenom = document.getElementById('prenom').value,
            adresse = document.getElementById('adresse').value,
            cp = document.getElementById('cp').value,
            ville = document.getElementById('ville').value;

        if (nom.length == 0 || prenom.length == 0 || adresse.length == 0 || cp.length == 0 || ville.length == 0) {
            alert('Adresse de livraison incomplète ou inexistante');
            return false;
        } else {
            return true;
        }
    }
}

$('#suivant').on('click', controle_adresse);


let putDeliveryBtn = $(".putDelivery");
putDeliveryBtn.on("click", function () {

    let id = $(this).attr("id");
    let date = $(this).attr("data-type");
    $.ajax({
        url: "src/views/ajax/ajax.php",
        method: "POST",
        data: {"id_user": id, "date": date},
        success: function (data) {
            $("button[data-type='"+date+"']").before(data);
        },
        error: function (resultat, statut, erreur) {
            console.log(erreur);

        }


    })
})

let bouton=$('.modif_compte');
bouton.on("click",function(){
    let nom= $('input[name="nom"]').val();
    let prenom=$('input[name="prenom"]').val();
    let email=$('input[name="email"]').val();
    let adresse=$('input[name="adresse"]').val();
    let complement=$('input[name="complement"]').val();
    let codePostal=$('input[name="codePost"]').val();
    let ville=$('input[name="ville"]').val();
    let pays=$('input[name="pays"]').val();
    $.ajax({
        url:"src/views/ajax/ajax.php",
        method: "POST",
        data: { "nom":nom,
                "prenom":prenom,
                "email":email,
                "adresse":adresse,
                "complement":complement,
                "codePost":codePostal,
                "ville":ville,
                "pays":pays},
        success: function (data){
            $(".container").prepend(data);
        }
    })
    }
)

function control_modif_mdp() {
    var mdp = document.getElementById("mdp").value;
    var test_mdp = /^[a-zA-Z0-9.-_*/&é"'êîïùèçà@]*[A-Z]{1}[a-zA-Z0-9.-_*/&é"'êîïùèçà@]*$/;

    if (mdp.length < 8) {
        alert('Mot de passe trop court.');
        return false
    } else if (!test_mdp.test(mdp)) {
        alert('Erreur dans le format du mot de passe; 8 caractères et une majuscule sont attendus');
        return false
    } else {

        return true
    }
}

$('#modif_mdp').on("click", control_modif_mdp);
