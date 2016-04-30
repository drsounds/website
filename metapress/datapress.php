<?php
/**
 * datapress.php for Wordpress
 ***/

function datapress_install() {
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    add_option( $app_prefix . "_db_version", "1.0" );
    global $wpdb;

    // Walk through the globals and create table for each model
    $models = $GLOBALS['models'];
    foreach($models as $m => $model) {
        $table_name = $wpdb->prefix . $m;

        $charset_collate = $wpdb->get_charset_collate(); 

        $fields = array();

        foreach($model['fields'] as $f => $field) {
            $_field = $f . " " . $field['type'];
            if ($field['primary_key']) {
                $_field .= " primary key auto_increment";
            } else if (empty($field['null'])) {
                $_field .= " not null";
            }
        }
        $fields = implode(', ', $fields);

        $sql = "CREATE TABLE $table_name ($fields) $charset_collate";

        dbDelta( $sql );
    }
}

function datapress_update_db_check() {
    $app_prefix = $GLOBALS['app_prefix'];
    global $datapress_db_version;
    if ( get_site_option( $app_prefix . '_db_version' ) != $jal_db_version ) {
        datapress_install();
    }
}

function datapress_plugin_menu() {
    add_options_page( $GLOBALS['app_title'] . ' Options', $GLOBALS['app_namespace'], 'manage_options', 'datapress_options' );
    $app_namespace = $GLOBALS['app_namespace'];
    $models = $GLOBALS['models'];
    foreach($models as $m => $model) {
        add_menu_page($model['title'], $model['title'], 'manage_options', $app_namespace . '-' . $m ,  'datapress_model_index');
        add_submenu_page( $app_namespace . '-' . $m, 'All ' . $model['title'], 'All ' . $model['title'], 'manage_options', $app_namespace . '-' . $m,  'datapress_model_index');
        add_submenu_page( $app_namespace . '-' . $m . '-add', 'Add ' . $model['title'], 'Add ' . $model['title'], 'manage_options',   $app_namespace . '-' . $m . '-add','datapress_model_add');
    }
}

function datapress_get_current_model() {
    $screen = get_current_screen();
    $base = $screen->base;
    $parts = explode('-', $base);
    return $parts[1];
}

