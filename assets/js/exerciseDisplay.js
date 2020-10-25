'use strict';

document.addEventListener('DOMContentLoaded', () => {
    let display = new ExerciseDisplay();
});


class ExerciseDisplay {


    constructor() {
        this._exerciseQuestions = document.querySelectorAll('fieldset.exercise_question');
        this._navigationControl = document.createElement('div');
        document.querySelector('.wrapper').appendChild(this._navigationControl);

        this.setNavigationButtons();
        this.hideSubmit();
        this.hideQuestions();
        this.questionIndex = 0;
        this.displayQuestion(this.questionIndex);

    }

    setNavigationButtons() {
        //ajouter boutons navigation
        let previousButton = document.createElement('button');
        previousButton.value = 'previous';
        previousButton.innerHTML = 'Précédent';
        previousButton.addEventListener('click', this.showPreviousQuestion.bind(this));

        previousButton.classList.add('gameControl');
        let nextButton = document.createElement('button');
        nextButton.value = 'next';
        nextButton.innerHTML = 'Suivant';
        nextButton.classList.add('gameControl');
        nextButton.addEventListener('click', this.showNextQuestion.bind(this));

        this._navigationControl.appendChild(previousButton);
        this._navigationControl.appendChild(nextButton);
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
        this._exerciseQuestions[index].classList.remove('exercise_question-hidden');
    }

    hideQuestions() {
        //rendre les questions invisibles sauf la premiere
        for (let question of this._exerciseQuestions) {
            question.classList.add('exercise_question-hidden');
        }
    }

    showPreviousQuestion() {
        if (this.questionIndex === 0) {
            return;
        }

        this.questionIndex--;

        this.hideQuestions();
        this.displayQuestion(this.questionIndex);
        this.hideSubmit();

    }

    showNextQuestion() {
        this.questionIndex++;

        if (this.questionIndex === this._exerciseQuestions.length) {
            this.hideQuestions();
            this.showSubmit();
            return;

        }

        this.hideQuestions();
        this.displayQuestion(this.questionIndex);

    }


}

