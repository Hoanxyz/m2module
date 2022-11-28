<?php

namespace JL\BannerSlider\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Banner extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('jl_bannerslider_banner', 'banner_id');
    }

    /**
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this|Banner
     */
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        // Get image data before and after save
        $oldImage = $object->getOrigData('image_desktop');
        $newImage = $object->getData('image_desktop');

        if ($newImage != null && $newImage != $oldImage) {
            $imageUploader = \Magento\Framework\App\ObjectManager::getInstance()
                ->get('JL\BannerSlider\BannerImageUpload');
            $imageUploader->moveFileFromTmp($newImage);
        }

        $oldImageMobile = $object->getOrigData('image_mobile');
        $newImageMobile = $object->getData('image_mobile');

        if ($newImageMobile != null && $newImageMobile != $oldImageMobile) {
            $imageUploader = \Magento\Framework\App\ObjectManager::getInstance()
                ->get('JL\BannerSlider\BannerImageUpload');
            $imageUploader->moveFileFromTmp($newImageMobile);
        }

        return $this;
    }
}