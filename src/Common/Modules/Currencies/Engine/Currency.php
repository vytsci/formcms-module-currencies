<?php

namespace Common\Modules\Currencies\Engine;

use Common\Core\Model as CommonModel;

/**
 * Class Currency
 * @package Common\Modules\Currencies\Engine
 */
class Currency
{
    /**
     * @todo should be loaded from admin
     *
     * @var array
     */
    private $translations = array(
        'en' => array(
            'eur' => array(
                'singular' => 'euro',
                'plural_nominative' => 'euros',
                'plural_genitive' => 'euros',
                'cents' => 'euro',
            )
        ),
        'lt' => array(
            'eur' => array(
                'singular' => 'euras',
                'plural_nominative' => 'eurai',
                'plural_genitive' => 'eurų',
                'cents' => '',
            )
        ),
    );

    private $code;

    private $ratio;

    private $symbol;

    private $format;

    private $default = false;

    private $loaded = false;

    public function __construct($code = null)
    {
        if (isset($code)) {
            $currencies = Model::getCurrencies();

            if (isset($currencies[$code])) {
                $currency = $currencies[$code];

                $this
                    ->setCode($currency['code'])
                    ->setRatio($currency['ratio'])
                    ->setSymbol($currency['symbol'])
                    ->setFormat($currency['format'])
                    ->setDefault($currency['default']);

                $this->loaded = true;
            }
        }
    }

    public function isLoaded()
    {
        return $this->loaded;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    public function getRatio()
    {
        return $this->ratio;
    }

    public function setRatio($ratio)
    {
        $this->ratio = $ratio;

        return $this;
    }

    public function getSymbol()
    {
        return $this->symbol;
    }

    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    public function isDefault()
    {
        return $this->default;
    }

    public function setDefault($default)
    {
        $this->default = (bool)$default;

        return $this;
    }

    private function getTranslation($language = null)
    {
        if ($language === null || !isset($this->translations[$language])) {
            $language = 'en';
        }

        return $this->translations[$language][strtolower($this->getCode())];
    }

    public function getWordByNumber($number, $language)
    {
        $last = intval(substr($number, -2));
        $translation = $this->getTranslation($language);

        if ($last == 1 || ($last > 20 && $last % 10 == 1)) {
            return $translation['singular'];
        } elseif (($last > 10 && $last < 20) || $last % 10 == 0) {
            return $translation['plural_genitive'];
        }

        return $translation['plural_nominative'];
    }

    public function getWordForCents($language)
    {
        $translation = $this->getTranslation($language);

        return $translation['cents'];
    }

    public function toArray()
    {
        return array(
            'code' => $this->getCode(),
            'ratio' => $this->getRatio(),
            'symbol' => $this->getSymbol(),
            'format' => $this->getFormat(),
            'default' => $this->isDefault(),
        );
    }

    public function save()
    {
        $currencies = Model::getCurrencies();

        foreach ($currencies as &$currency) {
            if ($this->isDefault()) {
                $currency['default'] = false;
            }
        }

        $currencies[$this->getCode()] = $this->toArray();

        CommonModel::get('fork.settings')->set('Currencies', 'currencies', $currencies);
        Model::invalidateCurrencies();
        $this->loaded = true;
    }

    public function delete()
    {
        $currencies = Model::getCurrencies();

        if (isset($currencies[$this->getCode()])) {
            unset($currencies[$this->getCode()]);
        }

        CommonModel::get('fork.settings')->set('Currencies', 'currencies', $currencies);
        Model::invalidateCurrencies();
        $this->loaded = false;
    }
}
