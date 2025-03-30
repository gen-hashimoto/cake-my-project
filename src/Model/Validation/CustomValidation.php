<?php

namespace App\Model\Validation;

use Cake\Validation\Validation;

/**
 * カスタムバリデーション
 */

class CustomValidation extends Validation
{
    /**
     * 電話番号バリデーション
     * 数字で始まり、中は数字かハイフンを許可し、最後は数字で終わる文字列を許可します。
     * @param string $val
     * @return bool
     */
    public static function checkTel($val)
    {
        return (bool) preg_match('/^[0-9][0-9\-]+[0-9]$/', $val);
    }

    /**
     * 半角英数字バリデーション
     * @param string $val
     * @return bool
     */
    public static function checkAlphaNumeric($val)
    {
        return (bool) preg_match('/^[a-zA-Z0-9]+$/', $val);
    }
}
