<?php
namespace UgoRaffaele\OpinioniTrovaPrezzi\Block\Checkout\Onepage\Success;

class Tracking extends \Magento\Framework\View\Element\Template {
	
	protected $checkoutSession;
	protected $orderFactory;
	protected $scopeConfig;
	protected $registry;
	
	public function __construct(
		\Magento\Checkout\Model\Session $checkoutSession,
		\Magento\Sales\Model\OrderFactory $orderFactory,
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Framework\Registry $registry
	){
		$this->checkoutSession = $checkoutSession;
		$this->orderFactory = $orderFactory;
		$this->scopeConfig = $context->getScopeConfig();
		$this->registry = $registry;
		parent::__construct($context);
	}
	
	public function isModuleEnabled()
	{
		$moduleEnabled = $this->scopeConfig->getValue('opinionitrovaprezzi/general/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
		return $moduleEnabled;
	}
	
	public function getMerchantKey()
	{
		$merchantKey = $this->scopeConfig->getValue('opinionitrovaprezzi/general/merchant_key', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
		return $merchantKey;
	}
	
	public function getOrderID()
	{
		$lastorderId = $this->checkoutSession->getLastOrderId();
		return $lastorderId;
	}
	
	public function getCustomerEmail()
	{
		$lastorderId = $this->checkoutSession->getLastOrder()->getCustomerEmail();
		return $lastorderId;
	}
	
	public function getProducts()
	{
		$objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
		$orderObject = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($this->getOrderID());
		$products = $orderObject->getAllItems();
		return $products;
	}
	
	public function getOrderAmount()
	{
		$objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
		$orderObject = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($this->getOrderID());
		return number_format($orderObject['grand_total'], 2, '.', '');
	}
	
}
