<?php

namespace S3VideoReviews;

use Masteryl\Controller\Controller;

class AdminApi extends Controller
{
    protected $authenticated;

    public function authenticated($req, $res)
    {
        $this->authenticated = true;

        return $this->index($req, $res);
    }

    public function unauthenticated($req, $res)
    {
        $this->authenticated = false;

        return $this->index($req, $res);
    }

    public function index($req, $res)
    {
        $authenticated = $this->authenticated;

        $app = $req->app;

        $brand = $app->brand;
        $brandActive = $brand && $brand->isActive();

        if ($brandActive) {
            $user = $app->getUser();
            $access = $brand->userHasAccess($user);
            if (!$access) {
                return;
            }

            $brandColors = $brand->getColors();

        } else {
            $brandColors = null;
        }

        // Settings
        $this->settings = $authenticated ? $app->settings->all() : null;

        $this->user = $authenticated ? [
            'authenticated' => true,
            'username' => $app->user->user_login,
            'is_admin' => $app->user->isAdmin(),
        ] : ['authenticated' => false];

        $this->license = $app->license;

        if (!$authenticated && $this->license && $this->license->valid) {
            unset($this->license->contact);
        }

        $this->config = [
            'brand_active' => $brandActive,
            'brand_colors' => $brandColors,
            'baseurl' => $app->baseurl,
            'access' => $app->access,
            'slug' => $app->slug,
            'public_url' => $app->getPluginUrl('public'),
            'app_url' => $app->getAppUrl(),
            // 'player_style' => $app->getPluginUrl('public/player/index.css'),
            // 'player_js' => $app->getPluginUrl('public/player/index.js'),
        ];

        $app->call('admin.api', $this);

        // ee($app->getAppUrl());

        $data = [
            'global' => [
                'lang' => $app->lang->get(),
            ],
            'store' => [
                'app' => [
                    'name' => $app->name,
                    'description' => $app->description,
                    'label' => $app->label,
                    'logo' => $app->logo,
                ],
                'config' => $this->config,
                'user' => $this->user,
                'settings' => $this->settings,
            ],
            'icons' => [
                'app' => 'mdi-email',
            ],
            'license' => $this->license,
            // 'authenticated' => $this->authenticated,
        ];

        return $res->json($data);
    }
}
