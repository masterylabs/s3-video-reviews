<?php

namespace S3VideoReviews;

use Masteryl\Helpers\Url;
use Masteryl\WPMenuPage\WPMenuPage;

class Admin extends WPMenuPage
{
    protected $icon_url = 'dashicons-tag';

    public function adminHead()
    {
        echo '<link rel="stylesheet" href="' . $this->app->getPluginUrl('public/css/admin.css') . '" />';

    }

    public function handle($req, $res)
    {
        $app = $this->app;

        // build authenticated url
        $url = $app->getAppUrl('/admin');
        $token = $app->userAuth->getAccessToken();
        $url = Url::append($url, ['auth_token' => $token, 'app_version' => $app->version]);

        $data = [
            'token' => $app->userAuth->getAccessToken(),
        ];

        if ($app->brand && $app->brand->isActive() && $app->brand->primary_color) {
            $data['primary_color'] = $app->brand->primary_color;
            $data['secondary_color'] = $app->brand->secondary_color;
            $data['accent_color'] = $app->brand->accent_color;
        }

        return $res->embedView('admin', compact('url', 'data'));

    }

    public function validateLoad()
    {

        $app = $this->app;

        $brand = $app->brand;

        if ($brand && $brand->isActive()) {
            $user = wp_get_current_user();

            $valid = $brand->userHasAccess($user);

            if ($valid) {
                $this->capability = 'read';
            }

            return $valid;
        }

        return true;
    }

}
