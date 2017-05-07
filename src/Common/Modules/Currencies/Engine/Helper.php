<?php

namespace Common\Modules\Currencies\Engine;

/**
 * Class Helper
 * @package Common\Modules\Currencies\Engine
 */
class Helper
{

    /**
     * @todo implement this
     * @param $price
     * @param $currency
     * @param bool|false $format
     * @return string
     */
    public static function convert($price, $currency, $format = false)
    {
        $currency = new Currency($currency);

        return $format ? self::format($price, $currency->getCode()) : $price;
    }

    /**
     * @todo this should me more complex
     * @param $price
     * @param Currency $currency
     * @return string
     */
    public static function format($price, $currency = null)
    {
        $currency = new Currency($currency);

        if (!$currency->isLoaded()) {
            $currency = Model::getActiveCurrency();
        }

        $price = number_format(bcdiv($price, 1, 2), 2);

        return str_replace(array('0,000.00', 'X'), array($price, $currency->getSymbol()), $currency->getFormat());
    }

    /**
     * @param \SpoonTemplate $tpl
     */
    public static function parse(\SpoonTemplate $tpl)
    {
        $tpl->assign('currency', Model::getActiveCurrency()->toArray());

        $tpl->mapModifier(
            'convertprice',
            array('Common\\Modules\\Currencies\\Engine\\Helper', 'convert')
        );
        $tpl->mapModifier(
            'formatprice',
            array('Common\\Modules\\Currencies\\Engine\\Helper', 'format')
        );
    }
}
