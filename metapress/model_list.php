<?php
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
            <?php foreach($model['fields'] as $f => $field): $fields[] = $field; $_fields[] = $f;?>
            <th class="manage-column column-cb check-column">
                <?php echo $field['title']?>
            </th>
        <?php endforeach;?>
        </thead>
        <tbody>
            <?php
            // Get data
            $_fields = implode(', ', $fields);

            $rows = $wpdb->get_results("SELECT $fields FROM $model", ARRAY_A);

            foreach($rows as $row):?>
            <tr class="iedit author-self level-0 post-1 type-post status-publish format-standard hentry category-uncategorized">
                <?php foreach($model['fields'] as $f => $field):?>
                <td><?php echo $row[$f]?></td>
                <?php endforeach;?>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table><?php?>