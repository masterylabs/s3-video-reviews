<?php

namespace S3VideoReviews;

use Masteryl\Template\Operations;
use Masteryl\Template\Snippets;
use S3VideoReviews\Models\Page;

class PageBuilder
{
    protected $app;

    protected $page;

    protected $parent_page;

    protected $settings;

    protected $is_preview = false;

    protected $names_only = false;

    protected $sett_fallbacks = [
        'google_analytics',
        'fb_pixel',
    ];

    // protected $args;

    public function __construct($app, $page)
    {
        $this->app = $app;

        if (!is_object($page)) {
            $page = Page::find($page);
        }

        if (!$page) {
            return;
        }

        $settings = $app->settings;
        // $settings->favicon = 'https://favicon.png';

        foreach ($this->sett_fallbacks as $i) {
            if (empty($page->{$i}) && $settings->{$i}) {
                $page->{$i} = $settings->{$i};
            }
        }

        if ($page->parent_id) {
            $parent = Page::find($page->parent_id);

            $opts = $page->opts;

            foreach (['bg', 'advanced', 'theme'] as $key) {
                if (empty($opts->{$key}) && !empty($parent->{$key})) {
                    $page->{$key} = $parent->{$key};
                }
            }

            // $optionalValues = ['favicon'];
            if (empty($page->favicon) && !empty($parent->favicon)) {
                $page->favicon = $parent->favicon;
            }

            if (empty($opts->footer)) {

                $footer = Operations::findItem($parent->body, 'footer', 'type');

                if ($footer) {
                    $pageFooter = Operations::findItem($page->body, 'footer', 'type');

                    foreach ($footer as $key => $val) {
                        $pageFooter->{$key} = $val;
                    }
                }
            }

            $this->parent_page = $parent;
        }

        $this->page = $page;
        $this->settings = $settings;

    }

    public function setPreview($value = true)
    {
        $this->is_preview = $value;
    }

    public function setNamesOnly($value = true)
    {
        $this->names_only = $value;
    }

    public function getPage()
    {
        $page = $this->page;

        $urlPrefix = $this->is_preview ? $this->app->getPluginUrl('public/client/') : '';

        $args = [
            'lang' => $this->getSetting('lang', 'en'),
            'dir' => $this->getSetting('dir', 'ltr'),
            'favicon' => $page->has('favicon') ? Snippets::favicon($page->favicon) : $page->favicon,
            'title' => $this->getTitle(),
            'head' => $this->getHead(),
            'body' => $this->getBody(),
            'footer' => $this->getFooter(),
            'url_prefix' => $urlPrefix,
        ];

        return $this->app->response->getView('offer', $args);

    }

    private function getSetting($key, $na = '')
    {
        return !empty($this->settings->{$key}) ? $this->settings->{$key} : $na;
    }

    private function getHead()
    {
        $page = $this->page;
        $str = '';

        if (!$this->is_preview) {

            // noIndex
            $noindex = $this->getPageProp('seo', 'noindex', false);
            // $sponsored = $this->getPageProp('seo', 'sponsored', false);
            $nofollow = $this->getPageProp('seo', 'nofollow', false);

            if (!empty($this->page->favicon)) {
                $str .= Snippets::favicon($this->page->favicon);
            }

            if (($noindex && $nofollow) || $this->page->page_type !== 'offer') {
                $str .= Snippets::meta('robots', 'noindex,nofollow');
                $str .= Snippets::meta('googlebot', 'noindex,nofollow');
            } elseif ($noindex) {
                $str .= Snippets::meta('robots', 'noindex');
                $str .= Snippets::meta('googlebot', 'noindex');
            } elseif ($nofollow) {
                $str .= Snippets::meta('robots', 'nofollow');
                $str .= Snippets::meta('googlebot', 'nofollow');
            }

            // description
            $content = $this->getPageProp('seo', 'description', false);
            $str .= $content ? Snippets::description($content) : '';

            // keywords
            $content = $this->getPageProp('seo', 'keywords', false);
            $str .= $content ? Snippets::keywords($content) : '';

            // og_type
            $content = $this->getPageProp('seo', 'og_type', 'website');
            $str .= Snippets::ogType($content);

            // og image
            $content = $this->getPageProp('seo', 'image', false);
            $str .= $content ? Snippets::image($content) : '';

            // header code
            if (!empty($page->fb_app_id)) {
                $str .= Snippets::fbAppId($page->fb_app_id);
            }

            // google analytics
            if (!empty($page->google_analytics)) {
                $str .= Snippets::googleAnalytics($page->google_analytics);
            }

            // facebook pixel
            if (!empty($page->fb_pixel)) {
                $str .= Snippets::fbPixel($page->fb_pixel);
            }

            // header code
            if (!empty($page->header_code)) {
                $str .= base64_decode($page->header_code);
            }

            // bg color
            $value = $this->getPageProp('bg', 'color', false);
            if ($value) {
                $str .= Snippets::bgColor($value);
            }

            // bg image
            $src = $this->getPageProp('bg', 'src', false);
            if ($src) {
                $args = [
                    'scale' => $this->getBgScale(),
                    'filter' => $this->getPageProp('bg', 'filter', ''),
                ];
                $str .= Snippets::bgImage($src, $args);
            }

        }

        // $data = $this->getPageData();

        if ($this->is_preview) {
            $data = [
                'is_preview' => true,
                'public_url' => $this->app->getPluginUrl('public'),
            ];

        } else {
            $data = $this->getPageData();
        }

        $str .= '<script> window._DATA = ' . json_encode($data) . ' </script>';

        return $str;
    }

    private function getBody()
    {
        $str = '';

        if ($this->getPageProp('bg', 'src', false)) {
            $str .= '<div class="bg-image"></div>';
        }

        return $str;
    }

    private function getFooter()
    {
        if (!empty($this->page->footer_code)) {
            return '<div class="footer-code">' . base64_decode($this->page->footer_code) . '</div>';
        }
        return '';
    }

    private function getTitle()
    {
        if (!empty($this->page->seo->title)) {
            return $this->page->seo->title;
        }

        if (!empty($this->page->name)) {
            return $this->page->name;
        }

        return '';
    }

    private function getPageData()
    {
        $data = [
            'data' => $this->page,
        ];

        // TODO:: trim data

        $sett = $this->settings;

        if (!empty($sett) && !empty($sett->cookies_notice_active)) {
            $text = !empty($sett->cookies_notice_text) ? $sett->cookies_notice_text : 'We use cookies';
            $btn_text = !empty($sett->cookies_notice_btn_text) ? $sett->cookies_notice_btn_text : 'OK!';
            $data['cookies_notice'] = compact('text', 'btn_text');
        } else {
            $data['no_cookies_notice'] = 1;
        }

        return $data;
    }

    protected function getPageProp($group, $key, $na = '')
    {
        if (!empty($this->page->{$group}->{$key})) {
            return $this->page->{$group}->{$key};
        }

        return $na;
    }

    public function getBgScale()
    {
        $bg = $this->page->bg;

        if (empty($bg) || empty($bg->filter) || strstr($bg->filter, 'blur(') == false) {
            return 1;
        }
        $i = explode('blur(', $bg->filter);
        $b = explode('p', $i[1]);
        $n = (int) $b[0];

        if (empty($n)) {
            return 1;
        }

        if ($n > 15) {
            return 1.2;
        }

        if ($n > 9) {
            return 1.1;
        }

        if ($n > 4) {
            return 1.05;
        }

        return 1.01;

    }
}
