<?php


namespace Kemana\Ads\Model;

use Magento\Framework\Api\DataObjectHelper;
use Kemana\Ads\Api\Data\AdsInterface;
use Kemana\Ads\Api\Data\AdsInterfaceFactory;

class Ads extends \Magento\Framework\Model\AbstractModel
{

    protected $_eventPrefix = 'kemana_ads_ads';
    protected $adsDataFactory;

    protected $dataObjectHelper;


    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param AdsInterfaceFactory $adsDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Kemana\Ads\Model\ResourceModel\Ads $resource
     * @param \Kemana\Ads\Model\ResourceModel\Ads\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        AdsInterfaceFactory $adsDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Kemana\Ads\Model\ResourceModel\Ads $resource,
        \Kemana\Ads\Model\ResourceModel\Ads\Collection $resourceCollection,
        array $data = []
    ) {
        $this->adsDataFactory = $adsDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve ads model with ads data
     * @return AdsInterface
     */
    public function getDataModel()
    {
        $adsData = $this->getData();
        
        $adsDataObject = $this->adsDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $adsDataObject,
            $adsData,
            AdsInterface::class
        );
        
        return $adsDataObject;
    }
}
