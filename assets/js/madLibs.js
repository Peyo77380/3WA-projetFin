'use strict';
document.addEventListener('DOMContentLoaded', init);

function init() {

    let exercise = new MadLibs;
    exercise.addEventListeners();
}

// permet de gérer la partie élève de l'exercice de texte à trous
class MadLibs {
    constructor() {
        // on récupère les formulaires affichés.
        this.madLibsExercise = document.querySelector("form[action='madLibsResult']");
        this.questions = this.getElements();

    }

    getElements() {
        // on délimite chaque question de la page et on stocke les éléments dans une liste.
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
        // chaque bouton contenant un mot a un eventListener qui déclenche la fonction pour ajouter ce mot au texte.
        // chaque input a un eventListener qui va permettre de retirer le mot inséré au double clic.
        // si un mot est utilisé dans un input, il change de couleur
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
        // on récupère le mot "cliqué"
        let word = e.target.innerHTML;

        // on cible l'énoncé (texte à trou) du même exercice.
        const targetForm = e.target.parentElement.parentElement.querySelector('.wording');

        // on récupère les inputs de l'énoncé
        const gaps = targetForm.querySelectorAll('input');

        // on remplace la value du premier input vide par le mot cliqué.
        for (let gap of gaps) {
            if (gap.value === "") {
                gap.value = word;
                break;
            }
        }

        this.checkForWordUse();
    }

    removeWordFromGap(e) {
        // supprime le texte de l'input par
        e.target.value = "";

        this.checkForWordUse();
    }

    checkForWordUse() {
        // passe tous les mots utilisés dans les inputs.
        // si un mot est utilisé, il devient vert (classe .selected)
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