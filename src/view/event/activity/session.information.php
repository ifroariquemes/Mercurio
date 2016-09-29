<?= $activity->getDescription() ?>
<br><br>
<b>Sessões:</b><br>
<?php foreach ($activity->getSessions() as $session) : ?>
    <?= $session->getDateStr() ?> das <?= $session->getStart() ?> às <?= $session->getEnd() ?><br>
<?php endforeach; ?>
