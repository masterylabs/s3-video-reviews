<?php

namespace Masteryl\Traits;

trait LoadFills
{

    private function loadFills()
    {
        foreach ($this->fills as $i => $key) {
            if (strstr($key, '|') == true) {
                $part = explode('|', $key);
                $key = array_shift($part);
                $this->fills[$i] = $key;
                foreach ($part as $p) {
                    $pk = '_' . $p;

                    if (!$this->{$pk}) {
                        $this->{$pk} = [];
                    }
                    $this->{$pk}[] = $key;
                }

            }
        }
    }
}
