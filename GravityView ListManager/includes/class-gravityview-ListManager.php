<?php
class GravityView_ListManager {
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles_and_scripts'));
        add_action('wp_ajax_process_requirements', array($this, 'process_requirements'));
        add_action('wp_ajax_nopriv_process_requirements', array($this, 'process_requirements'));
        add_action('wp_ajax_update_button_text', array($this, 'update_button_text'));
        add_action('wp_ajax_nopriv_update_button_text', array($this, 'update_button_text'));
        add_shortcode('add_to_my_list_button', array($this, 'add_to_my_list_button_shortcode'));
    }

    public function enqueue_styles_and_scripts() {
        wp_enqueue_style('gravityview-custom-style', plugin_dir_url(GV_CUSTOM_PLUGIN_FILE) . 'css/style.css');
        wp_enqueue_script('gravityview-custom-script', plugin_dir_url(GV_CUSTOM_PLUGIN_FILE) . 'js/custom.js', array('jquery'), null, true);
        wp_localize_script('gravityview-custom-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    }

    public function process_requirements() {
        $section = sanitize_text_field($_POST['section']);
        $subSection = sanitize_text_field($_POST['subSection']);
        $requirementsList = sanitize_text_field($_POST['requirementsList']);
        $form_id_16 = 16; 
        $form_id_12 = 12; 
//         $form_id_18 = 18; 
        $form_data = array(
            "form_id"      => $form_id_12,
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

    public function update_button_text() {
		$section = sanitize_text_field($_POST['section']);
        $subSection = sanitize_text_field($_POST['subSection']);
        $requirementsList = sanitize_text_field($_POST['requirementsList']);
        $search_criteria = array(
            'status'        => 'active',
            'field_filters' => array(
                'mode' => 'any',
                array(
                    'key'   => '1',
                    'value' => $requirementsList
                )
            )
        );
        $entries = GFAPI::count_entries(12, $search_criteria);
		if ( isset( $entries ) ) {
			// Check if entries are found
			if ( $entries > 0 ) {
				echo wp_send_json_success( array( 'success' => true, 'count' => $entries ) );
			} else {
				echo wp_send_json_success( array( 'success' => true, 'count' => 0, 'message' => 'No entries found.' ) );
			}
		} else {
			echo wp_send_json_error( array( 'success' => false, 'message' => 'Form submission failed: ' . $entries->get_error_message() ) );
		}

		wp_die();
    }

    public function add_to_my_list_button_shortcode() {
        ob_start();
        ?>
        <button type="button" class="gvlogic add-to-list-button" >Add To My List</button>
        <?php
        return ob_get_clean();
    }
}
