<?php

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Api\{
    QuestionRepositoryInterface,
    Data\QuestionInterface
};
use Magento\Backend\App\{
    Action\Context,
    Action
};
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

class InlineEdit extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Magebit_Faq::edit';

    /**
     * @var QuestionRepositoryInterface
     */
    protected $questionRepository;

    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param QuestionRepositoryInterface $questionRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        QuestionRepositoryInterface $questionRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->questionRepository = $questionRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * Execute action
     *
     * @return ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        /** @var Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);

            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $questionId) {
                    try {
                        /** @var QuestionInterface $question */
                        $question = $this->questionRepository->getById($questionId);
                        $question->setData(array_merge($question->getData(), $postItems[$questionId]));
                        $this->questionRepository->save($question);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithQuestionId(
                            $question,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add question title to error message
     *
     * @param QuestionInterface $question
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithQuestionId(QuestionInterface $question, $errorText)
    {
        return '[Question ID: ' . $question->getId() . '] ' . $errorText;
    }
}
