
//permet a l'utilisateur de postuler, sachant que la liaison existe déjà entre lui et l'offre
function fctPostuler(utilisateur_id,liaison_id,offre_id)
{
    $.post("requetes/PanierPostVide.php",
    {
        utilisateur:utilisateur_id,
    }).done(function(PanierVide)
    {    
        //si le panier est vide on affiche un message 
        if (PanierVide=="true") 
        {
            if (confirm("Ce bouton ne permet pas de postuler, c'est une aide-mémoire pour suivre vos stages, poursuivre ?")) 
            {
                $.post("requetes/PostuleRequetePanier.php",
                {
                    id:liaison_id,
                    utilisateur:utilisateur_id,
                    offre:offre_id
                }).done(function(data){
                    document.getElementById("btn_postule"+offre_id).innerHTML="<i>déjà postulé</i>";
                    document.getElementById("btn_postule"+offre_id).setAttribute('onclick','fctDejaPostuler('+utilisateur_id+','+liaison_id+','+offre_id+')');
                });
            }
        }
        else if (PanierVide=="false")
        {
            $.post("requetes/PostuleRequetePanier.php",
            {
                id:liaison_id,
                utilisateur:utilisateur_id,
                offre:offre_id
            }).done(function(data){
                document.getElementById("btn_postule"+offre_id).innerHTML="<i>déjà postulé</i>";
                document.getElementById("btn_postule"+offre_id).setAttribute('onclick','fctDejaPostuler('+utilisateur_id+','+liaison_id+','+offre_id+')');
            });
        }
    }); 
}

//permet a l'utilisateur de ne plus postuler, sachant que la liaison existe déjà entre lui et l'offre
function fctDejaPostuler(utilisateur_id,liaison_id,offre_id)
{
    $.post("requetes/DejaPostuleRequetePanier.php",
    {
        id:liaison_id
    }).done(function(data){
        document.getElementById("btn_postule"+offre_id).innerHTML="postuler";
        document.getElementById("btn_postule"+offre_id).setAttribute('onclick','fctPostuler('+utilisateur_id+','+liaison_id+','+offre_id+')');
    });
}

//permet a l'utilisateur de postuler, sachant que la liaison n'existe pas
function fctCreerPostuler(utilisateur_id,offre_id)
{
    $.post("requetes/PanierPostVide.php",
    {
        utilisateur:utilisateur_id,
    }).done(function(PanierVide)
    {    
        console.log(PanierVide);
        if (PanierVide=="true") 
        {
            if (confirm("Ce bouton ne permet pas de postuler, c'est une aide-mémoire pour suivre vos stages, poursuivre ?")) 
            {
                $.post("requetes/PremierPostuleRequetePanier.php",
                {
                    utilisateur:utilisateur_id,
                    offre:offre_id
                }).done(function(liaison_id){
                    document.getElementById("btn_postule"+offre_id).innerHTML="<i>déjà postulé</i>";
                    document.getElementById("btn_postule"+offre_id).setAttribute('onclick','fctDejaPostuler('+utilisateur_id+','+liaison_id+','+offre_id+')');
                });
            }
        }
        else if (PanierVide=="false")
        {
            $.post("requetes/PremierPostuleRequetePanier.php",
            {
                utilisateur:utilisateur_id,
                offre:offre_id
            }).done(function(liaison_id){
                document.getElementById("btn_postule"+offre_id).innerHTML="<i>déjà postulé</i>";
                document.getElementById("btn_postule"+offre_id).setAttribute('onclick','fctDejaPostuler('+utilisateur_id+','+liaison_id+','+offre_id+')');
            });
        }
    }); 
}

//permet a l'utilisateur de save, sachant que la liaison existe déjà entre lui et l'offre
function fctSave2(liaison_id,offre_id)
{
    $.post("requetes/SaveRequetePanier.php",
    {
        id:liaison_id
    }).done(function(data){
        document.getElementById("btn_save"+offre_id).innerHTML='<img src="images/panierMoins.PNG" class="imagePanier" alt="panier moins">';
        document.getElementById("btn_save"+offre_id).setAttribute('onclick','fctDejaSave2('+liaison_id+','+offre_id+')');
    });
}

//permet a l'utilisateur de ne plus save, sachant que la liaison existe déjà entre lui et l'offre
function fctDejaSave2(liaison_id,offre_id)
{
    $.post("requetes/DejaSaveRequetePanier.php",
    {
        id:liaison_id
    }).done(function(data){
        document.getElementById("btn_save"+offre_id).innerHTML='<img src="images/panierPlus.PNG" class="imagePanier" alt="panier plus">';
        document.getElementById("btn_save"+offre_id).setAttribute('onclick','fctSave2('+liaison_id+','+offre_id+')');
    });
}

