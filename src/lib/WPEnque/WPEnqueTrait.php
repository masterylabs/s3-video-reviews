<?php

/**
 * Requires app property
 */

namespace Masteryl\WPEnque;

use Masteryl\WPEnque\WPEnque;

trait WPEnqueTrait
{
    protected $scripts;

    protected $styles;

    private $_enque;

    public function enqueueStyles($hook = null)
    {
        if ($this->styles) {
            $this->enque()->styles($this->styles, $hook);
        }
    }

    public function enqueueScripts($hook = null)
    {
        if ($this->scripts) {
            $this->enque()->scripts($this->scripts, $hook);
        }

    }

    public function enque()
    {
        if (!isset($this->_enque)) {
            $this->_enque = new WPEnque($this->app);
        }
        return $this->_enque;
    }
}
