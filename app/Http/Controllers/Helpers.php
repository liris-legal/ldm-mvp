<?php
/**
 * Helpers
 *
 * @package  helpers
 * @author   thaild <thai.le.connectiv@gmail.com>
 */

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use IntlDateFormatter;

class Helpers
{

    /**
     * Get hostname by request
     *
     * @param Request $request
     * @return string
     */
    public static function hostname(Request $request)
    {
        return $request->getHttpHost();
    }

    /**
     * japanese date formatter
     *
     * ex: $date = created_at: "2019-12-30 07:53:05"
     * output -> "2019年12月30日"
     *
     * @param $date
     * @param bool $withDay
     * @return string
     */
    public static function dateFormatter($date, $withDay = false)
    {
        // pattern: "y年M月d日EEEE"
        $fullFormatter = new IntlDateFormatter(
            'ja_JP',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE
        );

        // pattern: "y年M月d日"
        $longFormatter = new IntlDateFormatter(
            'ja_JP',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE
        );

        return $withDay ? $fullFormatter->format($date) : $longFormatter->format($date);
    }
}
