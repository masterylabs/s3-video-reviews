<?php
namespace Masteryl\Modules\Access;

class Access
{
    protected $app;

    protected $options;

    public function __construct($app, $options)
    {
        $this->app = $app;

        $this->options = $options;

        if ($app->brand && $app->brand->isClient()) {

            $this->hide_license = true;

            $ids = $app->brand->getAddons();

            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $this->{$id} = true;
                }
            }

        } elseif ($app->license) {
            $addons = $app->license->getAddons();

            foreach ($addons as $addon) {
                $key = $addon->value;
                $this->{$key} = true;
            }

            // dev
            // $this->developer = true;
        }

    }

}
