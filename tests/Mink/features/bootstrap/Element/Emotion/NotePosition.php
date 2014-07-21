<?php

namespace Emotion;

class NotePosition extends CartPosition
{
    /** @var array $selector */
    protected $selector = array('css' => 'div.table_row');

    /** @var array $namedSelectors */
    protected $namedSelectors = array(
        'remove'  => array('de' => 'Löschen',       'en' => 'Delete'),
        'order'   => array('de' => 'Kaufen',        'en' => 'Purchase'),
        'compare' => array('de' => 'Vergleichen',   'en' => 'Compare'),
        'details' => array('de' => 'Zum Produkt',   'en' => 'View product')
    );

    protected $cssLocator = array(
        'a-thumb' => 'a.thumb_image',
        'img' => 'img',
        'a-zoom' => 'a.zoom_picture',
        'a-title' => 'a.title',
        'div-supplier' => 'div.supplier',
        'p-number' => 'p.ordernumber',
        'p-desc' => 'p.desc',
        'strong-price' => 'strong.price',
        'a-detail' => 'a.detail'
    );

    /**
     * Searches an article from the array, that matches to the NotePosition.
     * If an article was found, the function will return its key, otherwise if no article matches, false will be returned
     * @param array $articles
     * @return bool|int
     */
    public function search($articles)
    {
        $elements = \Helper::findElements($this, $this->cssLocator, $this->cssLocator);

        foreach($articles as $key => $article)
        {
            $check = array();

            if (!empty($article['name'])) {
                $check[] = array($elements['a-thumb']->getAttribute('title'), $article['name']);
                $check[] = array($elements['img']->getAttribute('alt'), $article['name']);
                $check[] = array($elements['a-title']->getAttribute('title'), $article['name']);
                $check[] = array($elements['a-title']->getText(), $article['name']);
                $check[] = array($elements['a-detail']->getAttribute('title'), $article['name']);
            }

            if (!empty($article['supplier'])) {
                $check[] = array($elements['div-supplier']->getText(), $article['supplier']);
            }

            if (!empty($article['ordernumber'])) {
                $check[] = array($elements['p-number']->getText(), $article['ordernumber']);
            }

            if (!empty($article['text']) && isset($elements['p-desc'])) {
                $check[] = array($elements['p-desc']->getText(), $article['text']);
            }

            if (!empty($article['price'])) {
                $check[] = \Helper::toFloat(
                    array($elements['strong-price']->getText(), $article['price'])
                );
            }

            if (!empty($article['image'])) {
                $check[] = array($elements['img']->getAttribute('src'), $article['image']);
            }

            if (!empty($article['link'])) {
                $check[] = array($elements['a-thumb']->getAttribute('href'), $article['link']);
                $check[] = array($elements['a-title']->getAttribute('href'), $article['link']);
                $check[] = array($elements['a-detail']->getAttribute('href'), $article['link']);
            }

            $result = \Helper::checkArray($check);
            if ($result === true) {
                return $key;
            }
        }

        return false;
    }
}