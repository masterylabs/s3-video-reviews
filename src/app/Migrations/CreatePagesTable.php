<?php

namespace S3VideoReviews\Migrations;

use Masteryl\Migration\Migration;

class CreatePagesTable extends Migration
{
    protected $table = 'pages';

    public function up()
    {
        $this->id()
            ->identifier()
            ->integer('user_id')->unsigned()->nullable()
            ->integer('parent_id')->unsigned()->nullable()
            ->string('page_type', 25)

            ->string('name')
            ->text('description')
            ->string('slug')
            ->text('checkout_url')
            ->text('cancel_url')
            ->string('prod_name')->nullable()
            ->text('admin_image')

            ->string('favicon')->nullable()

            ->mediumtext('theme')
            ->mediumtext('meta')
            ->mediumtext('header_code')
            ->mediumtext('footer_code')
            ->mediumtext('opts')
            ->text('bg')
            ->text('seo')
            ->mediumtext('body')

        // bucket
            ->string('bucket_name')
            ->string('bucket_region', 25)
            ->string('bucket_cloudfront')
            ->string('bucket_domain')
            ->mediumtext('bucket_meta')
            ->boolean('bucket_is_public')

            ->timestamps()
            ->create();
    }
}
