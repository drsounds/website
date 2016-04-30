<?php
/** 
 * Template Name: Graph json
 */
header('Content-Type: application/json');

global $wpdb;

$data = array(
    'nodes' => array(),
    'links' => array()
);
$songs = array();
// Get songs
$q = new WP_Query();
$q->query(array('post_type' => 'tracks'));

while($q->have_posts()): $q->the_post();
$data['songs'][] = array(
    'title' => get_the_title($q->post->ID),
    'id' => $q->post->slug,
    'spotify_uri' => get_post_meta($q->post->ID, 'spotify_uri', TRUE)
);
endwhile;

$table = $wpdb->prefix . "track_relations";
$relations = $wpdb->get_results("SELECT * FROM $table", ARRAY_A);
foreach ($relations as $relation) {
    $data['links'][] = array(
        'from' => $relation['source'],
        'to' => $relation['target']
    );
}

echo json_encode($data);
