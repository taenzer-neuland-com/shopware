<?php
namespace Responsive;

use Behat\Mink\Driver\SahiDriver;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Behat\Mink\Exception\ResponseTextException;
use Behat\Behat\Context\Step;
use Behat\Behat\Context\Step\Then;

class Sitemap extends \Emotion\Sitemap
{
    public $cssLocator = array(
        'sitemapGroups' => 'div.sitemap--content div.sitemap--category',
        'sitemapNodes' => 'div > ul > ul > li',
        'sitemapSubNodes' => 'li > ul > li',
        'nodeLink' => 'li > a',
        'navigationNodes' => 'ul.categories--navigation.is--level0 > li'
    );
}