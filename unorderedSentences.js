'use strict';

function init () {

	let buttons = document.querySelectorAll('.gameButton');

	for (let button of buttons) {
		button.addEventListener('click', updateOnClick);
	}

	let answerFields = document.querySelectorAll('.answer');

	for (let answerField of answerFields) {
		answerField.addEventListener('keyup', hightlightUsedWord);
	}
}

document.addEventListener('DOMContentLoaded', init);


function updateOnClick () {

	if (this.classList.contains('selected')) {
		deleteOnClick(this);
		deleteTrailingSpaces(this);
	} else {
		writeOnClick(this);
		deleteTrailingSpaces(this);
	}
}


// au clic : le mot est ajouté dans la réponse
function writeOnClick (element) {

	let text = element.innerHTML;
	let relatedContainer = element.parentElement.parentElement;
	let relatedInput = relatedContainer.querySelector('.answer');

	if (relatedInput.value != "") {
		relatedInput.value += " ";
	}

	relatedInput.value += text;

	element.classList.add('selected');

}
function deleteOnClick (element) {

	let text = element.innerHTML;
	let relatedContainer = element.parentElement.parentElement;
	let relatedInput = relatedContainer.querySelector('.answer');

	relatedInput.value = relatedInput.value.replace(text, "");

	element.classList.remove('selected');


}


// à l'écriture d'un mot dans l'input, le bouton correspondant change de couleur
function hightlightUsedWord () {

	let answer = this.value;
	let wordList = this.parentElement.querySelectorAll('.gameButton');

	for (let word of wordList) {
		if (answer.includes(word.innerHTML)) {
			word.classList.add('selected');
		} else {
			word.classList.remove('selected');
		}

	}

}

function deleteTrailingSpaces (element) {

	let relatedContainer = element.parentElement.parentElement;
	let relatedInput = relatedContainer.querySelector('.answer');

	let answer = relatedInput.value;
	console.log(answer);
	answer = answer.split('  ');
	console.log(answer);
	answer = answer.join(' ');
	console.log(answer);

	relatedInput.value = answer;
}