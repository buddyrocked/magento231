<?php


namespace Kemana\Ads\Api\Data;

interface AdsInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const STATUS = 'status';
    const LINK = 'link';
    const IMAGE = 'image';
    const ADS_ID = 'ads_id';
    const TITLE = 'title';

    /**
     * Get ads_id
     * @return string|null
     */
    public function getAdsId();

    /**
     * Set ads_id
     * @param string $adsId
     * @return \Kemana\Ads\Api\Data\AdsInterface
     */
    public function setAdsId($adsId);

    /**
     * Get title
     * @return string|null
     */
    public function getTitle();

    /**
     * Set title
     * @param string $title
     * @return \Kemana\Ads\Api\Data\AdsInterface
     */
    public function setTitle($title);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Kemana\Ads\Api\Data\AdsExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Kemana\Ads\Api\Data\AdsExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Kemana\Ads\Api\Data\AdsExtensionInterface $extensionAttributes
    );

    /**
     * Get link
     * @return string|null
     */
    public function getLink();

    /**
     * Set link
     * @param string $link
     * @return \Kemana\Ads\Api\Data\AdsInterface
     */
    public function setLink($link);

    /**
     * Get image
     * @return string|null
     */
    public function getImage();

    /**
     * Set image
     * @param string $image
     * @return \Kemana\Ads\Api\Data\AdsInterface
     */
    public function setImage($image);

    /**
     * Get status
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return \Kemana\Ads\Api\Data\AdsInterface
     */
    public function setStatus($status);
}
