<?php

namespace Masteryl\Packages\MaterializeCss;

class MaterializeCss
{

    protected $page;

    public function __construct()
    {
        $this->page = json_decode(file_get_contents(__DIR__ . '/page.json'));
    }

    public function render()
    {
        $blocks = $this->page->content->blocks;

        $this->header();

        $this->navbar($blocks[1]);
        $this->hero($blocks[2]);
        // $this->welcome($blocks[2]);
        $this->welcome($blocks[3]);
        $this->services($blocks[4]);

        $this->parallax($blocks[5]);
        $this->author($blocks[6]);
        $this->faqs($blocks[7]);

        // open container

        // $this->navbar($blocks[1]);
        $this->footer();
        exit;
    }

    public function hero($item)
    {
        $template = $this->getTemplate('hero');
        $img = $item->content->img;
        $template = str_replace('{{ img.src }}', $img->src, $template);

        echo $template;
        // $entry = str_replace('{{ img.alt }}', $i->title->text, $entry);

    }

    public function navbar($item)
    {
        $template = $this->getTemplate('navbar');
        $itemTemplate = $this->getTemplate('navbar-item');

        // ee($item);
        $items = $item->content->items;

        $itemsStr = '';

        foreach ($items as $i) {
            $entry = $itemTemplate;

            $href = '#' . $i->section;

            $entry = str_replace('{{ text }}', $i->text, $entry);
            $entry = str_replace('{{ a.href }}', $href, $entry);
            $itemsStr .= $entry;
        }

        $template = str_replace('{{ items }}', $itemsStr, $template);

        echo $template;

    }

    public function welcome($item)
    {
        $heading = $item->content->heading;
        $subheading = $item->content->subheading;

        // ee($item);
        $content = $item->content->content;

        $contents = $this->getTemplate('welcome');

        $contents = str_replace('{{ heading.text }}', $heading->text, $contents);
        $contents = str_replace('{{ subheading.text }}', $subheading->text, $contents);
        $contents = str_replace('{{ content.html }}', $content->html, $contents);

        echo $contents;
    }

    public function services($item)
    {
        $template = $this->getTemplate('services');
        $itemTemplate = $this->getTemplate('services-item');

        $items = $item->content->items;

        $itemsStr = '';

        foreach ($items as $i) {
            $entry = $itemTemplate;
            $entry = str_replace('{{ img.src }}', $i->img->src, $entry);
            $entry = str_replace('{{ img.alt }}', $i->title->text, $entry);
            $entry = str_replace('{{ title.text }}', $i->title->text, $entry);
            $entry = str_replace('{{ content.html }}', $i->content->html, $entry);
            $itemsStr .= $entry;
        }

        $template = str_replace('{{ items }}', $itemsStr, $template);

        echo $template;
    }

    public function faqs($item)
    {
        $faqs = $this->getTemplate('faqs');
        $faqsItem = $this->getTemplate('faqs-item');

        $items = $item->content->items;

        $itemsStr = '';

        foreach ($items as $i) {
            $faq = $faqsItem;
            $faq = str_replace('{{ title.text }}', $i->title->text, $faq);
            $faq = str_replace('{{ content.html }}', $i->content->html, $faq);
            $itemsStr .= $faq;
        }

        $faqs = str_replace('{{ items }}', $itemsStr, $faqs);

        echo $faqs;

    }

    public function header()
    {
        $page = $this->page;
        $contents = $this->getTemplate('header');

        $contents = str_replace('{{ title }}', $page->title, $contents);
        $contents = str_replace('{{ description }}', $page->description, $contents);

        echo $contents;

    }

    public function footer()
    {
        // include __DIR__ . '/partials/footer.php';
        echo $this->getTemplate('sidenav2');
        $template = $this->getTemplate('footer');
        echo $template;exit;
    }

    public function author($item)
    {

        $img = $item->content->img;
        $heading = $item->content->heading;
        $subheading = $item->content->subheading;
        $content = $item->content->content;

        $contents = $this->getTemplate('author');

        $contents = str_replace('{{ img.src }}', $img->src, $contents);
        $contents = str_replace('{{ img.alt }}', $img->alt, $contents);
        $contents = str_replace('{{ heading.text }}', $heading->text, $contents);
        $contents = str_replace('{{ subheading.text }}', $subheading->text, $contents);
        $contents = str_replace('{{ content.html }}', $content->html, $contents);

        echo $contents;

    }

    public function parallax($item)
    {
        $contents = $this->getTemplate('parallax');

        $img = $item->content->img;
        $heading = $item->content->heading;
        $subheading = $item->content->subheading;

        $contents = str_replace('{{ img.src }}', $img->src, $contents);
        $contents = str_replace('{{ img.alt }}', $img->alt, $contents);
        $contents = str_replace('{{ headling.text }}', $heading->text, $contents);
        $contents = str_replace('{{ subheading.text }}', $subheading->text, $contents);

        echo $contents;
    }

    private function getTemplate($name)
    {
        return file_get_contents(__DIR__ . '/templates/' . $name . '.html');
    }

    public function renderBlock($block)
    {
        // $this->openContainer($item->container);
        include __DIR__ . '/partials/' . $block->name . '.php';
        // $this->closeContainer();
    }

    public function openContainer($value)
    {
        echo '<div class="container"';

        echo '>';
    }

    public function closeContainer()
    {
        echo '</div>';
    }

    // public function navbar($item)
    // {
    //     include __DIR__ . '/partials/header.php';

    // }

    private function renderlistItems($items, $args = [])
    {
        $wrapper = !empty($args['wrapper']) ? $args['wrapper'] : 'li';

        $linkArgs = [
            'color' => isset($args['linkColor']) ? $args['linkColor'] : '',
        ];

        foreach ($items as $item) {
            echo "<{$wrapper}>";
            $this->renderLink($item, $linkArgs);
            echo "</{$wrapper}>";
        }
    }

    private function renderLink($item)
    {
        if ($item->clickAction === 'section') {
            echo '<a href="#' . $item->section . '" class="grey-text text-darken-4">' . $item->text . '</a>';
        }
    }

    public function sample()
    {
        $this->header();
        include __DIR__ . '/sample.php';
        $this->footer();
        exit;
    }
}
