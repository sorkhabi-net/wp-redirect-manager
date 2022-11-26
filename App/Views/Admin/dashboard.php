<?php

use App\Apis\Helper;

defined('ABSPATH') or die('Access denied!'); ?>
<div class="wrap">

    <h1>Redirect rules management</h1>
    <?php if ($rules !== null and count($rules) > 0) { ?>
        <p>
            <a href="<?php echo admin_url('admin.php?page=' . $this->plugin_slug . 'rules&action=add_new_rule'); ?>" class="button button-primary"><strong>+ Add new redirect rule</strong></a>
        </p>
        <table class="wp-list-table widefat striped">
            <thead>
                <tr>
                    <th class="manage-column column-cb check-column"></th>
                    <th class="manage-column">From</th>
                    <th>Redirect To</th>
                    <th>View</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rules as $rule) { ?>
                    <tr>
                        <td class="manage-column "><?php echo $rule->id; ?></td>
                        <td class="manage-column">/<?php echo $rule->uri; ?></td>
                        <td class="manage-column"><?php echo $rule->redirect_to; ?></td>
                        <td class="manage-column"><?php echo number_format($rule->view); ?></td>
                        <td class="manage-column">
                            <a href="#" class="button button-scondary">Edit</a>
                        </td>
                        <td class="manage-column">
                            <a href="#" class="button button-link-delete" onclick=" return confirm ('Are you sure delete this item?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="notice notice-danger is-dismissible">
            <p><?php _e('You have not registered anything. <a href=""><strong>Add new redirect rule</strong></a>', 'SDWPRM'); ?></p>
        </div>
    <?php } ?>
</div>