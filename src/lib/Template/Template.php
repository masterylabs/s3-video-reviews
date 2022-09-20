<?php

namespace Masteryl\Template;

/**
 * MasteryLabs Template engine
 */
class Template
{
    protected $view_path;

    private $layout_temp; // temp

    public function __construct($app)
    {
        $this->view_path = $app->getPath('views');
        // ee('Template', $this->view_path);
    }

    public function getView($view, $vars = null, $ext = '.php')
    {
        $file = $this->view_path . '/' . str_replace('.', '/', $view) . $ext;

        $code = file_get_contents($file);
        $code = $this->extendLayout($code);
        $code = $this->compileIncludes($code);

        if (!empty($vars)) {
            $code = $this->parseVarables($code, $vars);
        }

        return $code;
    }

    private function extendLayout($code)
    {
        $regex = '/@extends\((.+?)\)/';

        $code = preg_replace_callback($regex, [$this, 'compileLayoutCallback'], $code);

        if (!$this->layout_temp) {
            return $code;
        }

        $layout = $this->layout_temp;
        unset($this->layout_temp);

        $regex = '/@section\((.+?)\)/';
        preg_match_all($regex, $code, $sections);

        foreach ($sections[1] as $index => $key) {
            $value = $this->getSectionContent($key, $code);
            $layout = str_replace("@yield({$key})", $value, $layout);
        }

        return $layout;

    }

    private function getSectionContent($key, $code)
    {
        $i = explode("@section({$key})", $code);
        $i = explode('@endsection', $i[1]);
        return $i[0];

    }

    public function compileLayoutCallback($match)
    {
        $file = $this->view_path . '/' . str_replace('.', '/', $match[1]) . '.php';

        $this->layout_temp = file_get_contents($file);

        return '';
    }

    //

    public function parseVarables($code, $vars = [])
    {
        // $objectVars = [];

        foreach ($vars as $key => $item) {
            if (is_object($item) || is_array($item)) {

                foreach ($item as $k => $v) {
                    $newKey = "{$key}.{$k}";
                    $vars[$newKey] = $v;
                }
                $vars[$key] = json_encode($item);
            }
        }
        // ee($vars);

        $code = str_replace('{{ ', '{{', $code);
        $code = str_replace(' }}', '}}', $code);

        $code = preg_replace_callback('/{{(.+?)}}/', function ($match) use ($vars) {
            return !empty($vars[$match[1]]) ? $vars[$match[1]] : $match[0];
        }, $code);

        // tidy up unused
        return preg_replace('/{{(.+?)}}/', '', $code);

    }

    public function compileIncludes($code)
    {
        $regex = '/@include\((.+?)\)/';

        return preg_replace_callback($regex, [$this, 'compileInclude'], $code);
    }

    public function compileInclude($match)
    {
        $file = $this->view_path . '/' . str_replace('.', '/', $match[1]) . '.php';

        return $this->compileIncludes(file_get_contents($file));

    }

}
