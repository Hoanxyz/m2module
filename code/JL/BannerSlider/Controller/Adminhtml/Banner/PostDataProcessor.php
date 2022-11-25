<?php


namespace JL\BannerSlider\Controller\Adminhtml\Banner;


class PostDataProcessor
{
    protected $messageManager;

    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->messageManager = $messageManager;
    }

    // Validate required columns
    public function validateRequireEntry(array $data)
    {
        $requiredFields = [
//            'image_desktop' => __('Image Desktop'),
//            'url' => __('URL'),
//            'status' => __('Status')
        ];
        $errorNo = true;

        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $errorNo = false;
                $this->messageManager->addError(
                    __('"%1" field is required', $requiredFields[$field])
                );
            }
        }
        return $errorNo;
    }
}