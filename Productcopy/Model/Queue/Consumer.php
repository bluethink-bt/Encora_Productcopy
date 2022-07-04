<?php
/**
 * Encora Productcopy Module
 *
 * @category  Encora
 * @package   Encora_Productcopy
 */
namespace Encora\Productcopy\Model\Queue;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductFactory;
use Psr\Log\LoggerInterface;
use Encora\Productcopy\Model\Datamodel;


/**
 * Class Consumer
 * @package Encora\Productcopy\Model\Queue
 */
class Consumer
{
    const NEW_KEY_DATA = 'New';

    const USED_KEY_DATA = 'used';

    const REFURBISHED_KEY_DATA = 'refurbished';

    const USED_SKU_DATA = 'NEW';

    const NEW_REFURBISHED_KEY_DATA = 'REFURBISHED';

    const NEW_SKU_DATA = 'USED';

    const NEW_URL_DATA = 'new';

    const USED_URL_DATA = 'used';

    const NEW_TITLE_DATA = 'new';

    const USED_TITLE_DATA = 'used';

    /**
     * Logger Interface
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Consumer constructor.
     * @param StoreManagerInterface $storeManagerInterface
     * @param Product $product
     * @param ProductFactory $productFactory
     * @param Product\Copier $productCopier
     * @param LoggerInterface $logger
     * @param  \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection
     * @param Data $transcriptHelper
     */
    public function __construct(
        StoreManagerInterface $storeManagerInterface,
        Product $product,
        ProductFactory $productFactory,
        LoggerInterface $logger,
        \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection,
        Datamodel $transcriptHelper
    )
    {
        $this->storeManagerInterface = $storeManagerInterface;
        $this->_product = $product;
        $this->_productFactory = $productFactory;
        $this->logger = $logger;
        $this->productCollection = $productCollection;
        $this->transcriptHelper = $transcriptHelper;
    }

    public function process()
    {
        try{
         //function execute handles saving product object
        $queue = $this->_queueFactory->create();
        $collection = $this->productCollection->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('type_id', \Magento\Catalog\Model\Product\Type::TYPE_SIMPLE);
        foreach ($collection as $product) {
            $this->executeProducts($product->getId());
            $productCollectionArr[] = [
                    'type' => 'product',
                    'entity_id' => $product->getId(),
                    'priority' => 1,
                ];
        }
        }catch (\Exception $e){
            //logs to catch and log errors
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function executeProducts($entityId)
    {
     try{
          $createProductNew = $this->transcriptHelper->createProductNew($entityId);
          $createProductRefurnished = $this->transcriptHelper->createProductRefurbished($productId);
          if ($createProductNew && $createProductRefurnished ) {
              # code...
             return "Queue Executed Successfully";
          }else{
            return "No Products get Added";
          }

        }catch (\Exception $e){
            //logs to catch and log errors
            $this->logger->critical($e->getMessage());
        }

    }

}
