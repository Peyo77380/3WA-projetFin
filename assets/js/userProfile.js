'use strict';

document.addEventListener('DOMContentLoaded', init);


class userProfileDisplay {
    constructor() {
        //<button><i class="fa fa-pencil"></i></button>

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
        console.log(this);
        let button = this;
        let icon = button.querySelector('i');
        let form = this.previousElementSibling;

        // change le crayon en croix
        icon.classList.toggle('fa-times');
        icon.classList.toggle('fa-pencil');
        // montre ou cache le formulaire correspondant.
        form.classList.toggle("hidden");


    }

}

function init() {
    let display = new userProfileDisplay();
}