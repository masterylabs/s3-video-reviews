<?php

namespace Masteryl\WPEnque;

use Masteryl\Helpers\Str;

class WPEnque
{
    private $app;

    private $default_hook_count = 0;

    public function __construct($app)
    {
        $this->app = $app;
    }

    private function getHook($append = '')
    {
        return $this->app->getId($append);
    }

    /**
     * Styles
     */

    public function styles($items, $hook = null)
    {
        // ee('enqueScript', $items);
        return $this->queItems($items, 'css', $hook);
    }

    /**
     * Scripts
     */

    public function scripts($items, $hook = null)
    {
        return $this->queItems($items, 'js', $hook);
    }

    /**
     * Scripts, Styles
     */

    private function queItems($items, $itemType, $hook = null)
    {
        if (!$hook) {

            $this->default_hook_count++;

            $hook = $this->getHook("{$itemType}_{$this->default_hook_count}");
        }

        if (!is_array($items)) {
            $items = [$items];
        }

        $url = $this->app->getPublicUrl();

        // ee($url);

        $i = 0;

        foreach ($items as $item) {
            $i++;

            if (!is_array($item)) {
                $item = [
                    'src' => $item,
                ];
            }

            $handle = isset($item['handle']) ? $item['handle'] : "{$hook}-{$i}";

            $src = $item['src'];

            $deps = isset($item['deps']) ? $item['deps'] : [];

            $ver = isset($item['ver']) ? $item['ver'] : false;

            // Automatically put into public dir

            if (strpos($src, '://') === false) {

                if (!Str::endsWith($src, '.' . $itemType) && strpos($src, '?') === false) {
                    $src .= '.' . $itemType;
                }

                // automatically place into
                if (strpos($src, '/') === false) {
                    $src = "{$itemType}/{$src}";
                }

                // append plugin public url
                $src = "{$url}/" . ltrim($src, '/');
            }

            // JS

            if ($itemType === 'js') {

                $inFooter = !empty($item['in_footer']);

                wp_enqueue_script($handle, $src, $deps, $ver, $inFooter);
            }

            // CSS

            elseif ($itemType === 'css') {

                $media = isset($item['media']) ? $item['media'] : 'all';

                // ee(compact('media', 'handle', 'src'));

                wp_enqueue_style($handle, $src, $deps, $ver, $media);
            }

        }
    }

}
