<?php
/**
 * Copyright © Magebit, Inc.
 */

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\ObjectManager;
use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magebit\Faq\Model\QuestionFactory;

/**
 * Save FAQ question action.
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    public const ADMIN_RESOURCE = 'Magebit_Faq::question_save';

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
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!$data) {
            return $resultRedirect->setPath('*/*/');
        }
        if (empty($data['id'])) {
            $data['id'] = null;
        }

            /** @var QuestionInterface $model */
            $model = $this->questionFactory->create();

            $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $model = $this->questionRepository->getById($id);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage(__('This question no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
        }

            $model->setData($data);

        try {
            $this->_eventManager->dispatch(
                'faq_question_prepare_save',
                ['question' => $model, 'request' => $this->getRequest()]
            );

            $this->questionRepository->save($model);
            $this->messageManager->addSuccessMessage(__('You saved the question.'));
            return $this->processResultRedirect($model, $resultRedirect, $data);
        } catch (LocalizedException $e) {
            $this->messageManager->addExceptionMessage($e->getPrevious() ?: $e);
        } catch (\Throwable $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong while saving the question.'));
        }

            $this->dataPersistor->set('faq_question', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
    }

    /**
     * Process result redirect
     *
     * @param QuestionInterface $model
     * @param Redirect $resultRedirect
     * @param array $data
     * @return Redirect
     */
    private function processResultRedirect($model, $resultRedirect, $data)
    {
        $this->dataPersistor->clear('faq_question');
        if ($this->getRequest()->getParam('back', false) === 'close') {
            return $resultRedirect->setPath(
                '*/*/',
                [
                    'id' => $model->getId(),
                    '_current' => true
                ]
            );
        }
        return $resultRedirect->setPath(
            '*/*/edit',
            [
                'id' => $model->getId(),
                '_current' => true
            ]
        );
    }
}
