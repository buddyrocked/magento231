<?php


namespace Kemana\Ads\Model\Data;

use Kemana\Ads\Api\Data\AdsInterface;

class Ads extends \Magento\Framework\Api\AbstractExtensibleObject implements AdsInterface
{

    /**
     * Get ads_id
     * @return string|null
     */
    public function getAdsId()
    {
        return $this->_get(self::ADS_ID);
    }

    /**
     * Set ads_id
     * @param string $adsId
     * @return \Kemana\Ads\Api\Data\AdsInterface
     */
    public function setAdsId($adsId)
    {
        return $this->setData(self::ADS_ID, $adsId);
    }

    /**
     * Get title
     * @return string|null
     */
    public function getTitle()
    {
        return $this->_get(self::TITLE);
    }

    /**
     * Set title
     * @param string $title
     * @return \Kemana\Ads\Api\Data\AdsInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Kemana\Ads\Api\Data\AdsExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Kemana\Ads\Api\Data\AdsExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Kemana\Ads\Api\Data\AdsExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get link
     * @return string|null
     */
    public function getLink()
    {
        return $this->_get(self::LINK);
    }

    /**
     * Set link
     * @param string $link
     * @return \Kemana\Ads\Api\Data\AdsInterface
     */
    public function setLink($link)
    {
        return $this->setData(self::LINK, $link);
    }

    /**
     * Get image
     * @return string|null
     */
    public function getImage()
    {
        return $this->_get(self::IMAGE);
    }

    /**
     * Set image
     * @param string $image
     * @return \Kemana\Ads\Api\Data\AdsInterface
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Get status
     * @return string|null
     */
    public function getStatus()
    {
        return $this->_get(self::STATUS);
    }

    /**
     * Set status
     * @param string $status
     * @return \Kemana\Ads\Api\Data\AdsInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }
}
