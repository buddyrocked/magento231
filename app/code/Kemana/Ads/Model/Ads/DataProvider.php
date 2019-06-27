<?php


namespace Kemana\Ads\Model\Ads;

use Kemana\Ads\Model\ResourceModel\Ads\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $dataPersistor;

    protected $collection;

    protected $loadedData;

    /**
     * @var array
     */
    public $_storeManager;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->_storeManager=$storeManager;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $baseurl =  $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Magento\Cms\Model\Block $block */
        foreach ($items as $model) {
            $temp = $model->getData();
            if($temp['image']):
                $img = [];
                $img[0]['image'] = $temp['image'];
                $img[0]['url'] = $baseurl.'test/'.$temp['image'];
                $temp['image'] = $img;
            endif;

            if($temp['image_mobile']):
                $img_mobile = [];
                $img_mobile[0]['image'] = $temp['image_mobile'];
                $img_mobile[0]['url'] = $baseurl.'test/'.$temp['image_mobile'];
                $temp['image_mobile'] = $img_mobile;
            endif;            

            $data = $this->dataPersistor->get('model');
            if (!empty($data)) {
                $model = $this->collection->getNewEmptyItem();
                $model->setData($data);
                $this->loadedData[$model->getLabelId()] = $model->getData();
                $this->dataPersistor->clear('model');
            }else {
                if($items):
                    if ($model->getData('image') != null || $model->getData('image_mobile') != null) {

                        $t2[$model->getId()] = $temp;     
                         
                        return $t2;
                    } else {                
                         
                    
                       return $this->loadedData;
                        
                    }
                endif;
            }
        }

        return $this->loadedData;
    }
}
