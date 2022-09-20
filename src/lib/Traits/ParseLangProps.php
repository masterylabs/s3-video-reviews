<?php

namespace Masteryl\Traits;

trait ParseLangProps
{
    public function parseLangProps($arr = [])
    {
        foreach ($arr as $key) {
            if ($this->{$key} && strpos($this->{$key}, 'LANG:') === 0) {
                $langKey = substr($this->{$key}, 5);
                $this->{$key} = $this->app->lang->{$langKey};
            }
        }
    }
}
