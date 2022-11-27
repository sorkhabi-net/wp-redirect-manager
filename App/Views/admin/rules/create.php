<?php

use App\Base\Notice;

 defined('ABSPATH') or die('Access denied!'); ?>
<div class="wrap">
    <?php Notice::show(); ?>
    <h1>Add new redirect rule</h1>
    <form action="<?php echo $this->route('rules.create'); ?>" method="POST">
        <input name="form_nonce" type="hidden" value="<?= wp_create_nonce($this->plugin_slug . 'create_rule') ?>" />
        <table class="form-table" role="presentation">
            <tr>
                <th scope="row"><label for="uri">Redirect from:</label></th>
                <td><?php echo site_url(); ?>/<input name="uri" type="text" id="uri" value="" class="regular-text" required="required"/></td>
            </tr>
            <tr>
                <th scope="row"><label for="redirect_to">Redirect to:</label></th>
                <td><input name="redirect_to" type="text" id="redirect_to" value="" class="regular-text" placeholder="https://site.com/" required="required"/></td>
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
            <button type="submit" class="button button-primary">Add</button>
        </p>
    </form>
</div>