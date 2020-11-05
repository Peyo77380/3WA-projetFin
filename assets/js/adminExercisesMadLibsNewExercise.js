"use strict";

document.addEventListener('DOMContentLoaded', init);

function eventListenerSetter() {
    // ajoute les events listeners sur le formulaire pour controler le submit,
    // et la fonction qui permet de fixer les mots manquants (setGap)
    let form = document.querySelector('form[action="adminAddExercise"]');
    let newTextArea = form.querySelector('textarea');

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        formatForSaving();
        sendToDB();
    });

    newTextArea.addEventListener('dblclick', setGap);
}

function setNewExerciseControls () {

    let form = document.querySelector('form[action="adminAddExercise"]');
    let newTextArea = form.querySelector('textarea');

    let div = document.createElement('div');
    // ajoute le bouton qui déclanche la fonction pour insérer les trous. et ajoute l'eventListener lié.
    div.innerHTML =
        '<button class="setGap">Remplacer par un trou</button>';

    newTextArea.parentElement.insertBefore(div, newTextArea);

    document.querySelector('.setGap').addEventListener('click', (e) => {
        e.preventDefault();
        setGap();
        refreshNewExercise();
    });

    // ajoute la liste des mots qui correspondent à un trou : cf fonction setGap
    let list = document.createElement('div');

    list.innerHTML =
        '<h4>Liste des mots</h4>' +
        '<ul class="fillingWords"></ul>';

    form.insertAdjacentElement('beforeend', list);

}

function setGap () {
    let form = document.querySelector('form[action="adminAddExercise"]');
    let newTextArea = form.querySelector('textarea');

    // récupère le texte rempli par l'utilisatur dans la zone de texte.
    let text = newTextArea.value;


    //détermine le début et la fin du mot selectionné (numéro de caractères dans la string)
    let indexBeginning = newTextArea.selectionStart;
    let indexEnd = newTextArea.selectionEnd;

    // stocke dans un objet le mot concerné par le trou, l'index de début et de fin.
    let gapWord = {
        'word': text.slice(indexBeginning, indexEnd),
        'indexBeginning': indexBeginning,
        'indexEnd': indexEnd,
    };

    // remplace le texte selectionné par des *, pour plus de lisibilité au moment de la mise en forme de l'exercice.
    let replacementStars = "";
    for (let i = 0; i < gapWord.word.length; i++) {
        replacementStars += "*";
    }

    // insère les étoiles dans le texte actuel, à la place du mot selectionné
    let newText = text.substr(0, indexBeginning) + replacementStars + text.substr(indexEnd, text.length);

    // remplace par le nouveau texte la valeur de la zone de texte
    newTextArea.value = newText;

    // stocke l'objet avec les infos sur le mot dans le local storage en attendant la sauvegarde.
    if(localStorage.getItem('fillingWords')) {
        let existingWords = JSON.parse(localStorage.getItem('fillingWords'));
        existingWords.push(gapWord);
        localStorage.setItem('fillingWords', JSON.stringify(existingWords));
    } else {
        localStorage.setItem('fillingWords', JSON.stringify([gapWord]));
    }

    refreshFromLocalStorage();
}

function refreshFromLocalStorage () {
    // si le local storage existe, contenant des infos sur un mot : il est récupéré
    // les infos stockées sont remplacées dans la liste des mots comme <li> (.fillingWords)
    if (localStorage.getItem('fillingWords')) {
        let list = document.querySelector('.fillingWords');
        list.innerHTML = "";
        let existingWords = JSON.parse(localStorage.getItem('fillingWords'));

        for (let i = 0; i < existingWords.length; i++) {

            let newLine = document.createElement('li');
            let content = existingWords[i].word;
            newLine.innerHTML = content;
            newLine.setAttribute('gapIndex', i);
            // eventListener : si clic, le mot est remis dans le texte initial
            newLine.addEventListener('click', restoreWord);

            list.appendChild(newLine);
        }
    } 
    
}

