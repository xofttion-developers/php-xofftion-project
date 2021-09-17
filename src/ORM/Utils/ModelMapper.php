<?php

namespace Xofttion\Project\ORM\Utils;

use Carbon\Carbon;

use Xofttion\ORM\Utils\ModelMapper as BaseModelMapper;

class ModelMapper extends BaseModelMapper
{

    // Métodos sobrescritos de la clase BaseModelMapper

    protected function getValueConvert(string $type, $value)
    {
        switch ($type) {
            case ("datetime"): {
                return Carbon::createFromTimestamp($value)->toDateTimeString();
            }

            case ("date"): {
                return Carbon::createFromTimestamp($value)->toDateString();
            }

            case ("decimal"): {
                return strval($value);
            }

            default: {
                return $value;
            }
        }
    }
}
