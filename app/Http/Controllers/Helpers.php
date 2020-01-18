<?php
/**
 * Helpers
 *
 * @package  helpers
 * @author   thaild <thai.le.connectiv@gmail.com>
 */

namespace App\Http\Controllers;

use App\Models\Lawsuit;
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


    /**
     * parse submitters with plaintiff, defendant
     *
     * @param Lawsuit $lawsuit
     * @param $submitters
     * @return \Illuminate\Support\Collection
     */
    public static function parseParties($lawsuit, $submitters)
    {
        $parties = collect();
        $plaintiffs = $lawsuit->plaintiffs;
        $defendants = $lawsuit->defendants;

        $parties->push($plaintiffs->count() ? $plaintiffs : Helpers::filteredSubmitter($submitters, 'plaintiff'));
        $parties->push($defendants->count() ? $defendants : Helpers::filteredSubmitter($submitters, 'defendant'));
        $parties = $parties->flatten();

        foreach ($submitters->where('description', 'court')->orWhere('description', 'other_party')->get() as $sub) {
            $parties->push($sub);
        }

        return $parties;
    }

    /**
     * Filter submitters where $party
     *
     * @param $submitters
     * @param $party
     * @return array
     */
    public static function filteredSubmitter($submitters, $party)
    {
        return $submitters->where('description', $party)->get();
    }

}
