"use strict";

document.addEventListener('DOMContentLoaded', init);

function init () {
    console.log('ok');
    eventListenerSetter();
}

function eventListenerSetter () {
    let updaterForms = document.querySelectorAll('form[action = "./controllers/adminUpdateExercise.phtml"]');

    //rajouter bouton pr sauvegarder les changements


    updaterForms.forEach(form => {
        form.addEventListener('submit', updateSelectedField);
    });

    let deleterForms = document.querySelectorAll('form[action = "./controllers/adminDeleteExercise.php"]');

    //rajouter bouton pr sauvegarder les changements


    deleterForms.forEach(form => {
        form.addEventListener('submit', deleteSelectedField);
    })
}

function updateSelectedField (e) {
    e.preventDefault();

    let exerciseId = this.children['exerciseId'].value;
    let exerciseName = this.children['exerciseName'].value;
    let sentenceCell = this.parentElement.parentElement.querySelector('.exerciseSentence');
    let sentenceText = sentenceCell.innerHTML;

    let temporaryForm = document.createElement('form');
    temporaryForm.action = './Controllers/adminUpdateExerciseSave.php';
    temporaryForm.method = 'post';

    let temporaryInput = document.createElement('input');
    temporaryInput.value = sentenceText;
    temporaryInput.name = 'exerciseContent';

    let temporaryId = document.createElement('input');
    temporaryId.type = "hidden";
    temporaryId.value = exerciseId;
    temporaryId.name = 'exerciseId';

    let temporaryName = document.createElement('input');
    temporaryName.type = "hidden";
    temporaryName.value = exerciseName;
    temporaryName.name = 'exerciseName';

    let submitButton = document.createElement('button');
    submitButton.innerHTML = "Valider";

    sentenceCell.innerHTML = "";
    sentenceCell.appendChild(temporaryForm);
    temporaryForm.appendChild(temporaryInput);
    temporaryForm.appendChild(temporaryId);
    temporaryForm.appendChild(temporaryName);
    temporaryForm.appendChild(submitButton);

    temporaryForm.addEventListener('submit', localStorageBuffer);
}

function localStorageBuffer (e) {
    e.preventDefault();

    let newValue = this.querySelector('input[name="exerciseContent"]').value;
    let id = this.querySelector('input[name="exerciseId"]').value;
    let name = this.querySelector('input[name="exerciseName"]').value;

    let changes = {
        'exerciseName': name,
        'exerciseId': id,
        'sentence': newValue
    }

    if(!localStorage.getItem('exerciseChanges'))
    {
       localStorage.setItem('exerciseChanges', JSON.stringify([changes]));
    }
    else
    {
        let existingChanges = JSON.parse(localStorage.getItem('exerciseChanges'));

        existingChanges.push(changes);

        localStorage.setItem('exerciseChanges', JSON.stringify(existingChanges));
    }

}


function deleteSelectedField (e) {
    e.preventDefault();
    console.log(this);

    let id = this.querySelector('input[name="exerciseId"]').value;
    let name = this.querySelector('input[name="exerciseName"]').value;

    let toDelete = {
        'exerciseName': name,
        'exerciseId': id
    };

    if(!localStorage.getItem('exerciseDelete'))
    {
        localStorage.setItem('exerciseDelete', JSON.stringify([toDelete]));
    }
    else
    {
        let existingDeletion = JSON.parse(localStorage.getItem('exerciseDelete'));

        existingDeletion.push(toDelete);

        localStorage.setItem('exerciseDelete', JSON.stringify(existingDeletion));
    }

}

