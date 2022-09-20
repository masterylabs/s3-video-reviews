<?php

namespace Masteryl\Router\Traits;

use Masteryl\Helpers\Inflect;
use Masteryl\Helpers\Str;

trait Collection
{

    public function collection($name, $subs = null, $args = [])
    {
        // from site to sites
        $path = Inflect::pluralize($name);

        $class = $this->app->plugin_namespace . '\\Collections\\' . Str::toCamel($name, true) . 'Collection';

        $this->_createRoute('get', $path . '/', [$class, 'index'], $args);
        $this->_createRoute('post', $path . '/', [$class, 'create'], $args);
        $this->_createRoute('get', $path . '/{id}', [$class, 'show'], $args);
        $this->_createRoute('post', $path . '/{id}', [$class, 'update'], $args);
        $this->_createRoute('post', $path . '/{id}/delete', [$class, 'destroy'], $args);
        $this->_createRoute('delete', $path . '/{id}', [$class, 'destroy'], $args);

        if (!$subs) {
            return $this;
        }

        if (is_string($subs)) {
            $subs = [$subs];
        }

        foreach ($subs as $sub) {
            // $sub = 'something-else-with-space';

            $subPath = $path . '/{id}/' . $sub;
            $subExt = '/{' . Inflect::singularize($sub) . '}';
            $cm = Str::toCamel($sub);
            $args['collection_sub'] = $cm;

            $this->_createRoute('get', $subPath, [$class, $cm . '_index'], $args);
            $this->_createRoute('post', $subPath, [$class, $cm . '_create'], $args);
            $this->_createRoute('get', $subPath . $subExt, [$class, $cm . '_show'], $args);
            $this->_createRoute('post', $subPath . $subExt, [$class, $cm . '_update'], $args);
            $this->_createRoute('post', $subPath . $subExt . '/delete', [$class, $cm . '_destroy'], $args);
            $this->_createRoute('delete', $subPath . $subExt, [$class, $cm . '_destroy'], $args);

        }

    }
}
