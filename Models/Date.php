<?php

namespace CaritasApp\Models;

class Date
{
    private $dateTime = null;

    public function __construct(string $date = '', string $fromFormat = 'c')
    {
        if ($fromFormat === 'c') {
            $dateTime = new \DateTime($date, new \DateTimeZone('UTC'));
        } else {
            $dateTime = \DateTime::createFromFormat($fromFormat, $date);
        }
        if (!$dateTime) {
            return;
        }

        $this->dateTime = $dateTime;
    }

    public function format(string $format = 'd.m.Y H:i')
    {
        if (!$this->dateTime) {
            return '';
        }

        // modify time according to zone set in settings
        $zone = get_option('timezone_string');
        $dateTime = clone $this->dateTime;
        $dateTime->setTimezone(new \DateTimeZone($zone));

        return $dateTime->format($format);
    }

    public function __toString()
    {
        return $this->format();
    }
}
