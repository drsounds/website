<?php

function metapress_customize_register( $wp_customize ) {
    foreach($GLOBALS['settings']['sections'] as $section_id => $section) {
        $wp_customize->add_section(
            $section_id,
            array(
              'title' => __( $section['title'], 'metapress' ),
              'priority' =>  100,
              'capability' => 'edit_theme_options',
              'description' => __($section['description'], 'metapress'),
            )
        );
        foreach($section['settings'] as $k => $setting) {

            $wp_customize->add_setting(
              $k,
              array(
                'default'   => $setting['default'],
                'transport' => 'postMessage'
              )
            );
            switch($setting['type']) {
            case "image":
                $wp_customize->add_control(
                    new WP_Customize_Image_Control(
                        $wp_customize,

                        $k,
                        array(
                            'label' => __($setting['title'], 'metapress'),
                            'section' => $section_id,
                       )
                    )
                );
                break;
            case "color":
                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize,

                        $k,
                        array(
                            'label' => __($setting['title'], 'metapress'),
                            'section' => $section_id,
                       )
                    )
                );
                break;
            default:

                $wp_customize->add_control(
                  $k,
                  array(
                      'label' => __($setting['title'], 'metapress'),
                      'section' => $section_id,
                 )
                );
                break;
            }
        }
    }
}

function metapress_init($post_types, $settings, $taxonomies) {
    $GLOBALS['post_types'] = $post_types;
    $GLOBALS['settings'] = $settings;
    $GLOBALS['taxonomies'] = $taxonomies;
    add_action('customize_save', 'metapress_customize_save_after', 100);
    foreach($GLOBALS['taxonomies'] as $k => $v) {
        add_action( $k . '_add_form_fields', 'metapress_taxonomy_add_new_meta_field', 10, 2 );
        add_action( $k . '_edit_form_fields', 'metapress_taxonomy_edit_meta_field', 10, 2 );
        add_action( 'save_' . $k, 'metapress_save_taxonomy_custom_meta', 10, 2 );  
        add_action( 'create_' . $k, 'metapress_save_taxonomy_custom_meta', 10, 2 );
    }
    add_action('customize_register', 'metapress_customize_register');
    add_action( 'init', 'metapress_register_my_menus' );
    add_action( 'save_post', 'metapress_save_meta_box_data' );
    add_action( 'add_meta_boxes', 'metapress_add_meta_boxes' );

}
/**
 * Generate new CSS:es from Less themes
 * */
function metapress_customize_save_after( $wp_customize ) {
   /* $lessc = new Less_Parser();
    $primary_color = get_theme_mod('primary_color');

        if (empty($primary_color)) {
            $primary_color = '#448f4d';
        }
        $file = get_template_directory() . DIRECTORY_SEPARATOR . 'less' . DIRECTORY_SEPARATOR . 'bootstrap.less';
        $lessc->parseFile($file);
        $lessc->ModifyVars(array('brand-primary', $primary_color));

        $css = $lessc->getCss();
        $file = get_template_directory() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'bootstrap.css';
        die($css);
        $fil = fopen($file, 'wb');
        fwrite($fil, $css);
        fclose($fil);
*/
    

}


