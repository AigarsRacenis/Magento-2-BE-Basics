<?php

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magento\Backend\App\{
    Action\Context,
    Action
};
use Magebit\Faq\Api\{
    Data\QuestionInterface,
    QuestionRepositoryInterface
};
use Magebit\Faq\Model\QuestionFactory;
use Magento\Framework\App\{
    Action\HttpPostActionInterface,
    Request\DataPersistorInterface,
    ObjectManager
};
use Magento\Framework\Controller\{
    ResultInterface
};
use Magento\Framework\Exception\LocalizedException;

class Delete extends Action implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var QuestionRepositoryInterface
     */
    protected $questionRepository;

    /**
     * @var QuestionFactory
     */
    private $questionFactory;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param QuestionRepositoryInterface $questionRepository
     * @param QuestionFactory|null $questionFactory
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        QuestionRepositoryInterface $questionRepository,
        QuestionFactory $questionFactory = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->questionRepository = $questionRepository;
        $this->questionFactory = $questionFactory ?: ObjectManager::getInstance()->get(QuestionFactory::class);
        parent::__construct($context);
    }

    /**
     * Delete question
     *
     * @return ResultInterface
     * SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        /** @var QuestionInterface $model */
        $model = $this->questionFactory->create();
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
                $model = $this->questionRepository->DeleteById($id);
                $this->messageManager->addSuccessMessage(__('You deleted the question.'));
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a question to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}
