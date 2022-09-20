<?php

namespace Masteryl\Helpers;

class Vue
{
    protected $app;

    protected $doc;

    protected $id;

    protected $styles;

    protected $scripts;

    protected $data;

    protected $app_version;

    protected $sanitize_data = true;

    public function __construct($app, $file = 'client/index', $args = null)
    {
        $this->app = $app;

        if ($args) {
            $this->config($args);
        }

        $this->base_url = $app->getPluginUrl('public/' . dirname($file));

        $this->public_url = $app->getPluginUrl('public');

        $file = $app->getPath('public/' . $file . '.html');

        $html = file_get_contents($file);

        $doc = new \DOMDocument();

        // ee($html);

        $doc->loadHTML($html);

        $this->doc = $doc;
    }

    public function useVersion()
    {
        $this->app_version = $this->app->version;
        // ee(['useVersion', $this->app_version]);
        return $this;
    }

    public function config($args)
    {
        foreach ($args as $key => $val) {
            $this->{$key} = $val;
        }
    }

    private function escapeScriptHtml($html)
    {
        // ee('escape: ' . $html);
        $html = str_replace('<script ', "<scr' + 'ipt ", $html);
        return str_replace('</script>', "</scr' + 'ipt>", $html);
    }

    public function render()
    {
        $styles = $this->getStylesHtml();
        $div = $this->getDivHtml();
        $scripts = $this->getScriptsHtml();

        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title></title>
            ' . $styles . '
        </head>
        <body>
        ' . $div . '
        ' . $scripts . '
        </body>
        </html>';
    }

    public function iframe()
    {
        // if not already rendered in head
        // $this->renderStyles();
        $styles = $this->getStylesHtml();
        $div = $this->getDivHtml();
        $scripts = $this->getScriptsHtml();

        echo '<script>';

        // router support
        echo 'function mlhash(n) {
					window.location.hash = n;
				}';
        echo "var html = '<body onload=\"";
        echo "window.location.hash=\''+window.location.hash.substring(1)+'\';";
        echo '">';
        echo $styles;
        echo $div;

        // escaped scripts
        echo $this->escapeScriptHtml($scripts);

        echo "</body>";
        echo "';";
        echo "\n";

        // create iframe
        echo "var iframe = document.createElement('iframe');\n";
        echo "iframe.id = 'ml_app';\n";
        echo "iframe.setAttribute('scrolling', 'auto');\n";
        echo "iframe.setAttribute('frameborder', '0');\n\n";
        echo "iframe.setAttribute('class', 'ml-app');\n\n";

        // add iframe to page

        echo "var wrapper = document.getElementById('wpbody-content');\n";

        echo "wrapper.innerHTML = '';\n";
        echo "wrapper.appendChild(iframe);\n";
        echo "iframe.contentWindow.document.open();\n";
        echo "iframe.contentWindow.document.write(html);\n";
        echo "iframe.contentWindow.document.close();\n";

        echo '</script>';

        // exit();
    }

    /**
     * Renders
     */

    public function renderScripts()
    {
        $scripts = $this->getScripts();

        $this->renderItems($scripts);
    }

    public function renderDiv()
    {
        $div = $this->getDiv();

        $this->renderItem($div);
    }

    public function renderStyles()
    {
        $styles = $this->getStyles();

        $this->renderItems($styles);
    }

    /**
     * Builders
     */

    public function data($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->data[$k] = $v;
            }
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    public function api($api = null)
    {
        if (!$api) {
            $api = $this->app->getAppUrl('api');
        }
        $this->data['api'] = $api;
        return $this;
    }

    public function token($token = null)
    {
        $this->data['token'] = $token;
        return $this;
    }

    public function auth($auth)
    {
        $this->data['token'] = $auth->getAccessToken();
        return $this;
    }

    // public function renderScripts()
    // {
    //     //
    // }

    public function getDiv()
    {
        $divs = $this->doc->getElementsByTagName('div');

        $div = $this->getItem('div', $divs[0]);

        if ($this->sanitize_data) {
            $id = isset($div['atts']['id']) ? $div['atts']['id'] : false;
            $div['atts'] = [];
            if ($id) {
                $div['atts']['id'] = $id;
            }
        }

        if ($this->id) {
            $div['atts']['id'] = $this->id;
        }

        if ($this->data) {
            foreach ($this->data as $key => $val) {
                $div['atts']['data-' . $key] = $val;
            }
        }

        return $div;
    }

    public function getDivHtml()
    {
        return $this->getItemHtml($this->getDiv());
    }

    public function getScripts()
    {

        if ($this->scripts) {
            return $this->scripts;
        }

        $this->scripts = [];

        foreach ($this->doc->getElementsByTagName('script') as $item) {

            $this->scripts[] = $this->getItem('script', $item);
            // ee($item);
        }

        return $this->scripts;
    }

    public function getScriptsHtml()
    {
        return $this->getItemsHtml($this->getScripts());
    }

    public function getStyles()
    {
        if ($this->styles) {
            return $this->styles;
        }

        $this->styles = [];

        foreach ($this->doc->getElementsByTagName('link') as $item) {

            $rel = $item->getAttribute('rel');

            if ($rel === 'stylesheet') {
                $this->styles[] = $this->getItem('link', $item);
            }
        }

        return $this->styles;
    }

    public function getStylesHtml()
    {
        return $this->getItemsHtml($this->getStyles());
    }

    /**
     * Private Getters
     */

    // returns an object

    private function getItem($tag, $item)
    {
        $atts = [];

        foreach ($item->attributes as $i) {
            $key = $i->nodeName;
            $val = $i->nodeValue;

            if (in_array($key, ['href', 'src'])) {
                $val = $this->baseUrl($val);
                if ($this->app_version) {
                    $val = $this->urlAppendVersion($val);
                }

            }

            $atts[$key] = $val;
        }

        return [
            'tag' => $tag,
            'atts' => $atts,
        ];
    }

    private function urlAppendVersion($url)
    {
        if (strpos($url, '?') !== false) {
            $url .= '&app_version=' . $this->app_version;
        } else {
            $url .= '?app_version=' . $this->app_version;
        }

        return $url;
    }

    private function getItemHtml($item)
    {

        $html = '<' . $item['tag'];

        foreach ($item['atts'] as $key => $val) {
            $html .= ' ' . $key . '="' . $val . '"';
        }
        if ($item['tag'] === 'link') {
            $html .= '/>';
        } else {
            $html .= '></' . $item['tag'] . '>';
        }

        return $html;
    }

    private function getItemsHtml($items)
    {
        $html = '';
        foreach ($items as $item) {
            $html .= $this->getItemHtml($item);
        }
        return $html;
    }

    /**
     * Private Renders
     */

    private function renderItem($item, $escapeTag = true)
    {
        echo $this->getItemHtml($item);
    }

    private function renderItems($items)
    {
        foreach ($items as $item) {
            echo $this->getItemHtml($item);
        }
    }

    private function baseUrl($url)
    {
        if (strpos($url, '://') === false) {
            return $this->base_url . '/' . ltrim($url, '/');
        }
        return $url;
    }
}
