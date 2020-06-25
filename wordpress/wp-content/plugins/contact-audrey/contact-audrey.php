<?php
/*
Plugin Name: contact-audrey
Plugin URI: http://wordpress.org/plugins/contact-audrey/
Description: This is a test
Author: Audrey
Version: 1.0
Author URI: http://ma.tt/
*/

add_action('admin_menu','menu_administration');
function menu_administration()
{
    add_menu_page('Audrey-contact','contact-Audrey','manage_options','contact-audrey','aff_contact');
}
wp_enqueue_style( 'bootstrap', plugins_url( 'assets/css/bootstrap.css', __FILE__ ) );
function aff_contact()
{
    global $wpdb;

    $table_name=$wpdb->prefix . 'message';
    $contacts=$wpdb->get_results('SELECT * FROM '.$table_name);


    if(isset($_POST['id']))
    {
        $table_name=$wpdb->prefix . 'message';
        $contacts=$wpdb->get_results('SELECT * FROM '.$table_name.' WHERE id='.$_POST['id']); ?>
        <table class="table table-secondary">
            <tr>
                <th>Date :</th>
                <td><span class="p-2 bg-secondary text-light"><?= date_format(date_create($contacts[0]->date_msg),'d-m-Y H:i:s') ?></span></td>
            </tr>
            <tr>
                <th>Envoyé par :</th>
                <td><span class="p-2 bg-secondary text-light"><?= $contacts[0]->first_name ?>  <?= $contacts[0]->last_name ?></span></td>
            </tr>
            <tr>
                <th>Adresse mail :</th>
                <td><span class="p-2 bg-secondary text-light"><?= $contacts[0]->mail ?></span></td>
            </tr>
            <tr>
                <th>Contenu du message :</th>
                <td><span class="p-2 bg-secondary text-light"><?= $contacts[0]->msg ?></span></td>
            </tr>
        </table>
        <a href="admin.php?page=contact-audrey" class="btn btn-dark">Retour</a>
<?php } else {?>
    <table class="table table-dark m-0">
        <tr class="text-center">
            <th>Date</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Message</th>
            <th>Voir +</th>
        </tr>
        <?php foreach ($contacts as $contact) { ?>
            <tr class="text-center table-secondary text-dark">
                <td><?= date_format(date_create($contacts[0]->date_msg),'d-m-Y H:i:s') ?></td>
                <td><?= $contact->first_name ?></td>
                <td><?= $contact->last_name ?></td>
                <td><?= $contact->mail ?></td>
                <td><?= $contact->msg ?></td>
                <td><form method="post" action="">
                        <input type="number" name="id" value="<?= $contact->id ?>" class="d-none">
                        <button type="submit" class="btn btn-dark" id="">Voir +</button>
                    </form>
                </td>
            </tr>
        <?php }  ?>
    </table>



<?php } }

function form_contact()
{

    if (isset($_POST['mail']))
    {
        global $wpdb;

        var_dump($_POST);
        $table_name = $wpdb->prefix . 'message';

        $wpdb->insert(
            $table_name,
            array(
                'first_name' => htmlspecialchars(trim($_POST['prenom'])),
                'last_name' => htmlspecialchars(trim($_POST['nom'])),
                'mail' => htmlspecialchars(trim($_POST['mail'])),
                'msg'=>htmlspecialchars(trim($_POST['message']))
            )
        );
    }

    ?>

    <div class="row justify-content-center">
        <h1 class="text-center titre mb-5">Contact</h1>
    </div>
    <div class="row m-auto">
        <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 d-flex flex-column">
            <form method="post" action="" id="form_contact">
                <div class="row">
                    <label for="nom">Nom :</label>
                    <input type="text" name="nom" id="nom" class="form-control" required="required"/>
                </div>
                <div class="row">
                    <label for="prenom">Prénom :</label>
                    <input type="text" name="prenom" id="prenom" class="form-control" required="required"/>
                </div>
                <div class="row">
                    <label for="mail">Mail :</label>
                    <input type="email" name="mail" id="mail" class="form-control" required="required"/>
                </div>
                <div class="row">
                    <label for="message">Message :</label>
                    <textarea id="message" name="message" class="form-control" required="required"></textarea>
                </div>
                <div class="row">
                    <button type="submit" class="btn btn-marron my-3" id="btn_contact">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
<?php }
        add_shortcode("contact",'form_contact');

function install () {
    global $wpdb;


    $table_name = $wpdb->prefix . 'message';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		date_msg datetime DEFAULT CURRENT_TIMESTAMP,
		first_name varchar(100) NOT NULL,
		last_name varchar(100) NOT NULL,
		mail varchar(100) NOT NULL,
		msg text NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

}
register_activation_hook( __FILE__, 'install' );

wp_deregister_script('jquery');
wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), 1.0, true);
wp_enqueue_script('contacJs',plugins_url('contact-audrey/assets/js/contact.js'),__FILE__);



