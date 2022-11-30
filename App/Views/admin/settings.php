<?php

use App\Base\Helper;
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
                        <option value="1" <?php echo ($this->get_setting('status') ? ' selected="selected"' : ''); ?>>Active</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="error_404">Error 404 Tracker status:</label></th>
                <td>
                    <select name="error_404" id="error_404">
                        <option value="0">Deactive</option>
                        <option value="1" <?php echo ($this->get_setting('error_404') ? ' selected="selected"' : ''); ?>>Active</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="http_status_code">Default http status code:</label></th>
                <td>
                    <select name="http_status_code" id="http_status_code">
                        <?php
                        $statusList = Helper::http_status_code();
                        unset($statusList[0]);
                        $default_http_status_code = $this->get_setting('http_status_code');
                        foreach ($statusList as $status_code => $status) {
                            if ($status_code == $default_http_status_code) {
                                $selected = true;
                            } else {
                                $selected = false;
                            }
                            echo '<option value="' . $status_code . '"' . ($selected ? ' selected="selected"' : '') . '>' . $status . '</option>';
                        }
                        ?>
                    </select>
                    <p class="description alerts" id="http_status_code_error"></p>
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