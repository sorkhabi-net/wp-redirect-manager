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
        'http_status_code_error': '<strong class="text-danger">{message}</strong>',
    };
    // Create/Edit rule validation
    if ($('#create_rule_form').length > 0 || $('#edit_rule_form').length > 0){
        $('#redirect_to_is_local').hide();
        $('#redirect_to').on('keyup', function (){
            redirect_to = $('#redirect_to').val();
            if (redirect_to.substr(0, 7) != 'http://' && redirect_to.substr(0, 8) != 'https://'){
                $('#redirect_to_is_local').show ();
                local_url = $('#redirect_to_local').attr ('data-site-url');
                if (redirect_to.substr(0, 1) != '/') {
                    local_url += '/';
                }
                local_url += redirect_to;
                $('#redirect_to_local').text (local_url);
                example_url = '';
                if (redirect_to.substr(0, 1) == '/') {
                    example_url = 'https:/';
                }else{
                    example_url = 'https://';
                }
                example_url += redirect_to;
                $('#redirect_to_example').text(example_url);
            }else{
                $('#redirect_to_is_local').hide ();
            }
        });
    }
    // Create new rute submit
    $('#create_rule_form').submit(function (e) {
        e.preventDefault();
        $('#create_rule_form_btn').attr('disabled', 'disabled');
        $('.alerts').html('');
        $('.hideable-alerts').hide ();
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
    var edit_rule_templates = {
        'nonce': '<div class="notice notice-warning is-dismissible"><p>{message} <a href="{url}">{url_text}</a></p></div>',
        'duplicate': '<div class="notice notice-warning is-dismissible"><p>{message} <a href="{url}">{url_text}</a></p></div>',
        'alert': '<div class="notice notice-warning is-dismissible"><p>{message}</p></div>',
        'uri_len': '<strong class="text-danger">{message}</strong>',
        'redirect_to_len': '<strong class="text-danger">{message}</strong>',
        'http_status_code_error': '<strong class="text-danger">{message}</strong>',
    };
    $('#edit_rule_form').submit(function (e) {
        e.preventDefault();
        $('#edit_rule_form_btn').attr('disabled', 'disabled');
        $('.alerts').html('');
        $('.hideable-alerts').hide();
        jQuery.ajax({
            type: "post",
            dataType: 'json',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (result) {
                $('#edit_rule_form_btn').attr('disabled', null);
                if (result.type == 'redirect') {
                    window.location.replace(result.url);
                    window.location.href = result.url;
                } else {
                    render_template(edit_rule_templates, result);
                }
            },
            error: function (result, code, error) {
                $('#edit_rule_form_btn').attr('disabled', null);
                render_template(edit_rule_templates, {
                    'type': 'alert',
                    'message': 'Something went wrong. Please try again.',
                });
            },
        });
    });
    var settings_templates = {
        'success': '<div class="notice notice-success is-dismissible"><p>{message}</p></div>',
        'nonce': '<div class="notice notice-warning is-dismissible"><p>{message} <a href="{url}">{url_text}</a></p></div>',
        'alert': '<div class="notice notice-warning is-dismissible"><p>{message}</p></div>',
        'http_status_code_error': '<strong class="text-danger">{message}</strong>',
    };
    $('#settings_form').submit(function (e) {
        e.preventDefault();
        $('#settings_form_btn').attr('disabled', 'disabled');
        $('.alerts').html('');
        jQuery.ajax({
            type: "post",
            dataType: 'json',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (result) {
                $('#settings_form_btn').attr('disabled', null);
                if (result.type == 'redirect') {
                    window.location.replace(result.url);
                    window.location.href = result.url;
                } else {
                    render_template(settings_templates, result);
                }
            },
            error: function (result, code, error) {
                $('#settings_form_btn').attr('disabled', null);
                render_template(settings_templates, {
                    'type': 'alert',
                    'message': 'Something went wrong. Please try again.',
                });
            },
        });
    });
});