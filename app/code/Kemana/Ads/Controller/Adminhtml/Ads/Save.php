<?php


namespace Kemana\Ads\Controller\Adminhtml\Ads;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;
    protected $imageUploader;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('ads_id');
        
            $model = $this->_objectManager->create(\Kemana\Ads\Model\Ads::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Ads no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            try {

                if (isset($data['image'][0]['name']) && isset($data['image'][0]['tmp_name'])) {
                    $data['image'] =$data['image'][0]['name'];
                    $this->imageUploader = \Magento\Framework\App\ObjectManager::getInstance()->get(
                        'Kemana\Ads\AdsImageUpload'
                    );
                    $this->imageUploader->moveFileFromTmp($data['image']);
                } elseif (isset($data['image'][0]['image']) && !isset($data['image'][0]['tmp_name'])) {
                    $data['image'] = $data['image'][0]['image'];
                } else {
                    $data['image'] = null;
                }

                if (isset($data['image_mobile'][0]['name']) && isset($data['image_mobile'][0]['tmp_name'])) {
                    $data['image_mobile'] =$data['image_mobile'][0]['name'];
                    $this->image_mobileUploader = \Magento\Framework\App\ObjectManager::getInstance()->get(
                        'Kemana\Ads\AdsImageUpload'
                    );
                    $this->image_mobileUploader->moveFileFromTmp($data['image_mobile']);
                } elseif (isset($data['image_mobile'][0]['image_mobile']) && !isset($data['image_mobile'][0]['tmp_name'])) {
                    $data['image_mobile'] = $data['image_mobile'][0]['image_mobile'];
                } else {
                    $data['image_mobile'] = null;
                }

                $model->setData($data);
            
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Ads.'));
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['ads_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Ads.'));
            }

            return $resultRedirect->setPath('*/*/edit', ['ads_id' => $this->getRequest()->getParam('ads_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    public function _filterFoodData(array $rawData)
    {
        //Replace icon with fileuploader field name
        $data = $rawData;
        if (isset($data['image'][0]['name'])) {
            $data['image'] = $data['image'][0]['name'];
        } else {
            $data['image'] = null;
        }

        if (isset($data['image_mobile'][0]['name'])) {
            $data['image_mobile'] = $data['image_mobile'][0]['name'];
        } else {
            $data['image_mobile'] = null;
        }
        return $data;
    }
}
