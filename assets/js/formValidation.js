'use strict';


class FormValidator {
    constructor() {
        this.form;
        this.fields;
    }

    setTargetsForm(target) {
        this.form = target;
        this.fields = this.form.querySelectorAll('input');
    }

    emptyFieldValidator(selectedFields) {

        let inspectedFields;
        // si pas de champ spécifié en paramètre, les champs sont ceux du formulaire entier.
        if (!selectedFields) {
            inspectedFields = this.fields;
        } else {
            inspectedFields = selectedFields;
        }

        // booleen permettant de vérifier que tous les champs sont remplis.
        let emptyFieldDetected = false;

        // pour chaque champ, s'il est est vide, rien ne change, sinon la bordure est rouge.
        // la variable emptyFieldDetected passe en true
        inspectedFields.forEach(field => {
            if (field.value == "") {
                emptyFieldDetected = true;

                field.style.borderColor = 'red';
                field.style.borderStyle = 'solid';
                field.style.borderWidth = 1;
            }
        });

        // si un champ ou plus est vide, une alert est envoyée à l'utilisateur et une confimation.
        // la fonction retourne la valeur de la confirmation.
        if (emptyFieldDetected) {
            alert(
                'Un ou plusieurs champs n\'ont pas été remplis.' +
                'Pour rappel, un réponse manquante ou un erreur ne retirent pas de point, mais n\'en rapporte aucun...'
            );
            if (confirm('Voulez-vous tout de même continuer?')) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
}

function runValidation(e) {
    e.preventDefault();

    let validator = new FormValidator();
    validator.setTargetsForm(e.target);
    let validation = validator.emptyFieldValidator();
    // si la validation est correcte : on soumet le formulaire au php
    if (validation === true) {
        e.target.submit();
    }


}

function init() {
    let form = document.querySelector('form');
    form.addEventListener('submit', runValidation.bind(this));

}

document.addEventListener('DOMContentLoaded', init);
