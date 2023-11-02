<?php

function enqueue_parent_theme_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_styles' );

function mycustom_wp_footer() {
?>
    <script type="text/javascript">
    document.addEventListener('wpcf7mailsent', function (e) {
        window.location.href = "/dashboard";
    }, false);
    </script>
<?php
}
add_action('wp_footer', 'mycustom_wp_footer');

function custom_login_redirect($redirect_to, $request, $user) {
    if (is_a($user, 'WP_User') && $user->has_cap('administrator')) {
        return $redirect_to;
    } else {
        return home_url('/dashboard');
    }
}
add_filter('login_redirect', 'custom_login_redirect', 10, 3);

function hide_admin_bar_for_non_admins() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'hide_admin_bar_for_non_admins');

function redirect_non_admin_users() {
    if (!current_user_can('administrator') && is_admin()) {
        wp_redirect(home_url());
        exit;
    }
}
add_action('admin_init', 'redirect_non_admin_users');

function redirect_non_logged_in_users() {
    if (!is_user_logged_in() && is_admin()) {
        wp_redirect(wp_login_url());
        exit;
    }
}
add_action('admin_init', 'redirect_non_logged_in_users');


function set_default_post_status($data, $postarr) {
    if ('recipe' == $data['post_type']) {
        if (!current_user_can('activate_plugins')) {
            $data['post_status'] = 'publish';
        }
    }
    return $data;
}
add_filter('wp_insert_post_data', 'set_default_post_status', 10, 2);

function create_list($content) {
    $lines = explode("\n", $content);
    if (!empty($lines)) {
        $ul = '<ul>';
        foreach ($lines as $line) {
            $ul .= '<li>' . esc_html(trim($line)) . '</li>';
        }
        $ul .= '</ul>';
        return $ul;
    } else {
        return '';
    }
}

function custom_recipe_update_redirect($post_id) {
    $redirect_url = '/recipepage/?post_id=' . $post_id;
    echo "<script>window.location.href = '{$redirect_url}';</script>";
    exit;
}
