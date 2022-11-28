jQuery(document).ready(function ($) {
    function render_template(templates, data) {
        template = templates[data.type];
        for (key in data) {
            template = template.replace('{' + key + '}', data[key]);
        };
        $('#' + data['type']).html(template);
    }
    var create_rule_templates = {
        'nonce': '<div class="notice notice-warning is-dismissible"><p>{message} <a href="{url}">{url_text}</a></p></div>',
        'duplicate': '<div class="notice notice-warning is-dismissible"><p>{message} <a href="{url}">{url_text}</a></p></div>',
        'alert': '<div class="notice notice-warning is-dismissible"><p>{message}</p></div>',
        'uri_len': '<strong class="text-danger">{message}</strong>',
        'redirect_to_len': '<strong class="text-danger">{message}</strong>',
    };
    $('#create_rule_form').submit(function (e) {
        e.preventDefault();
        $('#create_rule_form_btn').attr('disabled', 'disabled');
        $('.alerts').html('');
        jQuery.ajax({
            type: "post",
            dataType: 'json',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (result) {
                $('#create_rule_form_btn').attr('disabled', null);
                if (result.type == 'redirect') {
                    window.location.replace(result.url);
                    window.location.href = result.url;
                } else {
                    render_template(create_rule_templates, result);
                }
            },
            error: function (result, code, error) {
                $('#create_rule_form_btn').attr('disabled', null);
                render_template(create_rule_templates, {
                    'type': 'alert',
                    'message': 'Something went wrong. Please try again.',
                });
            },
        });
    });
});