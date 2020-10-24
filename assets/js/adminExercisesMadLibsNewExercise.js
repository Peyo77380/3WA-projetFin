"use strict";

document.addEventListener('DOMContentLoaded', init);

function init () {
    console.log('ok');
    eventListenerSetter();
    setNewExerciseControls();

    refreshFromLocalStorage();
}

function eventListenerSetter() {

    let form = document.querySelector('form[action="Controllers/AdminAddExerciseController.php"]');
    let newTextArea = form.querySelector('textarea');

    let submitButton = document.getElementById('submitButton');

    form.addEventListener('submit', (e) => {
      e.preventDefault();
      formatForSaving();
      sendToDB();
    });

    newTextArea.addEventListener('dblclick', setGap);
}

function setNewExerciseControls () {
    let form = document.querySelector('form[action="Controllers/AdminAddExerciseController.php"]');
    let newTextArea = form.querySelector('textarea');
    let div = document.createElement('div');

    div.innerHTML =
        '<button class="setGap">Remplacer par un trou</button>';

    newTextArea.parentElement.insertBefore(div, newTextArea);

    document.querySelector('.setGap').addEventListener('click', (e) => {
        e.preventDefault();
        setGap();
        refreshNewExercise();
    });

    let list = document.createElement('div');

    list.innerHTML =
        '<h4>Liste des mots</h4>' +
        '<ul class="fillingWords"></ul>';

    form.insertAdjacentElement('beforeend', list);

}

function setGap () {
    let form = document.querySelector('form[action="Controllers/AdminAddExerciseController.php"]');
    let newTextArea = form.querySelector('textarea');
    console.log(newTextArea.selectionStart);
    console.log(newTextArea.selectionEnd);

    let text = newTextArea.value;

    let indexBeginning = newTextArea.selectionStart;
    let indexEnd = newTextArea.selectionEnd;
    let gapWord = {
        'word' : text.slice(indexBeginning, indexEnd),
        'indexBeginning' : indexBeginning,
        'indexEnd': indexEnd,
    };

    let replacementStars = "";

    for (let i=0; i<gapWord.word.length; i++){
        replacementStars += "*";
    }

    let newText = text.substr(0, indexBeginning) + replacementStars + text.substr(indexEnd, text.length);

    newTextArea.value = newText;

    if(localStorage.getItem('fillingWords')) {
        let existingWords = JSON.parse(localStorage.getItem('fillingWords'));
        existingWords.push(gapWord);
        localStorage.setItem('fillingWords', JSON.stringify(existingWords));
    } else {
        localStorage.setItem('fillingWords', JSON.stringify([gapWord]));
    }

    refreshFromLocalStorage();
}

function refreshFromLocalStorage (){
    if(localStorage.getItem('fillingWords')) {
        let list = document.querySelector('.fillingWords');
        console.log(list);
        list.innerHTML = "";
        let existingWords = JSON.parse(localStorage.getItem('fillingWords'));

        for (let i=0; i<existingWords.length; i++){

            let newLine = document.createElement('li');
            let content = existingWords[i].word;
            console.log(content);
            newLine.innerHTML = content;

            newLine.setAttribute('gapIndex', i);

            newLine.addEventListener('click', restoreWord);

            list.appendChild(newLine);
        }
    } 
    
}

function restoreWord () {
    let index = this.getAttribute('gapindex');

    console.log(index);

    let existingWords = JSON.parse(localStorage.getItem('fillingWords'));
    let wordToRestore = existingWords[index];

    let form = document.querySelector('form[action="Controllers/AdminAddExerciseController.php"]');
    let newTextArea = form.querySelector('textarea');

    let finalText =
        newTextArea.value.substr(0, wordToRestore.indexBeginning)
        + wordToRestore.word
        + newTextArea.value.substr(wordToRestore.indexEnd, newTextArea.value.length);

    existingWords.splice(index, 1);

    localStorage.setItem('fillingWords', JSON.stringify(existingWords));
    newTextArea.value = finalText;

    refreshFromLocalStorage();

}

function formatForSaving () {
    console.log(this);
    let form = document.querySelector('form[action="Controllers/AdminAddExerciseController.php"]');
    let newTextArea = form.querySelector('textarea');

    let remainingText = newTextArea.value;
    let piecesOfText = [];
    let formatedText = [];

    console.log(JSON.parse(localStorage.getItem('fillingWords')));

    if (JSON.parse(localStorage.getItem('fillingWords')) == null || JSON.parse(localStorage.getItem('fillingWords')) == undefined) {
        alert('NEIN');
        return;
    }


    let fillingWords = JSON.parse(localStorage.getItem('fillingWords'));


    if(fillingWords.length > 1){

        fillingWords.sort((a,b) => a.indexBeginning-b.indexBeginning);
    }
    for (let word of fillingWords){


        word.word = "**" + word.word + "**";

    }
    remainingText = remainingText.split("*");

    for (let i =0; i<remainingText.length; i++){
        if(remainingText[i] === "" && remainingText[i] === remainingText[i-1]){


        } else {
            piecesOfText.push(remainingText[i]);
        }

    }

    let fillingWordsCounter = 0;
    for (let i =0; i<piecesOfText.length; i++){
        if(piecesOfText[i] === ""){
            formatedText.push(fillingWords[fillingWordsCounter].word);
            fillingWordsCounter ++;

        } else {
            formatedText.push(piecesOfText[i]);
        }

    }

    console.log(formatedText);

    let exercise = {
        exerciseName: 'madLibs',
        exerciseContent: formatedText.join(''),
    };

    localStorage.setItem('formatedExercise', JSON.stringify(exercise));


}

function sendToDB () {


    let el = JSON.parse(localStorage.getItem('formatedExercise'));
    if (el == null) {
        return;
    }
    console.log(el);
    let formData = new FormData;

    formData.append('exerciseName', el.exerciseName);
    formData.append('newSentence', el.exerciseContent);


    let ajaxRequest = new XMLHttpRequest();


    ajaxRequest.open('POST', '../3WA-projetFin/Controllers/AdminAddExerciseController.php');
    let id = ajaxRequest.send(formData);

    console.log(id);
    localStorage.removeItem('fillingWords');
    localStorage.removeItem('formatedExercise');

    refreshFromLocalStorage();

}
