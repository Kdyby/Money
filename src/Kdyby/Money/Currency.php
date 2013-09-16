<?php

namespace Kdyby\Money;


final class Currency
{

    /** @var string */
    private $code;

    /** @var string */
    private $number;

    /** @var string */
    private $name;

    /** @var int */
    private $decimals;

    /** @var string[] */
    private $countries;


    /** @var Currency[] */
    private static $currencies = array();


    /**
     * @param array $record Record from CurrencyTable (code, number, name, decimals, countries)
     */
    private function __construct($record)
    {
        $this->code = $record['code'];
        $this->number = $record['number'];
        $this->name = $record['name'];
        $this->decimals = $record['decimals'];
        $this->countries = $record['countries'];
    }


    /** @return string */
    public function getCode()
    {
        return $this->code;
    }


    /** @return string */
    public function getNumber()
    {
        return $this->number;
    }


    /** @return string */
    public function getName()
    {
        return $this->name;
    }


    /** @return int */
    public function getDecimals()
    {
        return $this->decimals;
    }


    /** @return string[] */
    public function getCountries()
    {
        return $this->countries;
    }


    /**
     * @param string $code 3 letter ISO 4217 code
     * @return Currency
     * @throws InvalidArgumentException
     */
    public static function get($code)
    {
        if (!isset(static::$currencies[$code])) {
            $record = CurrencyTable::getRecord($code);
            if ($record === NULL) {
                throw new InvalidArgumentException("Currency code is not in a CurrencyTable.");
            }
            return static::$currencies[$code] = new static($record);
        }

        return static::$currencies[$code];
    }


    public function __clone()
    {
        throw new \Exception("Cloning is not allowed on this object.");
    }

}
