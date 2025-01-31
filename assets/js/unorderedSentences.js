'use strict';

// permet l'affichage de la partie élève des phrases déstructurées
function init () {

	let exercise = new UnorderedSentencesExam();

}

document.addEventListener('DOMContentLoaded', init);

class UnorderedSentencesExam {

	constructor () {
		// récupère tous les mots dans les boutons.
		this.buttons = document.querySelectorAll('.gameButton');
		// récupère les champs où s'affichent les réponses
		this.answerFields = document.querySelectorAll('.answer');

		for (let button of this.buttons) {
			button.addEventListener('click', this.updateOnClick.bind(this));
		}

		for (let answerField of this.answerFields) {
			answerField.addEventListener('keyup', this.updateOnKey.bind(this));
		}
	}

	updateOnKey (el) {
		// à l'ajout (ou suppression) de texte dans l'input par le clavier, l'utilisation de chaque mot est vérifiée
		let text = el.target.innerHTML;
		let relatedContainer = el.target.parentElement.parentElement;
		let relatedInput = relatedContainer.querySelector('.answer');
		this.resetHighlights(el);
		this.highlightUsedWord(el);
		this.deleteTrailingSpaces(el, relatedInput)
	}

	updateOnClick (el) {
		// à l'ajout (ou suppression) de texte dans l'input par clic sur un des mots, l'utilisation de chaque mot est vérifiée
		let text = el.target.innerHTML;
		let relatedContainer = el.target.parentElement.parentElement;
		let relatedInput = relatedContainer.querySelector('.answer');

		if (el.target.classList.contains('selected')) {
			this.deleteOnClick(el.target, relatedInput, text);
			this.deleteTrailingSpaces(el.target, relatedInput);
		} else {
			this.writeOnClick(el.target, relatedInput, text);
			this.deleteTrailingSpaces(el.target, relatedInput);
		}
	}

	// au clic : le mot est ajouté dans la réponse
	writeOnClick (element, relatedInput, text) {

		if (relatedInput.value != "") {
			relatedInput.value += " ";
		}

		relatedInput.value += text;

		element.classList.add('selected');
	}

	// au clic : le mot est supprimé de la réponse
	deleteOnClick (element, relatedInput, text) {

		let words = relatedInput.value.split(" ");

		for (let i = 0; i < words.length; i++) {
			if (words[i] === text) {
				words.splice(i, 1)
			}
		}

		relatedInput.value = words.join(' ');
		element.classList.remove('selected');
	}

	resetHighlights(el) {
		// l'utilisation de chaque mot verifié parmi les mots déjà dans l'input.
		// s'il est dans l'input, il apparait en vert
		let buttonsList = el.target.parentElement.querySelectorAll('.gameButton');
		for (let button of buttonsList) {
			if (button.classList.contains('selected')) {
				button.classList.remove('selected');
			}
		}
	}

	highlightUsedWord (el) {
		// à l'écriture d'un mot dans l'input, le bouton correspondant change de couleur
		let answer = el.target.value;
		let buttonsList = el.target.parentElement.querySelectorAll('.gameButton');

		let answerWords = answer.split(' ');
		let buttonsWords = [];

		for (let button of buttonsList) {
			buttonsWords.push(button.innerHTML);
		}

		let dictionnary = this.checkForRepetition(buttonsWords);
		let answerRepeat = this.checkForRepetition(answerWords);

		for (let i = 0; i < dictionnary.length; i++) {
			for (let j = 0; j < answerRepeat.length; j++) {
				if(dictionnary[i].name == answerRepeat[j].name) {

					for (let k = 0; k < answerRepeat[j].index.length; k++) {
						let classes = buttonsList[dictionnary[i].index[k]].classList;
						if (!classes.contains('selected')) {
							classes.add('selected');

						}
					}
				}
			}
		}

	}

	// si un mot apparait plusieurs fois dans les boutons, il y a un classement des boutons
	// pour que seulement un soit surligné si un seul est donné dans l'input, etc...
	checkForRepetition(array) {
		let possibilities = [];
		possibilities.push(this.createNewWord(array, 0));

		for (let i = 1; i < array.length; i++) {
			let existingWord = possibilities.find(element => element.name == array[i]);
			if (!existingWord) {
				possibilities.push(this.createNewWord(array, i));
			} else {
				let existingWordIndex = possibilities.indexOf(existingWord);
				possibilities[existingWordIndex].index.push(i);
			}
		}

		return possibilities;
	}


	createNewWord (array, index) {
		let word = {
			name: array[index],
			index: [index],
		};

		return word;
	}


	// evite les doubles espaces
	deleteTrailingSpaces (element, relatedInput) {

		let answer = relatedInput.value;
		answer = answer.split('  ');

		answer = answer.join(' ');

		relatedInput.value = answer;
	}
}
