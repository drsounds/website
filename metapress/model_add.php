<?php
global $wpdb;
$wpdb->show_errors();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $model = datapress_get_current_model();
    $model_id = $model;
    $model = $GLOBALS['models'][$model];
    $data = array();
    $st = array();
    foreach($model['fields'] as $f => $field) {
        $data[$f] = $_POST[$f];
        $st[] = '%s';
    }

    if (isset($_POST['row_id'])) {
        $wpdb->update($model_id, $data, array('id' => $_POST['row_id']), $st, array('%d'));
        header('location: /wp-admin/admin.php?page=' . $GLOBALS['app_namespace'] . '-' . $model_id);
        return;
    } else {

        $wpdb->insert($model_id, $data, $st);
        $id = $wpdb->insert_id;
        header('location: /wp-admin/admin.php?page=' . $GLOBALS['app_namespace'] . '-' . $model_id . "&id=" . $id);
    }
}
?><form method="POST" action="<?php echo $PHP_SELF?>"><div class="wrap"><?php




$model = datapress_get_current_model();?>
<input type="hidden" name="model" value="<?php echo $model?>">
<?php 
$model_id = $model;
$model = $GLOBALS['models'][$model];
$row_id = isset($_GET['id']) ? $_GET['id'] : '';
$row = array();
if (!empty($row_id)) {
    // Get current entry
    $rows = $wpdb->get_results("SELECT * FROM $model_id WHERE id = $row_id", ARRAY_A);
    $row = $rows[0];
?>
<input type="hidden" name="row_id" value="<?php echo $row_id?>">
<?php } ?><table><?php
foreach($model['fields'] as $field) {

// retrieve the existing value(s) for this meta field. This returns an array
 ?>
<tr class="form-field">
<th scope="row" valign="top"><label for="field_[<?php echo $field['id']?>]"><?php _e( $field['title'], 'metapress' ); ?></label></th>
<?php switch ($field['type']) {
case 'image':?>
    <td>
        <input type="hidden" class="input" name="field_[<?php echo $field['id']?>]" id="field_<?php echo $field['id']?>" value="<?php echo esc_attr( $row[$field['id']] ) ? esc_attr( $row[$field['id']] ) : ''; ?>">
        <input type="button" class="button" id="field_<?php echo $field['id']?>_image_button" value="Choose image"><br>
        <p class="description"><?php _e( $field['description'],'metapress' ); ?></p>
        <script>
            jQuery(document).ready(function($){

            // Instantiates the variable that holds the media library frame.
            var meta_image_frame;

            // Runs when the image button is clicked.
            $('#field_<?php echo $field["id"]?>_button').click(function(e) {

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
                    $('#field_<?php echo $field["id"]?>').val(media_attachment.url);
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
        <input class="form-input" type="<?php echo $field['type']?>" name="field_[<?php echo $field['id']?>]" id="field_<?php echo $field['id']?>" value="<?php echo esc_attr( $row[$field['id']] ) ? esc_attr( $row[$field['id']] ) : ''; ?>">
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