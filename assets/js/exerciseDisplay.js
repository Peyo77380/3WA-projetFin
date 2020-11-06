'use strict';

document.addEventListener('DOMContentLoaded', () => {
    let display = new ExerciseDisplay();
});

// permet l'affichage de chaque question d'un exercice, au lieu de toutes les questions d'un coup,
// sans avoir besoin de soumettre un formulaire entre chaque question.
class ExerciseDisplay {


    constructor() {
        //récupère les différentes questions dans le html
        this._exerciseQuestions = document.querySelectorAll('fieldset.exercise_question');
        this.wrapper = document.querySelector('.fullscreen');

        this.setNavigationButtons();
        this.hideSubmit();
        this.hideQuestions();
        this.questionIndex = 0;
        this.displayQuestion(this.questionIndex);

    }

    setNavigationButtons() {
        //ajouter boutons navigation dans une zone dédiée.
        this._navigationControl = document.createElement('div');
        this._navigationControl.classList.add('gameControlBar');

        let previousButton = document.createElement('button');
        previousButton.value = 'previous';
        previousButton.innerHTML = 'Précédent';
        previousButton.addEventListener('click', this.showPreviousQuestion.bind(this));
        previousButton.classList.add('gameControl');
        previousButton.classList.add('hidden');
        
        let nextButton = document.createElement('button');
        nextButton.value = 'next';
        nextButton.innerHTML = 'Suivant';
        nextButton.classList.add('gameControl');
        nextButton.addEventListener('click', this.showNextQuestion.bind(this));

        this._navigationControl.appendChild(previousButton);
        this._navigationControl.appendChild(nextButton);

        this.wrapper.appendChild(this._navigationControl);
    }
    
    toggleButton(value) {
        let button = document.querySelector(`button[value=${value}]`);
        button.classList.toggle('hidden');
    }
    
    showButton(value){
        let button = document.querySelector(`button[value=${value}]`);
        button.classList.remove('hidden');
    }
    hideSubmit() {
        //rendre validation invisible
        let submitButton = document.querySelector('input[type="submit"]');

        submitButton.style.display = 'none';
    }

    showSubmit() {
        //rendre validation invisible
        let submitButton = document.querySelector('input[type="submit"]');

        submitButton.style.display = 'block';
    }

    displayQuestion(index) {
        this._exerciseQuestions[index].classList.remove('hidden');
    }

    hideQuestions() {
        //rendre les questions invisibles sauf la premiere
        for (let question of this._exerciseQuestions) {
            question.classList.add('hidden');
        }
    }

    showPreviousQuestion() {
        if (this.questionIndex === 0) {
            return;
        }

        this.questionIndex--;
        if (this.questionIndex === 0) {
            this.toggleButton('previous');
        }
        if (this.questionIndex < this._exerciseQuestions.length) {
            this.showButton('next');
        }
        this.hideQuestions();
        this.displayQuestion(this.questionIndex);
        this.hideSubmit();

    }

    showNextQuestion() {
        if (this.questionIndex === 0) {
            this.toggleButton('previous');
        }
        this.questionIndex++;

        if (this.questionIndex === this._exerciseQuestions.length) {
            this.hideQuestions();
            this.showSubmit();
            this.toggleButton('next');
            return;

        }

        this.hideQuestions();
        this.displayQuestion(this.questionIndex);

    }


}

