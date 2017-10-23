<?php

namespace Lsk\EmailPDFBundle\Classes;

use Eluceo\iCal\Component\Calendar;
use Eluceo\iCal\Component\Event;
use Eluceo\iCal\Component\Timezone;
use Eluceo\iCal\Component\TimezoneRule;
use Eluceo\iCal\Property\Event\RecurrenceRule;
use Jenssegers\Date\Date;

class ICal {

    const TIME_FORMAT = 'Ymd\THis';

    /**
     * Create an ical string for an event in the CET timezone.
     *
     * @param Date   $from
     * @param Date   $to
     * @param string $name
     * @param string $description
     * @param string $location
     * @param string $domain
     * @param string $url
     * @param string $timeZone
     * @return string
     */
    public static function createEventCET(Date $from, Date $to, string $name, string $description, string $location, string $domain, string $url, string $timeZone = 'Europe/Berlin'): string {

        $timezone = new Timezone($timeZone);
        $timezone->addComponent(
            (new TimezoneRule(TimezoneRule::TYPE_STANDARD))
                ->setTzName('CET')
                ->setDtStart(new Date('1996-10-27 03:00:00'), new \DateTimeZone($timeZone))
                ->setTzOffsetFrom('+0200')
                ->setTzOffsetTo('+0100')
                ->setRecurrenceRule(
                    (new RecurrenceRule())
                        ->setFreq(RecurrenceRule::FREQ_YEARLY)
                        ->setByDay('-1SU')
                        ->setInterval(1)
                        ->setByMonth(10)
                )
        );
        $timezone->addComponent(
            (new TimezoneRule(TimezoneRule::TYPE_DAYLIGHT))
                ->setTzName('CEST')
                ->setDtStart(new Date('1981-03-29 02:00:00'), new \DateTimeZone($timeZone))
                ->setTzOffsetFrom('+0100')
                ->setTzOffsetTo('+0200')
                ->setRecurrenceRule(
                    (new RecurrenceRule())
                        ->setFreq(RecurrenceRule::FREQ_YEARLY)
                        ->setByDay('-1SU')
                        ->setInterval(1)
                        ->setByMonth(3)
                )
        );

        $vCalendar = new Calendar($domain);
        $vCalendar->addComponent($timezone);
        $vCalendar->addComponent(
            (new Event(uniqid()))->setDtStart($from, new \DateTimeZone($timeZone))
                ->setDtEnd($to, new \DateTimeZone($timeZone))
                ->setSummary($name)
                ->setDescription($description)
                ->setLocation($location)
                ->setUrl($url)
                ->setUseTimezone(true)
        );

        return $vCalendar->render();
    }
}
