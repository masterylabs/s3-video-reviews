<?php
namespace Masteryl\Modules\Schedule;

class Schedule
{
    protected $app;

    public $date;

    public $time;

    public $tz;

    protected $format =
        [
        'date',
        'time',
        'tz',
    ];

    public function __construct($app = null, $str = '')
    {
        if ($app) {
            $this->app = $app;
        }

        if ($str !== '') {
            $this->load($str);
        }
    }

    public function __call($name, $args = [])
    {
        if (method_exists($this, "_{$name}")) {
            return $this->{"_{$name}"}(...$args);
        }
    }

    // LOADERS

    public function load($str)
    {
        $i = explode(',', $str);

        foreach ($this->format as $index => $key) {
            if (isset($i[$index])) {
                $this->{$key} = $i[$index];
            }
        }

        return $this;
    }

    public static function valid($str = '', $app = null)
    {
        $class = new self($app, $str);
        return $class->_valid();
    }

    public static function expired($str = '', $app = null)
    {
        $class = new self($app, $str);
        return $class->_expired();
    }

    /**
     * Checks the date has not passed
     */

    public function _expired()
    {
        return !$this->_valid();
    }

    public function _valid()
    {
        $ts = $this->_getTimestamp();

        $secs = $ts - (int) date('U');

        $isComing = $secs > 0;

        return $isComing;

    }

    public function _getTimestamp()
    {
        foreach ($this->format as $key) {
            if (empty($this->{$key})) {
                return false;
            }
        }

        $time = explode(':', $this->time);
        $hrs = (int) $time[0];
        $mins = (int) $time[1];

        $tz = new \DateTimeZone($this->tz);
        $dt = new \DateTime($this->date, $tz);
        $dt->setTime($hrs, $mins);

        return (int) $dt->format('U');
    }

}
