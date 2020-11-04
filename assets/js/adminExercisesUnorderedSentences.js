"use strict";

document.addEventListener('DOMContentLoaded', init);

function init() {

    eventListenerSetter();
    setControls();
    refreshFromLocalStorage();
}


// rajoute les controles visibles seulement avec le JS activé
function setControls() {
    let table = document.querySelector('table');

    let div = document.createElement('div');
    div.classList.add('controls');
    div.innerHTML =
        '<button class="cancelButton">Annuler la dernière action</button>';
    div.innerHTML +=
        '<button class="saveButton">Sauvegarder les changements</button>';

    table.parentElement.insertBefore(div, table);

    document.querySelector('.saveButton').addEventListener('click', saveEveryChanges);
    document.querySelector('.cancelButton').addEventListener('click', cancelLastAction);
}


// sauvegarde toutes les actions stockées dans le localStorage
function saveEveryChanges() {

    let deletionList = JSON.parse(localStorage.getItem('UnorderedSentencesExerciseDelete'));
    let changeList = JSON.parse(localStorage.getItem('UnorderedSentencesExerciseChanges'));

    //gère les suppressions dans le localStorage
    if (deletionList) {
        for (let el of deletionList) {

            let formData = new FormData;
            formData.append('exerciseId', el.exerciseId);
            formData.append('exerciseName', el.exerciseName);

            let ajaxRequest = new XMLHttpRequest();

            ajaxRequest.open('POST', 'AdminDeleteExercise');
            ajaxRequest.send(formData);

            localStorage.removeItem('UnorderedSentencesExerciseDelete');

        }

    }

    //gère les updates dans le localStorage
    if (changeList) {
        for (let el of changeList) {
            let formData = new FormData;

            formData.append('exerciseName', el.exerciseName);
            formData.append('sentence', el.sentence);
            formData.append('exerciseId', el.exerciseId);

            let ajaxRequest = new XMLHttpRequest();

            ajaxRequest.open('POST', 'AdminUpdateExerciseSave');
            ajaxRequest.send(formData);
        }
        localStorage.removeItem('UnorderedSentencesExerciseChanges');
    }


    localStorage.removeItem('UnorderedSentencesActionHistory');
}


function eventListenerSetter() {
    //rajouter bouton pr sauvegarder les changements
    let updaterForms = document.querySelectorAll('form[action = "adminUpdateExercise"]');

    updaterForms.forEach(form => {
        form.addEventListener('submit', setUpdateFormSelectedField);
    });

    //rajouter bouton pr sauvegarder les changements
    let deleterForms = document.querySelectorAll('form[action = "adminDeleteExercise"]');

    deleterForms.forEach(form => {
        form.addEventListener('submit', deleteSelectedField);
    });
}