//permet a l'utilisateur de save, sachant que la liaison n'existe pas
function fctCreerSave2(utilisateur_id,offre_id)
{
    $.post("requetes/PremierSaveRequetePanier.php",
    {
        utilisateur:utilisateur_id,
        offre:offre_id
    }).done(function(liaison_id){
        document.getElementById("btn_save"+offre_id).innerHTML='<img src="images/panierMoins.PNG" class="imagePanier" alt="panier moins">';
        document.getElementById("btn_save"+offre_id).setAttribute('onclick','fctDejaSave2('+liaison_id+','+offre_id+')');
    });
}

//permet à l'admin de valider l'offre
function fctValide(offre_id)
{   
    $.post("requetes/Valide.php",
    {
        offre:offre_id
    }).done(function(data){
        document.getElementById("btn_valide"+offre_id).innerHTML='<i>déjà validée</i>';
        document.getElementById("btn_valide"+offre_id).setAttribute('onclick','fctDejaValide('+offre_id+')');
                console.log("entre");

    });
}

//permet à l'admin d'annuler la validation de l'offre
function fctDejaValide(offre_id)
{   
    $.post("requetes/DejaValide.php",
    {
        offre:offre_id
    }).done(function(data){
        document.getElementById("btn_valide"+offre_id).innerHTML='valider';
        document.getElementById("btn_valide"+offre_id).setAttribute('onclick','fctValide('+offre_id+')');
    });
}

//permet de supprimer l'offre pour l'admin
function fctSupprimerOffre(offre_id)
{
    if (confirm("Voulez-vous vraiment supprimer l'offre ?\n\Cette action est irréversible")) 
    {
         $.post("requetes/SupprimerOffre.php",
    {
        offre:offre_id
    }).done(function(data){
        document.getElementById("div"+offre_id).innerHTML='<h5>L\'offre a bien été supprimée.</h5>';
    })
    }
}

//permet de supprimer l'offre pour le recruteur
function fctSupprimerOffre2 (offre_id)
{
    if (confirm("Voulez-vous vraiment supprimer l'offre ?\n\Cette action est irréversible")) 
    {
         $.post("requetes/SupprimerOffre.php",
    {
        offre:offre_id
    }).done(function(data){
        document.location.href="index.php";
    })
    }
}

//permet de signaler l'offre
function fctSignale (offre_id)
{
    if (confirm("Voulez-vous vraiment signaler l'offre ?\n\Cette action est irréversible, l'offre sera signalée comme n'étant plus disponible et ne sera plus visible")) 
    {
        $.post("requetes/Signale.php",
         {
             offre:offre_id
         }).done(function(data){
             document.getElementById("btn_signale"+offre_id).innerHTML='<i>déjà signalée</i>';
             document.getElementById("btn_signale"+offre_id).setAttribute('onclick','fctDejaSignale('+offre_id+')');
         });
     }
}

//permet d'enlever le signalement l'offre (disponible pour celui qui vient de signaler l'offre et n'a pas rechargé la page
function fctDejaSignale (offre_id)
{
   $.post("requetes/DejaSignale.php",
    {
        offre:offre_id
    }).done(function(data){
        document.getElementById("btn_signale"+offre_id).innerHTML='signaler';
        document.getElementById("btn_signale"+offre_id).setAttribute('onclick','fctSignale('+offre_id+')');
    });
}

//l'admin peut supprimer un utilisateur
function fctSupprimerUser (user_id)
{
    if (confirm("Voulez-vous vraiment supprimer l'utilisateur ?\n\Cette action est irréversible")) 
    {
        $.post("requetes/SupprimerUser.php",
         {
             id:user_id
             
         }).done(function(data){
             document.location.href="IAusers.php";
         });
     }
}

//l'admin peut valider un utilisateur
function fctValiderUser (user_id)
{
    if (confirm("Voulez-vous valider l'utilisateur ?")) 
    {
    $.post("requetes/ValideUser.php",
    {
        id:user_id
    }).done(function(data){
        document.location.href="IAusers.php";
    });
    }
}

function fctSupprimerEntreprise(entreprise_id)
{
    if (confirm("Voulez-vous supprimer l'entreprise ?\n\
Cette action est définitive et supprimera les contacts, offres et adresses liées."))
    {
        $.post("requetes/SupprimerEntreprise.php",{
            entreprise:entreprise_id
        }).done(function(data){
             document.location.href="IAEntreprises.php";
        });     
    }
}

function fctSupprimerContact(contact_id)
{
    if (confirm("Voulez-vous supprimer ce contact ?\n\
Cette action est définitive"))
    {
        $.post("requetes/SupprimerContact.php",{
            contact:contact_id
        }).done(function(data){
             document.location.href="IAContacts.php";
        });     
    }
}