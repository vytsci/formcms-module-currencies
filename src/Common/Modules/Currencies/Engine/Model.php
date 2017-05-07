<?php

namespace Common\Modules\Currencies\Engine;

use Common\Core\Model as CommonModel;

/**
 * Class Model
 * @package Common\Modules\Currencies\Engine
 */
class Model
{

    /**
     * @var array
     */
    private static $currencies = array();

    /**
     * @return array
     */
    public static function getCurrencies()
    {
        if (empty(self::$currencies)) {
            $currencies = CommonModel::get('fork.settings')->get('Currencies', 'currencies', array());
            self::$currencies = (array)$currencies;
        }

        return self::$currencies;
    }

    /**
     *
     */
    public static function invalidateCurrencies()
    {
        self::$currencies = array();
    }

    /**
     * @return Currency
     */
    public static function getDefaultCurrency()
    {
        self::getCurrencies();

        $code = null;

        foreach (self::$currencies as $currency) {
            if ($currency['default']) {
                $code = $currency['code'];
            }
        }

        return new Currency($code);
    }

    /**
     * @todo implement this
     * @return Currency
     */
    public static function getActiveCurrency()
    {
        return self::getDefaultCurrency();
    }

    /**
     * @return array
     */
    public static function getFormatsForDropdown()
    {
        return array(
            '0,000.00 X' => '0,000.00 X',
            '0,000.00X' => '0,000.00X',
            'X 0,000.00' => 'X 0,000.00',
            'X0,000.00' => 'X0,000.00',
        );
    }
}
