<?php
require ('connect.php');

require('./Controllers/unorderedSentencesController.php');


$result = correctUnorderedSentences();

?>

<h1>Correction</h1>

<table>
    <thead>
        <tr>
            <td>Votre réponse</td>
            <td>Correction</td>
            <td>Résultat</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result['correction'] as $sentence ) : ?>

            <tr class="<?php if ( $sentence['rating'] == 'Faux' )
                                {
                                    echo 'failure';
                                }
                                ?>">
                <td><?= $sentence['userAnswer'] ?></td>
                <td><?= $sentence['correctAnswer'] ?></td>
                <td><?= $sentence['rating'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="note">
    Note : <?= $result['note'] ?>
</div>