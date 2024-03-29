<?php

/**
 * @package SWPRM
 */

namespace SWPRM\Base;

class Notice
{
    private static function controller ()
    {
        return (new Controller);
    }
    private static function notices()
    {
        return [
            'rule_deleted_successfully' => [
                'message' => __('Redirect rule deleted successfully.', 'SWPRM'),
                'type' => 'success',
            ],
            'try_again' => [
                'message' => __('Something wrong! please try again.', 'SWPRM'),
                'type' => 'error',
            ],
            'rule_is_not_exists' => [
                'message' => __('Redirect rule is not exists.<br/><a class="button button-scondary" href="#" onclick="window.history.go(-1); return false;"><strong>Back</strong></a>', 'SWPRM'),
                'type' => 'error',
            ],
            'rule_created_successfully' => [
                'message' => __('Redirect rule created successfully.', 'SWPRM'),
                'type' => 'success',
            ],
            'rule_updated_successfully' => [
                'message' => __('Redirect rule updated successfully.', 'SWPRM'),
                'type' => 'success',
            ],
            'error_404_tracker_disabled' => [
                'message' => __('Error 404 tracker is disabled. We recommend that you keep this option enabled.<br/><a class="button button-scondary" href="' . self::controller ()->route ('error_404', ['notice' => 'error_404_tracker_active']) . '">Click here to activate this option</a>', 'SWPRM'),
                'type' => 'warning',
            ],
            'error_404_tracker_active' => [
                'message' => __('Error 404 tracker enabled.', 'SWPRM'),
                'type' => 'success',
            ],
            'status_disabled' => [
                'message' => __('Redirect system is disabled. We recommend that you keep this option enabled.<br/><a class="button button-scondary" href="' . self::controller ()->route ('rules', ['notice' => 'status_active']) . '">Click here to activate this option</a>', 'SWPRM'),
                'type' => 'warning',
            ],
            'status_active' => [
                'message' => __('Redirect system enabled.', 'SWPRM'),
                'type' => 'success',
            ],
        ];
    }
    private static function render($notice)
    {
        echo '
        <div class="notice notice-' . $notice['type'] . ' is-dismissible">
        <p>' . $notice['message'] . '</p>
        </div>';
    }
    public static function show($notice_key = null)
    {
        if ($notice_key === null and isset($_GET['notice'])) {
            $notice_key = $_GET['notice'];
        }
        if (isset(self::notices()[$notice_key])) {
            echo self::render(self::notices()[$notice_key]);
        }
    }
}
