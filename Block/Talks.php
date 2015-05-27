<?php
namespace Mzeis\Mm15nl\Block;

use Magento\Framework\View\Element\Template;

class Talks extends Template
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Mage\Catalog\Model\Product
     */
    protected $talkProduct = null;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->logger = $logger;
        $this->productRepository = $productRepository;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve current product model
     *
     * @return \Magento\Catalog\Model\Product|null
     */
    public function getProduct()
    {
        if ($this->talkProduct === null) {
            try {
                $this->talkProduct = $this->productRepository->get($this->getTalkProductSku());
            } catch (Exception $e) {
                $this->logger->critical($e);
            }
        }
        return $this->talkProduct;
    }

    /**
     * @return string
     */
    public function getTalkProductSku()
    {
        return $this->scopeConfig->getValue('mzeis_mm15nl/talks/sku');
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->scopeConfig->getValue('mzeis_mm15nl/talks/title');
    }
}
