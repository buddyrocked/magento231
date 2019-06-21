<?php


namespace Kemana\Ads\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface AdsRepositoryInterface
{

    /**
     * Save Ads
     * @param \Kemana\Ads\Api\Data\AdsInterface $ads
     * @return \Kemana\Ads\Api\Data\AdsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Kemana\Ads\Api\Data\AdsInterface $ads);

    /**
     * Retrieve Ads
     * @param string $adsId
     * @return \Kemana\Ads\Api\Data\AdsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($adsId);

    /**
     * Retrieve Ads matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Kemana\Ads\Api\Data\AdsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Ads
     * @param \Kemana\Ads\Api\Data\AdsInterface $ads
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Kemana\Ads\Api\Data\AdsInterface $ads);

    /**
     * Delete Ads by ID
     * @param string $adsId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($adsId);
}
