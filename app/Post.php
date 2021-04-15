<?php

/**
 * Class Post
 *
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string $created_at
 * @property string $layout
 */
class Post
{
    private array $attributes;

    /**
     * Post constructor.
     * From this point, you can customize what you want for the post data,
     * such as default layout, transform attributes...
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function link()
    {
        return "/posts/{$this->slug}.html";
    }

    public function description()
    {
        return $this->description ?? $this->findDescription();
    }

    protected function findDescription()
    {
        preg_match("/<p>(.*)<\/p>/", $this->content, $matches);

        return substr($matches[1] ?? '', 0, 160);
    }

    public function featureImage()
    {
        return $this->feature_image ?? $this->inferFeatureImage();
    }

    protected function inferFeatureImage()
    {
        preg_match('/<img.*?src="(.*?)"[^>]+>/', $this->content, $matches);

        return count($matches) ? html_entity_decode($matches[1]) : null;
    }

    public function attributes(): array
    {
        return $this->attributes;
    }

    public function __get(string $attribute)
    {
        return $this->attributes[$attribute] ?? null;
    }
}
