<?php defined('ABSPATH') or die('Access denied!'); ?>
<div class="wrap">

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
                            <a href="<?php echo $this->route('rules.edit', ['id' => $rule->id]); ?>" class="button button-scondary">Edit</a>
                        </td>
                        <td class="manage-column">
                            <form action="<?php echo $this->route('rules.delete'); ?>" method="post">
                                <input type="hidden" name="id" value="<?php echo  $rule->id; ?>">
                                <button type="submit" class="button button-link-delete">Delete</button>
                                <!-- onclick=" return confirm ('Are you sure delete this item?');" -->
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