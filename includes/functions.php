<?php
function sidrekap_get_data() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sidrekap';
    return $wpdb->get_results("SELECT * FROM $table_name");
}
