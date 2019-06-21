<?php


namespace Kemana\Ads\Model;

use Magento\Framework\Reflection\DataObjectProcessor;
use Kemana\Ads\Api\Data\AdsInterfaceFactory;
use Kemana\Ads\Model\ResourceModel\Ads as ResourceAds;
use Kemana\Ads\Model\ResourceModel\Ads\CollectionFactory as AdsCollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Kemana\Ads\Api\Data\AdsSearchResultsInterfaceFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Kemana\Ads\Api\AdsRepositoryInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

class AdsRepository implements AdsRepositoryInterface
{

    protected $dataAdsFactory;

    protected $dataObjectHelper;

    private $collectionProcessor;

    protected $dataObjectProcessor;

    protected $resource;

    protected $adsFactory;

    protected $adsCollectionFactory;

    protected $extensibleDataObjectConverter;
    protected $searchResultsFactory;

    protected $extensionAttributesJoinProcessor;

    private $storeManager;


    /**
     * @param ResourceAds $resource
     * @param AdsFactory $adsFactory
     * @param AdsInterfaceFactory $dataAdsFactory
     * @param AdsCollectionFactory $adsCollectionFactory
     * @param AdsSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceAds $resource,
        AdsFactory $adsFactory,
        AdsInterfaceFactory $dataAdsFactory,
        AdsCollectionFactory $adsCollectionFactory,
        AdsSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->adsFactory = $adsFactory;
        $this->adsCollectionFactory = $adsCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataAdsFactory = $dataAdsFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(\Kemana\Ads\Api\Data\AdsInterface $ads)
    {
        /* if (empty($ads->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $ads->setStoreId($storeId);
        } */
        
        $adsData = $this->extensibleDataObjectConverter->toNestedArray(
            $ads,
            [],
            \Kemana\Ads\Api\Data\AdsInterface::class
        );
        
        $adsModel = $this->adsFactory->create()->setData($adsData);
        
        try {
            $this->resource->save($adsModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the ads: %1',
                $exception->getMessage()
            ));
        }
        return $adsModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getById($adsId)
    {
        $ads = $this->adsFactory->create();
        $this->resource->load($ads, $adsId);
        if (!$ads->getId()) {
            throw new NoSuchEntityException(__('Ads with id "%1" does not exist.', $adsId));
        }
        return $ads->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->adsCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Kemana\Ads\Api\Data\AdsInterface::class
        );
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(\Kemana\Ads\Api\Data\AdsInterface $ads)
    {
        try {
            $adsModel = $this->adsFactory->create();
            $this->resource->load($adsModel, $ads->getAdsId());
            $this->resource->delete($adsModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Ads: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($adsId)
    {
        return $this->delete($this->getById($adsId));
    }
}
