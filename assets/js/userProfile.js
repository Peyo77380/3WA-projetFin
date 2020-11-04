'use strict';

document.addEventListener('DOMContentLoaded', init);

// permet l'affichage du profil utilisateur et sa modification en directement dans l'affichage "principale"
// au lieu de passer sur les controlleurs spécifiques et leurs vues.
class userProfileDisplay {
    constructor() {

        this.modifyButtons = [];
        document.querySelectorAll('.fa-pencil').forEach(button => {
            button.parentNode.addEventListener('click', this.toggleForms);
            this.modifyButtons.push(button.parentNode);
        });

        this.updateForms = document.querySelectorAll('form[action="UserProfileUpdate"]');
        this.updateForms.forEach(form => {
            form.addEventListener('submit', this.saveChangesToDb);
        })

    }

    toggleForms() {
        // au clic sur le crayon pour la modification, un formulaire apparait,
        // contenant les infos déjà en place et laissant un champ pour la modification.
        let button = this;
        let icon = button.querySelector('i');
        let form = this.previousElementSibling;
        let value = form.previousElementSibling;

        // change le crayon en croix
        icon.classList.toggle('fa-times');
        icon.classList.toggle('fa-pencil');
        // montre ou cache le formulaire correspondant.
        form.classList.toggle("hidden");
        value.classList.toggle("hidden");


    }

}

function init() {
    let display = new userProfileDisplay();
}