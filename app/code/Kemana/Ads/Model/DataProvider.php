<?php

namespace Kemana\Ads\Model;

use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    public function getData()
    {
        $items = $this->collection->getItems();

        //Replace icon with fileuploader field name
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();
            if ($model->getImage()) {
                $m['image'][0]['name'] = $model->getImage();
                $m['image'][0]['url'] = $this->getMediaUrl().$model->getImage();
                $fullData = $this->loadedData;
                $this->loadedData[$model->getId()] = array_merge($fullData[$model->getId()], $m);
            }

            if ($model->getImageMobile()) {
                $m['image_mobile'][0]['name'] = $model->getImageMobile();
                $m['image_mobile'][0]['url'] = $this->getMediaUrl().$model->getImageMobile();
                $fullData = $this->loadedData;
                $this->loadedData[$model->getId()] = array_merge($fullData[$model->getId()], $m);
            }
        }

        return $this->loadedData;
    }

    public function getMediaUrl()
    {
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl;
    }
}