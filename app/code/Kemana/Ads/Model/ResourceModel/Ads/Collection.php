<?php


namespace Kemana\Ads\Model\ResourceModel\Ads;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Kemana\Ads\Model\Ads::class,
            \Kemana\Ads\Model\ResourceModel\Ads::class
        );
    }
}
