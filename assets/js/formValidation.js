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

        if (!selectedFields) {
            inspectedFields = this.fields;
        } else {
            inspectedFields = selectedFields;
        }

        let emptyFieldDetected = false;

        inspectedFields.forEach(field => {

            if (field.value == "") {
                emptyFieldDetected = true;

                field.style.borderColor = 'red';
                field.style.borderStyle = 'solid';
                field.style.borderWidth = 1;


            }

        });

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
        }
    }
}

function runValidation(e) {
    e.preventDefault();

    let validator = new FormValidator();
    validator.setTargetsForm(e.target);
    let validation = validator.emptyFieldValidator();

    if (validation) {
        e.target.submit();
    }


}

function init() {
    let form = document.querySelector('form');
    form.addEventListener('submit', runValidation.bind(this));

}

document.addEventListener('DOMContentLoaded', init);
