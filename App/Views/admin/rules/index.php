<?php

use App\Base\Notice;

defined('ABSPATH') or die('Access denied!'); ?>
<div class="wrap">
    <?php Notice::show(); ?>
    <h1>Redirect rules management</h1>
    <?php if ($rules !== null and count($rules) > 0) { ?>
        <p>
            <a href="<?php echo $this->route('rules.create'); ?>" class="button button-primary"><strong>+ Add new redirect rule</strong></a>
        </p>
        <table class="wp-list-table widefat striped">
            <thead>
                <tr>
                    <th class="manage-column column-cb check-column"></th>
                    <th class="manage-column">From</th>
                    <th>Redirect To</th>
                    <th>View</th>
                    <th>Status</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($rules as $rule) {
                    if ($rule->status == 0) {
                        $class = 'rule_is_deactive';
                        $rule_status = __('Deactive');
                        $rule_status_class = 'rule_status_deactive';
                    }else{
                        $class = '';
                        $rule_status = __('active');
                        $rule_status_class = 'rule_status_active';
                    }
                ?>
                    <tr>
                        <td class="manage-column">
                            <span class="<?php echo $class; ?>">
                                <?php echo $rule->id; ?>
                            </span>
                        </td>
                        <td class="manage-column">
                            <span class="<?php echo $class; ?>" dir="ltr">
                                /<?php echo $rule->uri; ?>
                            </span>
                        </td>
                        <td class="manage-column">
                            <span class="<?php echo $class; ?>" dir="ltr">
                                <?php echo $rule->redirect_to; ?>
                            </span>
                        </td>
                        <td class="manage-column">
                            <span class="<?php echo $class; ?>">
                            <?php echo number_format($rule->view); ?>
                            </span>
                        </td>
                        <td class="manage-column">
                            <span class="<?php echo $rule_status_class; ?>">
                                <?php echo $rule_status; ?>
                            </span>
                        </td>
                        <td class="manage-column">
                            <a href="<?php echo $this->route('rules.edit', ['id' => $rule->id]); ?>" class="button button-scondary">Edit</a>
                        </td>
                        <td class="manage-column">
                            <form action="<?php echo $this->route('rules.delete'); ?>" method="post">
                                <input type="hidden" name="id" value="<?php echo  $rule->id; ?>">
                                <input name="form_nonce" type="hidden" value="<?= wp_create_nonce($this->plugin_slug . 'delete_rule') ?>" />
                                <button type="submit" onclick=" return confirm ('Are you sure delete this item?');" class="button button-link-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="notice notice-danger is-dismissible">
            <p><?php _e('You have not registered anything.', 'SDWPRM'); ?>
                <a href="<?php echo $this->route('rules.create'); ?>"><strong><?php _e('Add new redirect rule', 'SDWPRM'); ?></strong></a>
            </p>
        </div>
    <?php } ?>
</div>