'use strict';
document.addEventListener('DOMContentLoaded', init);

function init() {

    let exercise = new MadLibs;
    exercise.addEventListeners();


}

class MadLibs {
    constructor() {
        this.madLibsExercise = document.querySelector("form[action='madLibsResult']");
        console.log(this.madLibsExercise);
        this.questions = this.getElements();

    }

    getElements() {
        let separatedExercises = this.madLibsExercise.querySelectorAll('fieldset');

        let questions = [];

        for (let question of separatedExercises) {

            question = {
                container: question,
                words: question.querySelectorAll('.word'),
                wording: question.querySelector('.wording'),
                inputs: question.querySelectorAll('input'),
            };

            questions.push(question);
        }

        return questions;

    }

    addEventListeners() {
        this.questions.forEach(question => {
            question.words.forEach(word => {
                word.addEventListener('click', this.addWordToGap.bind(this));
            });

            question.inputs.forEach(input => {
                input.addEventListener('dblclick', this.removeWordFromGap.bind(this));
                input.addEventListener('change', this.checkForWordUse.bind(this));
            });

        });


    }


    addWordToGap(e) {
        let word = e.target.innerHTML;
        const targetForm = e.target.parentElement.parentElement.querySelector('.wording');

        const gaps = targetForm.querySelectorAll('input');

        for (let gap of gaps) {
            if (gap.value === "") {
                gap.value = word;
                break;
            }
        }

        this.checkForWordUse();
    }

    removeWordFromGap(e) {
        e.target.value = "";

        this.checkForWordUse();
    }

    checkForWordUse() {
        this.questions.forEach(question => {
            question.words.forEach(word => {
                for (let input of question.inputs) {
                    if (input.value == word.innerHTML) {

                        word.classList.add('selected');
                        break;
                    } else {
                        word.classList.remove('selected');
                    }
                }
            });
        })
    }

}