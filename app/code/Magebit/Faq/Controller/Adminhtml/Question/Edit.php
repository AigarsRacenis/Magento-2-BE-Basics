<?php

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magento\Backend\App\{
    Action\Context,
    Action
};
use Magento\Backend\Model\View\Result\Page;
use Magebit\Faq\Api\Data\QuestionInterfaceFactory;
use Magebit\Faq\Controller\Adminhtml\Question;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
class Edit extends Action implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var Question
     */
    protected $questionModel;

    /**
     * @var QuestionInterfaceFactory
     */
    protected $questionFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param QuestionInterfaceFactory $questionFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        QuestionInterfaceFactory $questionFactory,
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        $this->questionFactory = $questionFactory;
        parent::__construct($context);
    }

    /**
     * Edit action
     *
     * @return ResultInterface
     * SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = $this->questionFactory->create();

        // 2. Initial checking
        if ($id) {
            $model->load($id);

            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This question no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        // Register the model in the registry
        $this->coreRegistry->register('faq_question', $model);

        // 5. Build edit form
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Question') : __('New Question'),
            $id ? __('Edit Question') : __('New Question')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('FAQ Questions'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Question') : __('FAQ Question'));

        return $resultPage;
    }

    /**
     * Init page
     *
     * @param Page $resultPage
     * @return Page
     */
    protected function initPage(Page $resultPage)
    {
        $resultPage->setActiveMenu('Magebit_Faq::question')
            ->addBreadcrumb(__('FAQ'), __('FAQ'))
            ->addBreadcrumb(__('Questions'), __('Questions'));

        return $resultPage;
    }
}
