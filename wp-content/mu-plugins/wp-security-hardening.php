<?php
/*
Plugin Name: WP Security Hardening
Description: Mitigates REST API batch route confusion (CVE-2026-63030) and author__not_in SQLi (CVE-2026-60137).
Version: 1.0.0
Author: WordPress Security
*/

add_filter('rest_pre_dispatch', function($result, $server, $request) {
    if ($result !== null) return $result;
    $route = $request->get_route();
    if (preg_match('#/v2/batch\b#i', $route) && !current_user_can('read')) {
        return new WP_Error(
            'rest_batch_forbidden',
            'Batch endpoint requires authentication.',
            array('status' => 403)
        );
    }
    return $result;
}, 5, 3);

add_action('pre_get_posts', function($query) {
    if (!empty($query->query_vars['author__not_in'])) {
        $query->query_vars['author__not_in'] = array_map('absint',
            (array) $query->query_vars['author__not_in']);
    }
});