// Add term page
function metapress_taxonomy_add_new_meta_field() {
 wp_enqueue_script( 'media-upload'); 
    // put the term ID into a variable
    $t_id = $term->term_id;
    $term = $term; // get term

    $taxonomy = $GLOBALS['taxonomies'][$term];
    $term_meta = get_option( "taxonomy_$t_id" );
    foreach($taxonomy['fields'] as $field) {

    // retrieve the existing value(s) for this meta field. This returns an array
     ?>
    <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta_[<?php echo $field['id']?>]"><?php _e( $field['title'], 'metapress' ); ?></label></th>
    <?php switch ($field['type']) {
    case 'image':?>
        <td>
            <input type="hidden" name="term_meta_[<?php echo $field['id']?>]" id="term_meta_<?php echo $field['id']?>" value="">
            <input type="button" class="button" id="term_meta_image_button" value="Choose image">
            <p class="description"><?php _e( $field['description'],'metapress' ); ?></p>
            <script>
                jQuery(document).ready(function($){

                // Instantiates the variable that holds the media library frame.
                var meta_image_frame;

                // Runs when the image button is clicked.
                $('#term_meta_<?php echo $field["id"]?>_button').click(function(e) {

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
                        $('#term_meta_<?php echo $field["id"]?>').val(media_attachment.url);
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
            <input type="<?php echo $field['type']?>" name="term_meta_[<?php echo $field['id']?>]" id="term_meta_<?php echo $field['id']?>" value="">
            <p class="description"><?php _e( 'Enter a value for this field','metapress' ); ?></p>
        </td>
    <?php break;
        } ?>        
    </tr>
<?php
    }
}


// Edit term page
function metapress_taxonomy_edit_meta_field($term) { 
    wp_enqueue_script( 'media-upload'); 
    // put the term ID into a variable
    $t_id = $term->term_id;
    $term = $term; // get term

    $taxonomy = $GLOBALS['taxonomies'][$term];
    $term_meta = get_option( "taxonomy_$t_id" );
    foreach($taxonomy['fields'] as $field) {

    // retrieve the existing value(s) for this meta field. This returns an array
     ?>
    <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta_[<?php echo $field['id']?>]"><?php _e( $field['title'], 'metapress' ); ?></label></th>
    <?php switch ($field['type']) {
    case 'image':?>
        <td>
            <input type="hidden" name="term_meta_[<?php echo $field['id']?>]" id="term_meta_<?php echo $field['id']?>" value="<?php echo esc_attr( $term_meta[$field['id']] ) ? esc_attr( $term_meta[$field['id']] ) : ''; ?>">
            <input type="button" class="button" id="term_meta_image_button" value="Choose image"><br>
            <p class="description"><?php _e( $field['description'],'metapress' ); ?></p>
            <script>
                jQuery(document).ready(function($){

                // Instantiates the variable that holds the media library frame.
                var meta_image_frame;

                // Runs when the image button is clicked.
                $('#term_meta_<?php echo $field["id"]?>_button').click(function(e) {

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
                        $('#term_meta_<?php echo $field["id"]?>').val(media_attachment.url);
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
            <input type="<?php echo $field['type']?>" name="term_meta_[<?php echo $field['id']?>]" id="term_meta_<?php echo $field['id']?>" value="<?php echo esc_attr( $term_meta[$field['id']] ) ? esc_attr( $term_meta[$field['id']] ) : ''; ?>">
            <p class="description"><?php _e( 'Enter a value for this field','metapress' ); ?></p>
        </td>
    <?php break;
        } ?>        
    </tr>
<?php
    }
}

// Save extra taxonomy fields callback function.
function metapress_save_taxonomy_custom_meta( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_$t_id" );
        $cat_keys = array_keys( $_POST['term_meta'] );
        foreach ( $cat_keys as $key ) {
            if ( isset ( $_POST['term_meta'][$key] ) ) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        // Save the option array.
        update_option( "taxonomy_$t_id", $term_meta );
    }
}  


function metapress_register_my_menus() {
    register_nav_menus(
        array(
          'header-menu' => __( 'Header Menu' ),
          'extra-menu' => __( 'Extra Menu' )
        )
    );
    foreach($GLOBALS['post_types'] as $k => $post_type) {

        register_post_type($k, array(
            'labels' => array(
              'name' => $post_type['title'],
              'singular_name' => $post_type['title']
            ),
            'description' => $post_type['description'],
            'public' => true,
            'menu_position' => 5,
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'has_archive' => true
        ));
        flush_rewrite_rules( false );
    }
    foreach($GLOBALS['taxonomies'] as $k => $taxonomy) {
        register_taxonomy(
            $k,
            $taxonomy['for'],
            array(
                'labels' => array(
                    'name' => $taxonomy['title'],
                    'add_new_item' => 'Add ' . $taxonomy['title'],
                    'new_item_name' => 'New ' . $taxonomy['title']
                ),
                'show_ui' => true,
                'show_tagcloud' => true,
                'hierarchical' => true,
		'supports' => array('title', 'editor', 'thumbnail')
            )
        );
    }

}

/**
 * Prints the card content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function metapress_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'metapress_meta_box', 'metapress_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    
    $post_type = get_post_type($post->ID);
    
    global $post_types;
    $meta_fields = $post_types[$post_type]['meta_fields'];
    foreach($meta_fields as $k => $v) {

        $value = get_post_meta( $post->ID,  $k, true );


        echo '<label for="metapress_' . $k . '">';
        _e( $v['title'], 'metapress' );
        echo '</label><br> ';
            switch($v['type']) {
            case "text":
                wp_editor(htmlspecialchars_decode($value), 'metapress_' . $k, $settings = array('textarea_name' => $k));    
            break;
            
            
            case 'image':
                echo '<input type="text" id="metapress_' . $k . '" name="' . $k . '" value="' . esc_attr( $value ) .'"><br>';
                echo '<input type="button" id="metapress_image_btn_' . $k . '" class="button" value="Choose or upload an image"><br>';
               
                ?>
            <script>
                jQuery(document).ready(function($){

                // Instantiates the variable that holds the media library frame.
                var meta_image_frame;

                // Runs when the image button is clicked.
                $('#metapress_image_btn_<?php echo $k ?>').click(function(e) {
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
                        $('#metapress_<?php echo $k?>').val(media_attachment.url);

                        return false;

                    });

                    // Opens the media library frame.
                    meta_image_frame.open();
                });
            });
    </script><?php
            break;
        default:
            echo '<input type="text" id="metapress_' . $k . '" name="' . $k . '" value="' . esc_attr( $value ) . '" size="25" /><br>';
            break;
        }
    }
}

/**
 * Adds a card to the main column on the Post and Page edit screens.
 */
function metapress_add_meta_boxes() {

    $screens = array( 'post');
    foreach ($GLOBALS['post_types'] as $k => $post_type) {
        $screens[] = $k;
    }
    foreach ( $screens as $screen ) {

        add_meta_box(
            'metapress_tour',
            __( 'Details', 'metapress' ),
            'metapress_meta_box_callback',
            $screen
        );
    }
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function metapress_save_meta_box_data( $post_id ) {
    global $meta_fields;
    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['metapress_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['metapress_meta_box_nonce'], 'metapress_meta_box' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    $post_type = $_POST['post_type'];



    /* OK, it's safe for us to save the data now. */
    
    global $post_types;
    $meta_fields = $post_types[$post_type]['meta_fields'];
    foreach($meta_fields as $k => $v) {
        if (isset($_POST[ $k])) {
            $value = get_post_meta( $post->ID, $k, true );

            $my_data = sanitize_text_field( $_POST[$k] );
            update_post_meta( $post_id, $k, $my_data );
        }

    }
    // Sanitize user input.

    // Update the meta field in the database.
}
