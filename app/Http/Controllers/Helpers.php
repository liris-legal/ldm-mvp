<?php
/**
 * Helpers
 *
 * @package  helpers
 * @author   thaild <thai.le.connectiv@gmail.com>
 */

namespace App\Http\Controllers;

use App\Models\Lawsuit;
use App\Models\Submitter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
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
     * @return \Illuminate\Support\Collection
     */
    public static function parseParties($lawsuit)
    {
        $parties = collect();
        $plaintiffs = $lawsuit->plaintiffs;
        $defendants = $lawsuit->defendants;

        $parties->push($plaintiffs->count() ? $plaintiffs : Helpers::selectParty('plaintiff'));
        $parties->push($defendants->count() ? $defendants : Helpers::selectParty('defendant'));
        $parties = $parties->flatten();

        foreach (Submitter::where('description', 'court')->orWhere('description', 'other_party')->get() as $sub) {
            $parties->push($sub);
        }

        return Helpers::addAttributes($parties, 'display_name');
    }

    /**
     * Select party
     *
     * @param $parties
     * @param string $attr
     * @return \Illuminate\Support\Collection
     */
    public static function addAttributes($parties, $attr = 'display_name')
    {
        $addedParties = collect();
        $counterPlaintiff = 0;
        $counterDefendant = 0;
        foreach ($parties as $submitter) {
            $submitter[$attr] = $submitter->name;
            if ((int)($submitter->submitter_id) === 1) {
                $counterPlaintiff += 1;
                $party = '原告';
                $submitter[$attr] = $party . $counterPlaintiff . '(' . $submitter->name . ')';
            } elseif ((int)($submitter->submitter_id) === 3) {
                $counterDefendant += 1;
                $party = '被告';
                $submitter[$attr] = $party . $counterDefendant . '(' . $submitter->name . ')';
            }
            $addedParties->push($submitter);
        }

        return $addedParties;
    }

    /**
     * Select party
     *
     * @param $party
     * @return array
     */
    public static function selectParty($party)
    {
        return Submitter::where('description', $party)->get();
    }

    /**
     * Validated exists request filed.
     * @param $request
     * @param $messages
     */
    public static function validatedSubnumberExists($request, $messages)
    {
        $documentableType = $request->submitter_id == 1 ? 'App\Models\Plaintiff' : 'App\Models\Defendant';

        // only check subnumber > 1
        if ($request->subnumber > 1 && ($request->name === '乙号証' || $request->name === '甲号証')) {
            $input = $request->only('subnumber');
            $input['subnumber'] = ($request->document && $request->subnumber - 1 == $request->document->subnumber) ?
                $input['subnumber'] : $input['subnumber'] - 1;

            $rules = [
                'subnumber' => 'bail|required|numeric|max:50|min:0|exists:documents,subnumber,lawsuit_id,'
                    . $request->lawsuit_id . ',submitter_id,' . $request->submitter_id
                    . ',documentable_type,' . $documentableType . ',documentable_id,' . $request->type_submitter_id
                    . ',name,' . $request->name . ',number,' . $request->number
            ];
            Validator::make($input, $rules, $messages)->validate();
        }
    }

    /**
     * Validated exists request filed.
     * @param $request
     * @param $messages
     */
    public static function validatedNumberExists($request, $messages)
    {
        // when update to change document type
        if ($request->number > 1) {
            $input = $request->only('number');

            $input['number'] = ($request->document && $request->number - 1 == $request->document->number) ?
                $input['number'] : $input['number'] - 1;

            $rules = [
                'number' => 'bail|required|numeric|max:100|min:1|exists:documents,number,lawsuit_id,'
                    . $request->lawsuit_id . ',submitter_id,' . $request->submitter_id . ',name,' . $request->name
            ];

            Validator::make($input, $rules, $messages)->validate();
        }
    }
    /**
     * Validated unique request filed.
     * @param $request
     */
    public static function validatedNumberUnique($request)
    {
        // when update to change document type
        if ($request->name !== $request->document->name) {
            $input = $request->only('number');

            $rules = [
                'number' => 'bail|required|numeric|max:100|min:1|unique:documents,number,NULL,id'
                    . ',lawsuit_id,' . $request->document->lawsuit_id . ',submitter_id,' . $request->submitter_id
                    . ',documentable_type,' . $request->document->documentable_type
                    . ',documentable_id,' . $request->document->documentable_type
                    . ',name,' . $request->name . ',subnumber,' . $request->subnumber
            ];

            Validator::make($input, $rules)->validate();
        }
    }
}
