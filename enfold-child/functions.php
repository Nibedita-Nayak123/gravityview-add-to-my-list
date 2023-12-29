<?php
function enqueue_custom_script() {
    wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/custom.js', array('jquery'), null, true);
    wp_localize_script('custom-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_script');
function process_requirements() {
    $section = sanitize_text_field($_POST['section']);
    $subSection = sanitize_text_field($_POST['subSection']);
    $requirementsList = sanitize_text_field($_POST['requirementsList']);
    $form_id_12 = 12;
    $form_data = array(
        "form_id" => $form_id_12,
        '3' => $section,
        '10' => $subSection,
        '1' => $requirementsList,
    );
    $result = GFAPI::add_entry($form_data);
    if (is_wp_error($result)) {
        echo json_encode(array('success' => false, 'message' => 'Form submission failed: ' . $result->get_error_message()));
    } else {
        echo json_encode(array('success' => true));
    }
    wp_die();
}
add_action('wp_ajax_process_requirements', 'process_requirements');
add_action('wp_ajax_nopriv_process_requirements', 'process_requirements');
function get_entries_with_criteria($form_id, $section, $subSection, $requirementsList) {
    $search_criteria = array(
        'status'        => 'active',
        'field_filters' => array(
            'mode' => 'any',
            array(
                'key'   => '3',
                'value' => $section
            ),
            array(
                'key'   => '10',
                'value' => $subSection
            ),
            array(
                'key'   => '1',
                'value' => $requirementsList
            )
        )
    );
    $entries = GFAPI::get_entries($form_id, $search_criteria);
    return $entries;
}
function add_to_my_list_button_shortcode() {
    $form_id_16 = 16;
    $section = '3';
    $subSection = '10';
    $requirementsList = '1';
    $entries = get_entries_with_criteria($form_id_16, $section, $subSection, $requirementsList);
    $data_already_exists = !empty($entries);
    ob_start();
    ?>
    <button type="button" class="gvlogic add-to-list-button" <?php echo $data_already_exists ? 'disabled="disabled"' : ''; ?>>
        <?php echo $data_already_exists ? 'Added To My List' : 'Add To My List'; ?>
    </button>
    <?php
    return ob_get_clean();
}
add_shortcode('add_to_my_list_button', 'add_to_my_list_button_shortcode');
?>
