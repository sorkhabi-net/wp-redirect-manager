<?php

use SWPRM\Base\Notice;

defined('ABSPATH') or die('Access denied!'); ?>
<div class="wrap">
    <h1>Error 404 Tracker</h1>
    <?php Notice::show(); ?>
    <?php
    if (!$this->get_setting ('error_404')){
        Notice::show ('error_404_tracker_disabled');
    }
    if ($errors !== null and count($errors) > 0) { ?>
        <table class="wp-list-table widefat striped table-responsive-sm">
            <thead>
                <tr>
                    <th class="manage-column">Url</th>
                    <th class="d-none-sm">View</th>
                    <th class="d-none-sm">Last View at</th>
                    <th class="d-blockize-sm">Fix</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($errors as $error) {
                ?>
                    <tr>
                        <td class="manage-column">
                            <span class="<?php echo $class; ?>" dir="ltr">
                                <span class="dashicons dashicons-admin-links"></span> <?php echo site_url() . '/' . esc_html($error->uri); ?>
                            </span>
                        </td>
                        <td class="manage-column d-none-sm">
                            <span class="<?php echo $class; ?>">
                                <span class="dashicons dashicons-visibility"></span>
                                <?php echo number_format($error->view); ?>
                            </span>
                        </td>
                        <td class="manage-column d-none-sm">
                            <span class="<?php echo $class; ?>">
                                <?php echo $error->last_view_at; ?>
                            </span>
                        </td>
                        <td class="manage-column d-blockize-sm">
                            <a href="<?php echo $this->route('rules.create', ['error_404' => $error->id]); ?>" class="button button-scondary">
                                <span class="dashicons dashicons-yes mt-4"></span>
                                Fix Error
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        $page_links = paginate_links([
            'base' => add_query_arg(['cpage' => '%#%']),
            'prev_text' => __('&laquo;'),
            'next_text' => __('&raquo;'),
            'total' => ceil($total / $items_per_page),
            'current' => $page
        ]);
        if ($page_links) {
            echo '
            <div class="tablenav bottom">
            <div class="tablenav-pages">
            <ul class="page-links">';
            echo $page_links;
            echo '</ul></div></div>';
        }
        ?>
    <?php } else { ?>
        <div class="notice notice-success">
            <p><?php _e('Very good! You have not 404 error.', 'SWPRM'); ?></p>
        </div>
    <?php } ?>
</div>