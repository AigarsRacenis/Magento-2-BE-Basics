<?php

namespace Magebit\Faq\Controller\Adminhtml;

use Magento\Backend\App\{
    Action\Context,
    Action
};
use Magento\Framework\Registry;
use Magento\Backend\Model\View\Result\Page;

abstract class Question extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Magebit_Faq::question';

    /**
     * Registration level of a basic admin session
     *
     * @var egistry
     */
    protected $_coreRegistry;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     */
    public function __construct(Context $context, Registry $coreRegistry)
    {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param Page $resultPage
     * @return Page
     */
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Magebit_Faq::faq')
            ->addBreadcrumb(__('FAQ'), __('FAQ'))
            ->addBreadcrumb(__('Static Blocks'), __('Static Blocks'));
        return $resultPage;
    }
}
