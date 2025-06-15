<?php

namespace App\Helpers;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;

use App\Models\AdminRelated\QuickSetting\CustomizedAlert\AlertFor;
use App\Models\AdminRelated\QuickSetting\CustomizedAlert\AlertType;
use App\Models\AdminRelated\QuickSetting\CustomizedAlert\AlertTemplate;

use Exception;
use Illuminate\Support\Facades\Config;

class CommonHelper
{
    use FileTrait, CommonTrait;
    public $platform = 'backend';


    public static function replaceVariableWithValue($params, $platform = '')
    {
        try {
            [
                'replaceData' => $replaceData,
                'alertType' => $alertType,
                'alertFor' => $alertFor,
            ] = $params;
            $alertType = AlertType::where('uniqueId', $alertType)->first();
            $alertFor = AlertFor::where('uniqueId', $alertFor)->first();
            $alertTemplate = AlertTemplate::where([
                ['alertTypeId', $alertType->id],
                ['alertForId', $alertFor->id],
                ['default', Config::get('constants.status.yes')]
            ])->first();
            $content = $alertTemplate->content;
            foreach ($replaceData as $temp) {
                $content = str_replace($temp['key'], $temp['value'], $content);
            }
            return [
                'heading' => $alertTemplate->heading,
                'content' => $content,
            ];
        } catch (Exception $e) {
            return false;
        }
    }
}
