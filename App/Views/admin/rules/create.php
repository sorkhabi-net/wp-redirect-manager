<?php

use App\Base\Notice;

defined('ABSPATH') or die('Access denied!'); ?>
<div class="wrap">
    <?php Notice::show(); ?>
    <h1>Add new redirect rule</h1>

    <div id="nonce" class="alerts"></div>
    <div id="duplicate" class="alerts"></div>
    <div id="alert" class="alerts"></div>
    <form action="<?php echo $this->route('rules.create'); ?>" method="POST" id="form">
        <input name="form_nonce" type="hidden" value="<?= wp_create_nonce($this->plugin_slug . 'create_rule') ?>" />
        <table class="form-table" role="presentation">
            <tr>
                <th scope="row"><label for="uri">Redirect from:</label></th>
                <td>
                    <?php echo site_url(); ?>/<input name="uri" type="text" id="uri" value="" class="regular-text" required="required" />
                    <p class="description alerts" id="uri_len"></p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="redirect_to">Redirect to:</label></th>
                <td>
                    <input name="redirect_to" type="text" id="redirect_to" value="" class="regular-text" placeholder="https://site.com/" required="required" />
                    <p class="description alerts" id="redirect_to_len"></p>
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
            <button type="submit" id="form_btn" class="button button-primary">Add</button>
        </p>
    </form>
</div>
<script>
    var templates = {
        'nonce': '<div class="notice notice-warning is-dismissible"><p>{message} <a href="{url}">{url_text}</a></p></div>',
        'duplicate': '<div class="notice notice-warning is-dismissible"><p>{message} <a href="{url}">{url_text}</a></p></div>',
        'alert': '<div class="notice notice-warning is-dismissible"><p>{message}</p></div>',
        'uri_len': '<strong class="text-danger">{message}</strong>',
        'redirect_to_len': '<strong class="text-danger">{message}</strong>',
    };
    jQuery(document).ready(function($) {
        function render_template(data) {
            template = templates[data.type];
            for (key in data) {
                template = template.replace('{' + key + '}', data[key]);
            };
            $('#' + data['type']).html(template);
        }
        $('#form').submit(function(e) {
            e.preventDefault();
            $('#form_btn').attr('disabled', 'disabled');
            $('.alerts').html('');
            jQuery.ajax({
                type: "post",
                dataType: 'json',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(result) {
                    $('#form_btn').attr('disabled', null);
                    if (result.type == 'redirect') {
                        window.location.replace(result.url);
                        window.location.href = result.url;
                    } else {
                        render_template(result);
                    }
                },
                error: function(result, code, error) {
                    $('#form_btn').attr('disabled', null);
                    render_template({
                        'type': 'alert',
                        'message': 'Something went wrong. Please try again.',
                    });
                },
            });
        });
    });
</script>