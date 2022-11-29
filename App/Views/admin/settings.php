<?php

use App\Base\Notice;

defined('ABSPATH') or die('Access denied!'); ?>
<div class="wrap">
    <?php Notice::show(); ?>
    <h1>WP Redirect Manager Settings</h1>

    <div id="success" class="alerts"></div>
    <div id="nonce" class="alerts"></div>
    <div id="alert" class="alerts"></div>
    <form action="<?php echo $this->route('settings'); ?>" method="POST" id="settings_form">
        <input name="form_nonce" type="hidden" value="<?= wp_create_nonce($this->plugin_slug . 'settings') ?>" />
        <table class="form-table" role="presentation">
            <tr>
                <th scope="row"><label for="status">Redirect status:</label></th>
                <td>
                    <select name="status" id="status">
                        <option value="0">Deactive</option>
                        <option value="1" <?php echo ($this->get_setting ('status') ? ' selected="selected"' : ''); ?>>Active</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="error_404">Error 404 Tracker status:</label></th>
                <td>
                    <select name="error_404" id="error_404">
                        <option value="0">Deactive</option>
                        <option value="1" <?php echo ($this->get_setting ('error_404') ? ' selected="selected"' : ''); ?>>Active</option>
                    </select>
                </td>
            </tr>
        </table>
        <p class="submit">
            <button type="submit" id="settings_form_btn" class=" button button-primary">
                <span class="dashicons dashicons-update mt-4"></span>
                Save
            </button>
        </p>
    </form>
</div>