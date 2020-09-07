'use strict';

function init () {

	let exercise = new UnorderedSentencesExam();

}

document.addEventListener('DOMContentLoaded', init);

class UnorderedSentencesExam {

	constructor () {

		this.buttons = document.querySelectorAll('.gameButton');

		this.answerFields = document.querySelectorAll('.answer');

		for (let button of this.buttons) {
			button.addEventListener('click', this.updateOnClick.bind(this));
		}

		for (let answerField of this.answerFields) {
			answerField.addEventListener('keyup', this.updateOnKey.bind(this));
		}
	}

	updateOnKey (el){

		let text = el.target.innerHTML;
		let relatedContainer = el.target.parentElement.parentElement;
		let relatedInput = relatedContainer.querySelector('.answer');

		this.hightlightUsedWord(el);
		this.deleteTrailingSpaces(el, relatedInput)
	}

	updateOnClick (el) {

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

	// à l'écriture d'un mot dans l'input, le bouton correspondant change de couleur
	hightlightUsedWord (el) {

		let answer = el.target.value;
		let buttonsList = el.target.parentElement.querySelectorAll('.gameButton');

		let answerWords = answer.split(' ');
		let buttonsWords = [];

		for (let button of buttonsList ) {
			buttonsWords.push(button.innerHTML);
		}


		let indexedButtonsWords = this.checkForRepetition(buttonsWords);





		console.log(indexedButtonsWords);

		// 		word.classList.add('selected');
		// 	} else {
		// 		word.classList.remove('selected');
		// 	}
		// }
	}

	checkForRepetition (array) {
		console.log(array);
		let rec = [];

		let iteration = {
					word : array[0],
					index : [0],
				}
		rec.push(iteration);

		// for (let i = 1; i < array.length; i ++) {
		// 	for (let word of rec){
		// 		if (array[i] === word.name) {
		// 			word.index.push(i);
		// 		} else {
		// 			iteration = {
		// 				word : array[i],
		// 				index : [i],
		// 			}

		// 			rec.push(iteration);
		// 		}
		// 	}
		// }

		// console.log(rec);
	}

	// evite les doubles espaces
	deleteTrailingSpaces (element, relatedInput) {

		let answer = relatedInput.value;
		answer = answer.split('  ');

		answer = answer.join(' ');

		relatedInput.value = answer;
	}
}
