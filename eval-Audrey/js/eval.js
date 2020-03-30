function affiche(id)
{
    if (id=="affiche_Co")
    {
        $('#connexion').removeClass("d_none");
        $('#inscription').addClass("d_none");
    }
    else
    {
        $('#inscription').removeClass("d_none");
        $('#connexion').addClass("d_none");

    }
}
$('#affiche_Ins').on("click",function (){affiche("affiche_Ins")});
$('#affiche_Co').on("click",function (){affiche("affiche_Co")});



function check_espace(texte)
{
    var espace_test_debut = /^ /,
        espace_test_fin = / $/;

    if (espace_test_debut.test(texte) || espace_test_fin.test(texte)) {
        return true;
    }
    else
        {
            return false;
        }
}

function check_inscription()
{
    var isOk=true;
    var email_test=/^[a-zA-Z]{1}[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/,
        pass_test=/^[a-z0-9._]*[A-Z]+[a-z0-9._]*[0-9]+[a-z0-9._]*$/;


    var pseudo=document.getElementById("pseudo").value,
        mail=document.getElementById("mail").value,
        password=document.getElementById("password").value,
        password_conf=document.getElementById("password_conf").value,
        nom=document.getElementById("nom").value,
        prenom=document.getElementById("prenom").value,
        sexe=document.getElementsByName("sexe"),
        age=document.getElementById("age").value,
        ville=document.getElementById("ville").value;

    if (sessionStorage.getItem("list_membre")===null)
    {
    /*Ajout des éléments fictifs dans la liste sinon problème avec la variable split_membre quand elle est vide*/
        liste_membre={
            "pseudo":'test',
            "mail":'test',
            "password":'test',
            "nom":'test',
            "prenom":'test',
            "sexe":'test',
            "age":'test',
            "ville":'test'

        };
        liste_membre2={
            "pseudo":'test1',
            "mail":'test1',
            "password":'test1',
            "nom":'tes1t',
            "prenom":'test1',
            "sexe":'tes1t',
            "age":'test1',
            "ville":'test1'

        };
        liste_membre=JSON.stringify(liste_membre);
        liste_membre2=JSON.stringify((liste_membre2));
        liste_membre=liste_membre+';'+liste_membre2;
        liste_membre=sessionStorage.setItem("list_membre",liste_membre);
    }
    else
    {
        var split_membre=sessionStorage.getItem("list_membre").split(';');

        if ((check_espace(pseudo) || check_espace(mail) || check_espace(password) || check_espace(password_conf) || check_espace(nom) || check_espace(prenom) || check_espace(age) || check_espace(ville)))
        {
            alert('Attention aux espaces en début ou fin, réessayer');
            isOk=false;
        }

        for (let i=0;i<split_membre.length;i++)
        {
            var test_membre=split_membre[i];
            var obj = JSON.parse(test_membre);
            if (obj.pseudo===pseudo)
            {
                alert('Pseudo déjà utilisé, réessayer');
                isOk=false;
            }
            if( obj.mail===mail)
            {
                alert('Mail déjà utilisé, réessayer');
                isOk=false;
            }
        }
        if(pseudo==="" || mail==="" || password==="" ||password_conf==="" || nom==="" || prenom==="")
        {
            alert("Veuillez renseigner les champs obligatoires s'il vous plaît.");
            isOk=false;
        }
        if (!(email_test.test(mail)))
        {
            alert('Format email invalide, réessayer');
            isOk=false;
        }
        if(!(pass_test.test((password))) && (password.length<8))
        {
            alert('Format du mot de passe non valide, réessayer');
            isOk=false;

        }
        if(password!=password_conf)
        {
            alert('Erreur dans la confirmation du mot de passe');
            isOk=false;
        }
        if (!(sexe[0].checked || sexe[1].checked))
        {
            alert('Veuillez entrer votre genre');
            isOk=false;
        }
        if ((parseInt(age)<1) || (parseInt(age)>135))
        {
            isOk=false;
            alert('Erreur dans l\'âge, réessayer.');
        }
        if (isOk)
        {
            for (let i=0;i<2;i++)
            {
                if (sexe[i].checked) {
                    var membre = {
                        'pseudo': pseudo,
                        'mail': mail,
                        'password': password,
                        'nom': nom,
                        'prenom': prenom,
                        'sexe': sexe[i].value,
                        'age': age,
                        'ville': ville
                    };
                }
            }

            membre =JSON.stringify(membre);
            var l_membre=sessionStorage.getItem("list_membre");
            var membre_n=l_membre+';'+membre;
            sessionStorage.setItem("list_membre",membre_n);
            console.log(sessionStorage.getItem("list_membre"));
            (function (){affiche("affiche_Co")}());
        }

    }

}
document.getElementById("inscrire").addEventListener("click",check_inscription,false);


function check_connexion()
{
    var isOk=true;
    var inDd=false;
    var pass_test=/^[a-z0-9._]*[A-Z]+[a-z0-9._]*[0-9]+[a-z0-9._]*$/;
        liste_membre=sessionStorage.getItem("list_membre");
    var split_membre=liste_membre.split(';');
    var identifiant=document.getElementById("pseudoMailCo").value,
        mot_de_passe=document.getElementById("pass_co").value;
    var pseudonyme="";


    if(!(pass_test.test((mot_de_passe))) && (mot_de_passe.length<8))
    {
        alert('Format du mot de passe non valide, réessayer');
        isOk=false;
    }
    if(check_espace(identifiant)||check_espace(mot_de_passe))
    {
        alert('Attention aux espaces au début et à la fin des champs');
        isOk=false;
    }
    for (let i=0; i<split_membre.length;i++)
    {
        var obj=JSON.parse(split_membre[i]);
        console.log(obj.pseudo);
        if((identifiant===obj.pseudo && mot_de_passe===obj.password) || (identifiant===obj.mail && mot_de_passe===obj.password))
        {
            pseudonyme=obj.pseudo;
            inDd=true;
        }
        else
        {
            inDd=false;
        }

    }
    if(!inDd)
    {
        alert('Identifiant ou mot de passe incorrect, réessayer.');
        isOk=false;
    }
    if (isOk)
    {
        var date=new Date(),
            jour=date.getDate(),
            mois=date.getMonth()+1,
            annee=date.getFullYear(),
            heure=date.getHours(),
            minute=date.getMinutes(),
            seconde=date.getSeconds();

        var session={
            "pseudo_co":pseudonyme,
            "date_co":jour+'/'+mois+'/'+annee+' à '+heure+'H '+minute+'min '+seconde+'s'
        };
        session=JSON.stringify(session);
        sessionStorage.setItem("session:",session);
        console.log(sessionStorage.getItem("session:"));
        document.getElementById("connexion").submit();
    }

}
document.getElementById("connecter").addEventListener("click", check_connexion,false);





