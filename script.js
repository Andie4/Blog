// Pour pouvoir valider les formulaire avec la touche entrer
// source : https://openclassrooms.com/forum/sujet/valider-un-formulaire-avec-la-touche-entree-54146
function validerForm(){
    document.getElementById("formulaire").submit();
}


// afficher / masquer les commentaires : 
// inspiration pour l'affichage des commentaires : https://openclassrooms.com/forum/sujet/appuyer-sur-un-bouton-pour-afficher-du-texte-21481
function toggle_comments() {
    var commentsSection = document.getElementById('comments_section');
    var button = document.getElementById('toggle_comments_button');

    if (commentsSection.style.display === "none") {
        commentsSection.style.display = "block";
        button.textContent = "Cacher les commentaires";
    } else {
        commentsSection.style.display = "none";
        button.textContent = "Afficher les commentaires";
    }
}