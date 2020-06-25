<?php
 if(isset($_POST['id']))
{
    $table_name=$wpdb->prefix . 'message';
    $contacts=$wpdb->get_results('SELECT * FROM '.$table_name.' WHERE id='.$_POST['id']); ?>
    <p>Date : <?= $contacts[0]->date_msg ?></p>
    <p>Envoyé par : <?= $contacts[0]->first_name ?>  <?= $contacts[0]->last_name ?></p>
    <p>Adresse mail: <?= $contacts[0]->mail ?></p>
    <p>Contenu du message: <?= $contacts[0]->msg ?></p>
<?php } ?>