// affiche les formulaires permettant de modifier les exercices existants
function setUpdateFormSelectedField(e) {
    e.preventDefault();

    // récupère la cellule qui contient l'énoncé de l'exercice
    let sentenceCell = this.parentElement.parentElement.querySelector('.exerciseSentence');

    if (sentenceCell.children.length != 0) {
        return;
    }

    // récupère les infos du formulaire déjà mis en place dans le html (type= hidden)
    let exerciseId = this.children['exerciseId'].value;
    let exerciseName = this.children['exerciseName'].value;
    let sentenceText = sentenceCell.innerHTML;

    //créer les éléments html nécessaires
    let temporaryForm = document.createElement('form');
    temporaryForm.action = 'AdminUpdateExerciseSave';
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

//sauvegarde les réponses des formulaires de modification dans le localStorage, pour enregistrement plus tard en DB.
function updateSelectedField(e) {
    e.preventDefault();

    // récupère les infos
    let newValue = this.querySelector('input[name="exerciseContent"]').value;
    let id = this.querySelector('input[name="exerciseId"]').value;
    let name = this.querySelector('input[name="exerciseName"]').value;
    let originalSentence = this.querySelector('input[name="originalSentence"]').value;

    //prépare un objet contenant les changements et les infos nécessaires pour l'update de la DB
    let changes = {
        'exerciseName': name,
        'exerciseId': id,
        'sentence': newValue,
        'originalSentence': originalSentence
    };

    // stocke l'objet en JSON dans le local storage dans une liste dédiée aux changement (différent des suppressions)
    // si cette liste n'existe pas déjà dans le local storage, elle est créée, sinon, l'objet est rajouté dans la version existante.
    if (!localStorage.getItem('UnorderedSentencesExerciseChanges')) {
        localStorage.setItem('UnorderedSentencesExerciseChanges', JSON.stringify([changes]));
    } else {
        let existingChanges = JSON.parse(localStorage.getItem('UnorderedSentencesExerciseChanges'));
        existingChanges.push(changes);
        localStorage.setItem('UnorderedSentencesExerciseChanges', JSON.stringify(existingChanges));

    }

    // permet de stocker le type de la dernière action pour l'historique des actions (annulation)
    updateActionHistory('changes');
    //affichage des changements en fonction du local storage
    refreshFromLocalStorage();
}

//sauvegarde les infos sur les phrases à supprimer dans le localStorage, pour enregistrement plus tard en DB.
function deleteSelectedField(e) {
    e.preventDefault();

    // récupère les infos
    let id = this.querySelector('input[name="exerciseId"]').value;
    let name = this.querySelector('input[name="exerciseName"]').value;

    //prépare un objet contenant les infos nécessaires pour la suppression en DB
    let toDelete = {
        'exerciseName': name,
        'exerciseId': id
    };

    // stocke l'objet en JSON dans le local storage dans une liste dédiée aux suppressions (différent des updates)
    // si cette liste n'existe pas déjà dans le local storage, elle est créée, sinon, l'objet est rajouté dans la version existante.
    if (!localStorage.getItem('UnorderedSentencesExerciseDelete')) {
        localStorage.setItem('UnorderedSentencesExerciseDelete', JSON.stringify([toDelete]));
    } else {
        let existingDelete = JSON.parse(localStorage.getItem('UnorderedSentencesExerciseDelete'));
        existingDelete.push(toDelete);
        localStorage.setItem('UnorderedSentencesExerciseDelete', JSON.stringify(existingDelete));
    }

    // permet de stocker le type de la dernière action pour l'historique des actions (annulation)
    updateActionHistory('delete');
    //affichage des changements en fonction du local storage
    refreshFromLocalStorage();
}

// modifie le html modifié en fonction du local storage, en attendant la mise a jour de la DB
function refreshFromLocalStorage() {
    // récupère les infos concernant les exercices à supprimer ou à modifier dans le local storage
    // (objets préparés par deleteSelectedField et updateSelectedField)
    let deletionList = JSON.parse(localStorage.getItem('UnorderedSentencesExerciseDelete'));
    let changeList = JSON.parse(localStorage.getItem('UnorderedSentencesExerciseChanges'));

    // crée la liste des id affichés dans le HTML AVANT modification
    let idCells = document.querySelectorAll('.exerciseId');

    // vérifie chaque exercice, en fonction de l'id de l'exercice et
    // de l'id des modifications ou suppressions stockées dans le localStorage
    // si l'ID d'un exercice est contenu dans une des deux listes, les modifications sont apportées.
    for (let cell of idCells) {
        cell.parentElement.style.display = "table-row";
        //vérif des ID des suppressions stockées en localStorage
        if (deletionList) {
            for (let el of deletionList) {
                if (cell.innerHTML == el.exerciseId) {
                    cell.parentElement.style.display = "none";
                }
            }
        }
        //vérif des ID des updates stockées en localStorage
        if (changeList) {
            for (let el of changeList) {
                if (cell.innerHTML == el.exerciseId) {
                    let row = cell.parentElement;
                    row.querySelector('.exerciseSentence').innerHTML = el.sentence;
                }
            }
        }
    }
}


function updateActionHistory(actionType) {
    // permet de stocker le type de la dernière action effectuée en localStorage
    // pour l'historique des actions et leur annulation

    // si le localStorage ne contient pas l'item actionHistory, il est créé,
    // sinon la nouvelle valeur est rajoutée à la fin de l'item existant, en JSON
    if (!localStorage.getItem('UnorderedSentencesActionHistory')) {
        localStorage.setItem('UnorderedSentencesActionHistory', JSON.stringify([actionType]));
    } else {
        let existingHistory = JSON.parse(localStorage.getItem('UnorderedSentencesActionHistory'));

        existingHistory.push(actionType);

        localStorage.setItem('UnorderedSentencesActionHistory', JSON.stringify(existingHistory));

    }
}

function cancelLastAction() {
    // permet d'annuler les actions de la plus récente à la plus ancienne
    // (jusqu'à la dernière sauvegarde ou suppression manuelle du localstorage)

    // récupère dans le localStorage la liste des actions effectuées
    let history = JSON.parse(localStorage.getItem('UnorderedSentencesActionHistory'));

    if (!history) {
        return;
    }

    // récupère les listes dédiées à chaque type d'action dans le localStorage
    let deleteList = JSON.parse(localStorage.getItem('UnorderedSentencesExerciseDelete'));
    let updateList = JSON.parse(localStorage.getItem('UnorderedSentencesExerciseChanges'));

    // récupère le type de la dernière action
    let lastAction = history[history.length - 1];

    // affiche les éléments tels qu'ils étaient avant la modification en cas de changement :
    // supprime l'objet concernant l'action dans le localStorage
    // remplace le HTML de la cellule faisant apparaitre l'exercice
    if (lastAction == 'changes' && updateList) {
        let lastCancel = updateList.pop();
        history.pop();
        localStorage.setItem('UnorderedSentencesExerciseChanges', JSON.stringify(updateList));

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


    // affiche les éléments tels qu'ils étaient avant la modification en cas de changement :
    // supprime l'objet concernant l'action dans le localStorage
    // refresh permet de parcourir les suppressions automatiquement.
    if (lastAction == 'delete' && deleteList) {
        deleteList.pop();
        history.pop();
        localStorage.setItem('UnorderedSentencesExerciseDelete', JSON.stringify(deleteList));
        refreshFromLocalStorage();

    }

    // stockes la nouvelle liste d'actions dans le localStorage
    localStorage.setItem('UnorderedSentencesActionHistory', JSON.stringify(history));

}