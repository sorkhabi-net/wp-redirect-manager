<?php

/**
 * @package SDWPRM
 */

namespace App\Base;

class Notice
{
    private static function notices()
    {
        return [
            'rule_deleted_successfully' => [
                'message' => __('Redirect rule deleted successfully.', 'SDWPRM'),
                'type' => 'success',
            ],
            'try_again' => [
                'message' => __('Something wrong! please try again.', 'SDWPRM'),
                'type' => 'error',
            ],
            'rule_is_not_exists' => [
                'message' => __('Redirect rule is not exists. <a href="#" onclick="window.history.go(-1); return false;"><strong>Back</strong></a>', 'SDWPRM'),
                'type' => 'error',
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
