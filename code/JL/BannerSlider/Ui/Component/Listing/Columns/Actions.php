<?php

namespace JL\BannerSlider\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\UrlInterface;

class Actions extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Url path
     */
    const BANNER_URL_PATH_EDIT = 'jlbannerslider/banner/edit';
    const BANNER_URL_PATH_DELETE = 'jlbannerslider/banner/delete';

    protected $urlBuilder;

    private $editUrl;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::BANNER_URL_PATH_EDIT
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            // Get column name
            $fieldName = $this->getData('name');

            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['banner_id'])) {
                    // Add Edit link
                    $item[$fieldName]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['banner_id' => $item['banner_id']]),
                        'label' => __('Edit')
                    ];

                    // Add Delete link
                    $item[$fieldName]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::BANNER_URL_PATH_DELETE, ['banner_id' => $item['banner_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete ${ $.$data.image }'),
                            'message' => __('Are you sure you wan\'t to delete this record?')
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}