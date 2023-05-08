<?php

use SWPRM\Base\Notice;

defined('ABSPATH') or die('Access denied!'); ?>
<div class="wrap">
    <h1>Redirect rules management</h1>
    <?php Notice::show(); ?>
    <?php
    if (!$this->get_setting('status')) {
        Notice::show('status_disabled');
    }
    ?>
    <?php if ($rules !== null and count($rules) > 0) { ?>
        <p>
            <a href="<?php echo $this->route('rules.create'); ?>" class="button button-primary">
                <span class="dashicons dashicons-plus mt-4"></span>
                <strong>Add new redirect rule</strong>
            </a>
        </p>
        <table class="wp-list-table widefat striped table-responsive-sm">
            <thead>
                <tr>
                    <th class="manage-column">Redirect From</th>
                    <th>Redirect To</th>
                    <th class="d-none-sm">View</th>
                    <th class="d-none-sm">Status</th>
                    <th class="d-blockize-sm">Edit</th>
                    <th class="d-blockize-sm">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($rules as $rule) {
                    if ($rule->status == 0) {
                        $class = 'rule_is_deactive';
                        $rule_status = '<span class="dashicons dashicons-no"></span> ' . __('Deactive');
                        $rule_status_class = 'rule_status_deactive';
                    } else {
                        $class = '';
                        $rule_status = '<span class="dashicons dashicons-yes"></span> ' . __('Active');
                        $rule_status_class = 'rule_status_active';
                    }
                ?>
                    <tr>
                        <td class="manage-column">
                            <span class="<?php echo $class; ?>" dir="ltr">
                                <span class="dashicons dashicons-admin-links"></span> <?php echo site_url() . '/' . esc_html($rule->uri); ?>
                            </span>
                        </td>
                        <td class="manage-column">
                            <span class="<?php echo $class; ?>" dir="ltr">
                                <span class="dashicons dashicons-randomize"></span>
                                <?php
                                if (mb_substr($rule->redirect_to, 0, 7, 'UTF-8') != 'http://' and mb_substr($rule->redirect_to, 0, 8, 'UTF-8') != 'https://') {
                                    $redirect_to = site_url();
                                    if (mb_substr($rule->redirect_to, 0, 1, 'UTF-8') != '/') {
                                        $redirect_to .= '/';
                                    }
                                    $redirect_to .= $rule->redirect_to;
                                } else {
                                    $redirect_to = $rule->redirect_to;
                                }
                                echo esc_html($redirect_to);
                                ?>
                            </span>
                        </td>
                        <td class="manage-column d-none-sm">
                            <span class="<?php echo $class; ?>">
                                <span class="dashicons dashicons-visibility"></span>
                                <?php echo number_format($rule->view); ?>
                            </span>
                        </td>
                        <td class="manage-column d-none-sm">
                            <span class="<?php echo $rule_status_class; ?>">
                                <?php echo $rule_status; ?>
                            </span>
                        </td>
                        <td class="manage-column d-blockize-sm">
                            <a href="<?php echo $this->route('rules.edit', ['id' => $rule->id]); ?>" class="button button-scondary">
                                <span class="dashicons dashicons-update mt-4"></span>
                                Edit
                            </a>
                        </td>
                        <td class="manage-column d-blockize-sm">
                            <form action="<?php echo $this->route('rules.delete'); ?>" method="post">
                                <input type="hidden" name="id" value="<?php echo  $rule->id; ?>">
                                <input name="form_nonce" type="hidden" value="<?= wp_create_nonce($this->plugin_slug . 'delete_rule') ?>" />
                                <button type="submit" onclick=" return confirm ('Are you sure delete this item?');" class="button button-link-delete">
                                    <span class="dashicons dashicons-trash mt-4"></span>
                                    Delete
                                </button>
                            </form>
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
        <div class="notice notice-danger is-dismissible">
            <p><?php _e('You have not registered anything.', 'SWPRM'); ?>
                <a href="<?php echo $this->route('rules.create'); ?>"><strong><?php _e('Add new redirect rule', 'SWPRM'); ?></strong></a>
            </p>
        </div>
    <?php } ?>
</div>