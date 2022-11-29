<?php

use App\Base\Notice;

defined('ABSPATH') or die('Access denied!'); ?>
<div class="wrap">
    <?php Notice::show(); ?>
    <h1>Add new redirect rule</h1>

    <div id="nonce" class="alerts"></div>
    <div id="duplicate" class="alerts"></div>
    <div id="alert" class="alerts"></div>
    <form action="<?php echo $this->route('rules.create', ['error_404' => $error_id]); ?>" method="POST" id="create_rule_form">
        <input name="form_nonce" type="hidden" value="<?= wp_create_nonce($this->plugin_slug . 'create_rule') ?>" />
        <table class="form-table" role="presentation">
            <tr>
                <th scope="row"><label for="uri">Redirect from:</label></th>
                <td>
                    <?php echo site_url(); ?>/<input name="uri" type="text" id="uri" value="<?php echo $uri; ?>" class="regular-text" required="required" />
                    <p class="description alerts" id="uri_len"></p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="redirect_to">Redirect to:</label></th>
                <td>
                    <input name="redirect_to" type="text" id="redirect_to" value="" class="regular-text" placeholder="https://site.com/" required="required" />
                    <p class="description alerts" id="redirect_to_len"></p>
                    <p class="description alerts">
                    <div class="description hideable-alerts" id="redirect_to_is_local">
                        <p>
                            It seems that the entered address is not correct and refers to the internal route.
                            <br />
                            This address is interpreted as: <strong id="redirect_to_local" data-site-url="<?php echo site_url(); ?>"></strong>
                            <br />
                            If this address is not an internal address, you must put <strong>http://</strong> or <strong>https://</strong> at the beginning of it.
                            <br />
                            For example: <strong id="redirect_to_example"></strong>
                        </p>
                    </div>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="status">Status:</label></th>
                <td>
                    <select name="status" id="status">
                        <option value="0">Deactive</option>
                        <option value="1" selected="selected">Active</option>
                    </select>
                </td>
            </tr>
        </table>
        <p class="submit">
            <button type="submit" id="create_rule_form_btn" class="button button-primary">
                <span class="dashicons dashicons-plus mt-4"></span>
                Add
            </button>
        </p>
    </form>
</div>