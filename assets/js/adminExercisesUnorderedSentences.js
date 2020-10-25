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
    document.querySelector('.cancelButton').addEventListener('click', cancelLastAction);
}
function saveEveryChanges () {

    let deletionList = JSON.parse(localStorage.getItem('exerciseDelete'));
    let changeList = JSON.parse(localStorage.getItem('exerciseChanges'));


    if(deletionList)
    {
        for (let el of deletionList)
        {

            /* POST attendu :
            $exerciseId = $post['exerciseId'];
            $databaseTable = $post['exerciseName'];
             */
            let formData = new FormData;
            formData.append('exerciseId', el.exerciseId);
            formData.append('exerciseName', el.exerciseName);

            let ajaxRequest = new XMLHttpRequest();

            ajaxRequest.open('POST', '../3WA-projetFin/Controllers/AdminDeleteExerciseController.php');

            ajaxRequest.send(formData);

            localStorage.removeItem('exerciseDelete');



        }



    }

    if (changeList)
    {
        for (let el of changeList)
        {
            /*
            POST attendu :
            $databaseTable = $post['exerciseName'];
            $newValue = $post['exerciseContent'];
            $exerciseId = $post['exerciseId'];
            */

            let formData = new FormData;

            formData.append('exerciseName', el.exerciseName);
            formData.append('exerciseContent', el.sentence);
            formData.append('exerciseId', el.exerciseId);

            let ajaxRequest = new XMLHttpRequest();


            ajaxRequest.open('POST', '../3WA-projetFin/Controllers/AdminUpdateExerciseSaveController.php');
            ajaxRequest.send(formData);


        }

        localStorage.removeItem('exerciseChanges');
    }



}





function eventListenerSetter () {
    let updaterForms = document.querySelectorAll('form[action = "./controllers/adminUpdateExercise.phtml"]');

    //rajouter bouton pr sauvegarder les changements


    updaterForms.forEach(form => {
        form.addEventListener('submit', setUpdateFormSelectedField);
    });

    let deleterForms = document.querySelectorAll('form[action = "./controllers/AdminDeleteExerciseController.php"]');

    //rajouter bouton pr sauvegarder les changements


    deleterForms.forEach(form => {
        form.addEventListener('submit', deleteSelectedField);
    })
}

function setUpdateFormSelectedField (e) {
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
    temporaryForm.action = './Controllers/AdminUpdateExerciseSaveController.php';
    temporaryForm.method = 'post';

    let temporaryInput = document.createElement('input');
    temporaryInput.value = sentenceText;
    temporaryInput.name = 'exerciseContent';

    let temporaryId = document.createElement('input');
    temporaryId.type = "hidden";
    temporaryId.value = exerciseId;
    temporaryId.name = 'exerciseId';

    let temporaryOriginalSentence = document.createElement('input');
    temporaryOriginalSentence.type = "hidden";
    temporaryOriginalSentence.value = sentenceText;
    temporaryOriginalSentence.name = 'originalSentence';

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
    temporaryForm.appendChild(temporaryOriginalSentence);
    temporaryForm.appendChild(submitButton);

    temporaryForm.addEventListener('submit', updateSelectedField);
}

function updateSelectedField (e) {
    e.preventDefault();

    let newValue = this.querySelector('input[name="exerciseContent"]').value;
    let id = this.querySelector('input[name="exerciseId"]').value;
    let name = this.querySelector('input[name="exerciseName"]').value;
    let originalSentence = this.querySelector('input[name="originalSentence"]').value;

    let changes = {
        'exerciseName': name,
        'exerciseId': id,
        'sentence': newValue,
        'originalSentence': originalSentence
    };

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


    updateActionHistory('changes');

    refreshFromLocalStorage();
}


function deleteSelectedField (e) {
    e.preventDefault();

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
        let existingDelete = JSON.parse(localStorage.getItem('exerciseDelete'));

        existingDelete.push(toDelete);

        localStorage.setItem('exerciseDelete', JSON.stringify(existingDelete));

    }

    updateActionHistory('delete');

    refreshFromLocalStorage();
}


function refreshFromLocalStorage () {
    let deletionList = JSON.parse(localStorage.getItem('exerciseDelete'));
    let changeList = JSON.parse(localStorage.getItem('exerciseChanges'));

    let idCells = document.querySelectorAll('.exerciseId');

    for (let cell of idCells) {
        cell.parentElement.style.display = "table-row";
        if(deletionList)
        {
            for ( let el of deletionList)
            {
                if(cell.innerHTML == el.exerciseId)
                {
                    cell.parentElement.style.display = "none";
                }
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



function updateActionHistory(actionType) {
    if(!localStorage.getItem('actionHistory'))
    {
        localStorage.setItem('actionHistory', JSON.stringify([actionType]));


    }
    else
    {
        let existingHistory = JSON.parse(localStorage.getItem('actionHistory'));

        existingHistory.push(actionType);

        localStorage.setItem('actionHistory', JSON.stringify(existingHistory));

    }
}

function cancelLastAction () {

    let history = JSON.parse(localStorage.getItem('actionHistory'));

    if(!history){
        return;
    }

    let deleteList = JSON.parse(localStorage.getItem('exerciseDelete'));
    let updateList = JSON.parse(localStorage.getItem('exerciseChanges'));
    let lastAction = history[history.length-1];

    if (lastAction == 'changes' && updateList) {
        let lastCancel = updateList.pop();
        history.pop();
        localStorage.setItem('exerciseChanges', JSON.stringify(updateList));

        let restoreId = lastCancel.exerciseId;
        let restoreSentence = lastCancel.originalSentence;
        let restoreSentenceCell;

        let idCells = document.querySelectorAll('.exerciseId');

        for (let idCell of idCells) {
            if (idCell.innerHTML == restoreId) {
                restoreSentenceCell = idCell.parentElement.querySelector('.exerciseSentence');
                break;
            }
        }

        restoreSentenceCell.innerHTML = restoreSentence;

    }


    if (lastAction == 'delete' && deleteList) {
        deleteList.pop();
        history.pop();
        localStorage.setItem('exerciseDelete', JSON.stringify(deleteList));
        refreshFromLocalStorage();

    }
    localStorage.setItem('actionHistory', JSON.stringify(history));





}