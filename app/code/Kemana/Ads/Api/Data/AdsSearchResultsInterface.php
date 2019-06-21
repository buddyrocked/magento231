<?php


namespace Kemana\Ads\Api\Data;

interface AdsSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Ads list.
     * @return \Kemana\Ads\Api\Data\AdsInterface[]
     */
    public function getItems();

    /**
     * Set title list.
     * @param \Kemana\Ads\Api\Data\AdsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
