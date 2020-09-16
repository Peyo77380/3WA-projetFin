"use strict";

document.addEventListener('DOMContentLoaded', init);

function init () {
    console.log('ok');
    eventListenerSetter();
    setControls();
    refreshFromLocalStorage();
}

function setControls () {
    let table = document.querySelector('table');

    let div = document.createElement('div');

    div.innerHTML =
        '<button class="cancelButton">Annuler la dernière action</button>';
    div.innerHTML +=
        '<button class="saveButton">Sauvegarder les changements</button>';

    table.parentElement.insertBefore(div, table);

    document.querySelector('.saveButton').addEventListener('click', saveEveryChanges);
}
function saveEveryChanges () {
    console.log('saving');
    let deletionList = JSON.parse(localStorage.getItem('exerciseDelete'));
    let changeList = JSON.parse(localStorage.getItem('exerciseChanges'));


    if(deletionList)
    {
        for (let el of deletionList)
        {

            /*
            $exerciseId = $post['exerciseId'];
$databaseTable = $post['exerciseName'];
             */
            let params = {
                'exerciseId': el.exerciseId,
                'exerciseName': el.exerciseName,
            };

            let ajaxRequest = new XMLHttpRequest();

            ajaxRequest.open('POST', '../Controllers/adminDeleteExercise.php');
            ajaxRequest.setRequestHeader('Content-type', 'application/json');
            ajaxRequest.send(JSON.stringify(params));

            ajaxRequest.onload = function () {
                alert('ok');
            }
            console.log(params);
        }

        localStorage.removeItem('exerciseDelete');

    }
/*
    if (changeList)
    {

    }

*/

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

    let sentenceCell = this.parentElement.parentElement.querySelector('.exerciseSentence');

    if (sentenceCell.children.length != 0)
    {
        return;
    }

    let exerciseId = this.children['exerciseId'].value;
    let exerciseName = this.children['exerciseName'].value;
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


    refreshFromLocalStorage();
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



    refreshFromLocalStorage();
}


function refreshFromLocalStorage () {
    let deletionList = JSON.parse(localStorage.getItem('exerciseDelete'));
    let changeList = JSON.parse(localStorage.getItem('exerciseChanges'));

    let idCells = document.querySelectorAll('.exerciseId');

    for (let cell of idCells) {

        if(deletionList)
        {
            for ( let el of deletionList)
            {
                if(cell.innerHTML == el.exerciseId)
                {
                    cell.parentElement.style.display = "none";
                };
            }
        }

        if (changeList)
        {
            for (let el of changeList)
            {
                if(cell.innerHTML == el.exerciseId)
                {
                    let row = cell.parentElement;
                    row.querySelector('.exerciseSentence').innerHTML = el.sentence;
                }
            }
        }

    }


}
