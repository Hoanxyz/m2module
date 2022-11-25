<?php
namespace JL\BannerSlider\Controller\Index;

use Magento\Framework\App\Action\Context;
use JL\BannerSlider\Model\BannerFactory;

class Index extends \Magento\Framework\App\Action\Action
{

    protected $bannerFactory;

    public function __construct(
        Context $context,
        BannerFactory $bannerFactory
    )
    {
        $this->bannerFactory = $bannerFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        /**
         * Insert random data
         */
//        $extension = ['.png', '.jpg', '.gif'];
//        $url = ['https://www.google.com.vn/', 'http://www.w3schools.com/', 'https://techmaster.vn/'];
//
//        for ($i = 1; $i <= 100; $i++) {
//            // Create new instance before insert
//            $banner = $this->_objectManager->create('Robin\Bai2\Model\Banner');
//
//            // Insert data
//            $banner->addData([
//                'link' => $url[rand(0, 2)],
//                'image' => 'image' . $i . $extension[rand(0, 2)],
//                'sort_order' => $i,
//                'status' => rand(0, 1)
//            ])->save();
//        }

        /**
         * Select, update, delete
         */
//        // Select record with id = 1
//        $banner = $this->_objectManager->create('Robin\Bai2\Model\Banner');
//        $data = $banner->load(1)->getData();
//        print_r(json_encode($data));
//
//        // Update selected record
//        $data->setImage('logo.png')->setLink('google.com')->save();
//
//        // Delete selected record
//        $data->delete();

//        $banner = $this->_objectManager->create('JL\BannerSlider\Model\Banner');
//        $banner->addData([
//            'name' => 'test4',
//            'status' => 1,
//            'content_desktop' => 'test4',
//            'image_desktop' => 'test4',
//            'content_mobile' => 'test4',
//            'image_mobile' => 'test4',
//            'url' => 'test4'
//        ])->save();

//        $banner1 = $banner->load(1)->getData();
//        print_r($banner1);

        $banner = $this->bannerFactory->create();
        $collection = $banner->getCollection();

        $data = $collection->getData();

        print_r(json_encode($data));


        echo "<br/>Done.";
        exit;
    }

}