function datapress_model_add() {
    global $wpdb;
    $row = array();
    $model_id = datapress_get_current_model();
    $wpdb->show_errors();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $model = datapress_get_current_model();
        $model_id = $model;
        $model = $GLOBALS['models'][$model];
        $table = $wpdb->prefix . $model_id;
        $data = array();
        $st = array();
        foreach($model['fields'] as $f => $field) {
            if ($f === 'id') {
                continue;
            }
            $data[$f] = $_POST[$f];
            $st[] = '%s';
        }


        if (isset($_POST['id'])) {
            $id = $_POST['id'];
           // die(var_dump($id));
            $rows = $wpdb->update($table, $data, array('id' => $id));
            // wp_redirect('/wp-admin/admin.php?page=' . $GLOBALS['app_namespace'] . '-' . $model_id);
            wp_redirect('/wp-admin/admin.php?page=' . $GLOBALS['app_namespace'] . '-' . $model_id . "-add&id=" . $id);
            return;
        } else {

            $wpdb->insert($table, $data, $st);
            $id = $wpdb->insert_id;

            // wp_redirect('/wp-admin/admin.php?page=' . $GLOBALS['app_namespace'] . '-' . $model_id . "&id=" . $id);
            wp_redirect('/wp-admin/admin.php?page=' . $GLOBALS['app_namespace'] . '-' . $model_id . "-add&id=" . $id);
        }
    }
    ?><form method="POST" action="?page=<?php echo $GLOBALS['app_namespace'] . '-' . $model_id ?>-add&amp;noheader=true"><div class="wrap"><?php

    


    ?><h1><?php echo $model['title']?></h1>
    <input type="hidden" name="model" value="<?php echo $model?>">
    <?php 
    $model = $GLOBALS['models'][$model_id];
    $row_id = isset($_GET['id']) ? $_GET['id'] : '';
    if (!empty($row_id)) {
        // Get current entry
        $table = $wpdb->prefix . $model_id;
        $sql = "SELECT * FROM $table WHERE id = $row_id";

        $row = $wpdb->get_row($sql, ARRAY_A);
        
    ?>
    <input type="hidden" name="id" value="<?php echo $row_id?>">
    <?php } ?><table><?php
    foreach($model['fields'] as $f => $field) {
        if ($f == 'id') {
            continue;
        }
    // retrieve the existing value(s) for this meta field. This returns an array
     ?>
    <tr class="form-field">
    <th scope="row" valign="top"><label for="<?php echo $f?>"><?php _e( $field['title'], 'metapress' ); ?></label></th>
    <?php switch ($field['type']) {
    case 'image':?>
        <td>
            <input type="hidden" class="input" name="<?php echo $f?>" id="field_<?php echo $f?>" value="<?php echo esc_attr( $row[$f] ) ? esc_attr( $row[$f] ) : ''; ?>">
            <input type="button" class="button" id="field_<?php echo $field['id']?>_image_button" value="Choose image"><br>
            <p class="description"><?php _e( $field['description'],'metapress' ); ?></p>
            <script>
                jQuery(document).ready(function($){

                // Instantiates the variable that holds the media library frame.
                var meta_image_frame;

                // Runs when the image button is clicked.
                $('#field_<?php echo $f?>_button').click(function(e) {

                    // Prevents the default action from occuring.
                    e.preventDefault();

                    // If the frame already exists, re-open it.
                    if ( meta_image_frame ) {
                        wp.media.editor.open();
                        return;
                    }

                    // Sets up the media library frame
                    meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
                        title: 'Title',
                        button: { text:  'text' },
                        library: { type: 'image' }
                    });

                    // Runs when an image is selected.
                    meta_image_frame.on('select', function(e){

                        // Grabs the attachment selection and creates a JSON representation of the model.
                        var media_attachment = meta_image_frame.state().get('selection').first().toJSON();

                        // Sends the attachment URL to our custom image input field.
                        $('#field_<?php echo $f?>').val(media_attachment.url);
                        alert(media_attachment.url);

                        return false;

                    });

                    // Opens the media library frame.
                    meta_image_frame.open();
                });
            });
            </script>
        </td>
    <?php break;
        default: ?>
        <td>
            <input class="form-input" type="<?php echo $field['type']?>" name="<?php echo $f?>" id="field_<?php echo $f?>" value="<?php echo esc_attr( $row[$f] ) ? esc_attr( $row[$f] ) : ''; ?>">
            <p class="description"><?php _e( 'Enter a value for this field','metapress' ); ?></p>
        </td>
    <?php break;
        } ?>        
    </tr>
<?php

    }
    ?></table></div>
    <button class="button button-primary" type="submit">Submit</button></form>
    <?php
}

function datapress_model_index() {
    global $wpdb;
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    $model = datapress_get_current_model();
    $model_id = $model;
    $model = $GLOBALS['models'][$model_id];

    $_fields = array();
    $fields = array();      
    ?>
    <h2><?php echo $model['title']?>s <a href="/wp-admin/admin.php?page=<?php echo $GLOBALS['app_namespace']?>-<?php echo $model_id?>-add" class="add-new-h2">Add New</a></h2>
    <table class="wp-list-table widefat fixed striped posts">
        <thead>
            <?php foreach($model['fields'] as $f => $field): $fields[] = $field; $_fields[] = $f; if ($f == 'id') continue;?>
            <th class="manage-column column-cb check-column">
                <?php echo $field['title']?>
            </th>
        <?php endforeach;?>
            <th class="wp-list-table widefat fixed striped posts">Edit</th>
        </thead>
        <tbody>
            <?php
            // Get data
            $_fields = implode(', ', $_fields);
            $table = $wpdb->prefix . $model_id;
            $rows = $wpdb->get_results("SELECT $_fields FROM $table ORDER BY id DESC", ARRAY_A);
            foreach($rows as $row):?>
            <tr class="iedit author-self level-0 post-1 type-post status-publish format-standard hentry category-uncategorized">
                <?php foreach($model['fields'] as $f => $field):
                if ($f == 'id') continue;
                ?>
                <td><?php echo $row[$f]?></td>
                <?php endforeach;?>
                <td class="iedit author-self level-0 post-1 type-post status-publish format-standard hentry category-uncategorized"><a class="button" href="?page=<?php echo $GLOBALS['app_namespace']?>-<?php echo $model_id?>-add&amp;id=<?php echo $row['id']?>">Edit</a></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table><?php
}   

function datapress_options() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
}

function datapress_init() {

    add_action( 'plugins_loaded', 'datapress_update_db_check' );

    add_action( 'admin_menu', 'datapress_plugin_menu' );
}
