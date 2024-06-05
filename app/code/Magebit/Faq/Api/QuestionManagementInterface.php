<?php
namespace Magebit\Faq\Api;

interface QuestionManagementInterface
{
    /**
     * Enable a question by its ID.
     *
     * @param int $questionId
     * @return bool
     */
    public function enableQuestion($questionId);

    /**
     * Disable a question by its ID.
     *
     * @param int $questionId
     * @return bool
     */
    public function disableQuestion($questionId);
}
