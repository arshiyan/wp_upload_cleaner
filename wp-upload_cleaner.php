<?php

/**
 * Plugin Name: Cleaner
 * Plugin URI:  http://rooyesh.net
 * Description: حذف فایل های اضافی هر ۲ ساعت
 * Version:     0.1
 */

/**
 * remove all files in upload directory
 *
 * @param  string $filename
 * @return string
 */

// Add a new interval of 180 seconds

add_filter('cron_schedules', 'isa_add_every_three_minutes');
function isa_add_every_three_minutes($schedules)
{
    $schedules['every_three_minutes'] = array(
        'interval' => 180,
        'display' => __('Every 3 Minutes', 'textdomain')
    );
    return $schedules;
}

// Schedule an action if it's not already scheduled
if (!wp_next_scheduled('isa_add_every_three_minutes')) {
    wp_schedule_event(time(), 'every_three_minutes', 'isa_add_every_three_minutes');
}

// Hook into that action that'll fire every three minutes
add_action('isa_add_every_three_minutes', 'every_three_minutes_event_func');
function every_three_minutes_event_func()
{
    /** define the directory **/

    $uploads = wp_upload_dir();
    if ($dir = opendir($uploads['basedir'])) {
        $images = array();
        while (false !== ($file = readdir($dir))) {
            if ($file != "." && $file != "..") {
                if (is_file) {
                    if (filemtime($uploads['basedir']. '/' .$file) < ( time() - ( 1 * 2 * 60 * 60 ) ) ) //day * 24 * 60 * 60
                    {
                        //$images[] = $file;
                        unlink($uploads['basedir']. '/' . $file);


                    }

                }

            }
        }
    }
    closedir($dir);

/*
    $to = 'dr.bloger@gmail.com';
    $subject = 'The subject';
    $body = 'The email body content ';
    $body .= json_encode($images);
    $body .= " count " . count($images);

    $headers = array('Content-Type: text/html; charset=UTF-8');
    wp_mail($to, $subject, $body, $headers);
*/
}