function restoreWord () {
    // restaure le mot qui fait l'objet d'un clic dans le texte initial de l'exercice

    // sur la liste de mots fixée par setGap, des eventListeners sont posés.
    // récupère l'index du mot dans le texte initial, par rapport au local storage.
    let index = this.getAttribute('gapindex');
    // récupère les infos du mot dans le localStorage en fonction de son index
    let existingWords = JSON.parse(localStorage.getItem('fillingWords'));
    let wordToRestore = existingWords[index];

    let form = document.querySelector('form[action="adminAddExercise"]');
    let newTextArea = form.querySelector('textarea');

    // reconstitue une string en fonction de la value du textarea, et du mot à réécrire dans le texte.
    let finalText =
        newTextArea.value.substr(0, wordToRestore.indexBeginning)
        + wordToRestore.word
        + newTextArea.value.substr(wordToRestore.indexEnd, newTextArea.value.length);

    newTextArea.value = finalText;

    // supprime le mot qui a été réécrit du localStorage
    existingWords.splice(index, 1);
    localStorage.setItem('fillingWords', JSON.stringify(existingWords));

    refreshFromLocalStorage();

}

function formatForSaving () {

    let form = document.querySelector('form[action="adminAddExercise"]');
    let newTextArea = form.querySelector('textarea');

    // récupère les infos contenues dans le textarea (texte et * qui masquent les mots des trous)
    let remainingText = newTextArea.value;
    let piecesOfText = [];
    // sert de stockage pour le texte final, comprenant les mots entre étoiles pour afficher les trous
    let formatedText = [];

    // s'il n'y a pas de localStorage comportant de mots à masquer, le texte à sauvegarder correspond à la value de la zone de texte
    // sinon il correspond à l'alternance de la value et des mots du localStorage
    if (JSON.parse(localStorage.getItem('fillingWords')) === null
        || JSON.parse(localStorage.getItem('fillingWords')) === undefined) {
        formatedText = remainingText;
    } else {
        // récupère le localStorage
        let fillingWords = JSON.parse(localStorage.getItem('fillingWords'));

        //tri du premier au dernier trou, dans l'ordre de lecture du texte
        if (fillingWords.length > 1) {
            fillingWords.sort((a, b) => a.indexBeginning - b.indexBeginning);
        }

        // le mot qui sera remplacé par un trou est indiqué entre ** pour être traité ensuite par le php au moment de l'affichage
        for (let word of fillingWords) {
            word.word = "**" + word.word + "**";
        }
        // le texte de la zone de texte est coupé à chaque zone remplacée par des * et la liste est nettoyée, pour éviter d'avoir de nombreuses * à la suite, mais seulement une
        remainingText = remainingText.split("*");
        for (let i = 0; i < remainingText.length; i++) {
            if (remainingText[i] === "" && remainingText[i] === remainingText[i - 1]) {
            } else {
                piecesOfText.push(remainingText[i]);
            }
        }

        // les étoiles sont remplacées par les mots, en se basant sur l'alternance des deux listes préparées
        let fillingWordsCounter = 0;
        for (let i = 0; i < piecesOfText.length; i++) {
            if (piecesOfText[i] === "") {
                formatedText.push(fillingWords[fillingWordsCounter].word);
                fillingWordsCounter++;
            } else {
                formatedText.push(piecesOfText[i]);
            }
        }

        // tous les éléments de la liste sont joints pour former une string
        formatedText = formatedText.join('');
    }

    // le nouvel exercice est sauvegardé en objet dans le localStorage qui sera ensuite envoyé en DB
    let exercise = {
        exerciseName: 'madLibs',
        exerciseContent: formatedText,
    };

    localStorage.setItem('formatedExercise', JSON.stringify(exercise));


}

function sendToDB () {
    // on récupère le localStorage comprenant le nouvel exercice
    let el = JSON.parse(localStorage.getItem('formatedExercise'));
    if (el == null) {
        return;
    }

    // on prépare l'envoi au controlleur php avec les éléments attendus.
    let formData = new FormData;
    formData.append('exerciseName', el.exerciseName);
    formData.append('newSentence', el.exerciseContent);

    // on envoie au cntrolleur
    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.open('POST', '/3WA-projetFin/AdminAddExercise');
    let id = ajaxRequest.send(formData);

    // on enlève les éléments maintenant inutiles du localStorage.
    localStorage.removeItem('fillingWords');
    localStorage.removeItem('formatedExercise');

    refreshFromLocalStorage();

}


function init() {

    eventListenerSetter();
    setNewExerciseControls();

    refreshFromLocalStorage();
}