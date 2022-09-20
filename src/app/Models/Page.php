<?php

namespace S3VideoReviews\Models;

use Masteryl\Helpers\KeyGen;
use Masteryl\Model\Model;

class Page extends Model
{
    protected $table = 'pages';

    protected $use_identifier = true;

    protected $fills = [
        'user_id|hidden',
        'parent_id',
        'page_type',
        'name',
        'description',
        'slug',
        'checkout_url',
        'cancel_url',
        'prod_name',
        'admin_image',
        'favicon',
        'theme|json',
        'meta|json',
        'header_code',
        'footer_code',
        'bg|json',
        'seo|json',
        'body|json',
        'opts|json',
        // 'is_home|bool',

        'bucket_name',
        'bucket_region',
        'bucket_cloudfront',
        'bucket_domain',
        'bucket_meta|json',
        'bucket_is_public|bool',

    ];

    public function beforeCreate()
    {
        // fill json fills
        foreach ($this->_json as $key) {
            if (empty($this->{$key})) {
                $this->{$key} = '{}';
            }
        }

        if ($this->page_type === 'offer') {
            $this->slug = 'index.html';
        } else {
            $this->slug = $this->page_type . '-' . KeyGen::make(16) . '.html';
        }

    }

    public function isPrimaryPage()
    {
        return empty($this->parent_id);
    }

    public function beforeDestroy()
    {
        if ($this->isPrimaryPage()) {

            $ids = $this->pages()->getIds();

            if (!empty($ids)) {
                $this->pages()->deleteIds($ids);
            }
        }

    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'parent_id');
    }
}
