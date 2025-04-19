<?php

/**
 * Created by Ed.Creater <ed.creater@gmail.com>.
 * Author Site: http://codesweet.ru
 * Date: 16.07.2017
 */

namespace HaemoCore\Modules;

class RussianDate
{
    // function Russian Date
    public static function the_russian_time($template = '')
    {

        $RinTemplate = strpos($template, "R");

        if ($RinTemplate === false) {
            echo get_the_time($template);
        } else {
            if ($RinTemplate > 0) {
                echo get_the_time(substr($template, 0, $RinTemplate));
            }

            $months = array (
                "января",
                "февраля",
                "марта",
                "апреля",
                "мая",
                "июня",
                "июля",
                "августа",
                "сентября",
                "октября",
                "ноября",
                "декабря"
            );
            echo $months[get_the_time('n') - 1];
            self::the_russian_time(substr($template, $RinTemplate + 1));
        }
    }

    public static function get_rus_date($timestamp = null)
    {

        if (!$timestamp) {
            return false;
        }
        $months = array (
                "января",
                "февраля",
                "марта",
                "апреля",
                "мая",
                "июня",
                "июля",
                "августа",
                "сентября",
                "октября",
                "ноября",
                "декабря"
        );

        $date = explode(".", date("d.m.Y", $timestamp));

        return $date[0] . '&nbsp;' . $months[$date[1] - 1] . '&nbsp;' . $date[2];
    }
}
