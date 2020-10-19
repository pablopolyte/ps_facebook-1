<?php

namespace PrestaShop\Module\PrestashopFacebook\Provider;

use PrestaShop\Module\PrestashopFacebook\API\FacebookClient;
use PrestaShop\Module\PrestashopFacebook\DTO\ContextPsFacebook;

class FacebookDataProvider
{
    /**
     * @var FacebookClient
     */
    protected $facebookClient;

    public function __construct(FacebookClient $facebookClient)
    {
        $this->facebookClient = $facebookClient;
    }

    /**
     * https://github.com/facebookarchive/php-graph-sdk
     * https://developers.facebook.com/docs/graph-api/changelog/version8.0
     **
     * @param array $fbe
     *
     * @return ContextPsFacebook|null
     */
    public function getContext(array $fbe)
    {
        if (isset($fbe['error'])) {
            return null;
        }

        $email = $this->facebookClient->getUserEmail();
        $businessManager = $this->facebookClient->getBusinessManager($fbe['business_manager_id']);
        $pixel = $this->facebookClient->getPixel($fbe['pixel_id']);
        $pages = $this->facebookClient->getPage($fbe['pages']);
        $ads = $this->facebookClient->getAds($fbe['business_manager_id']);
        $isCategoriesMatching = $this->facebookClient->getCategoriesMatching($fbe['catalog_id']);

        return new ContextPsFacebook(
            $email,
            $businessManager,
            $pixel,
            $pages,
            $ads,
            $isCategoriesMatching
        );
    }
}
