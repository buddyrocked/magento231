<?php


namespace Kemana\Ads\Model\ResourceModel;

class Ads extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('kemana_ads_ads', 'ads_id');
    }
}
