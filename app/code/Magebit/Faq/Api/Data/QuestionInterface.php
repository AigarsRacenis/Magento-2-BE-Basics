<?php

namespace Magebit\Faq\Api\Data;

interface QuestionInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    public const TABLE        = 'magebit_faq';
    public const ID           = 'id';
    public const QUESTION     = 'question';
    public const ANSWER       = 'answer';
    public const STATUS       = 'status';
    public const POSITION     = 'position';
    public const UPDATED_AT   = 'updated_at';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion();

    /**
     * Set question
     *
     * @param string $question
     * @return QuestionInterface
     */
    public function setQuestion($question);

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer();

    /**
     * Set answer
     *
     * @param string $answer
     * @return QuestionInterface
     */
    public function setAnswer($answer);

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus();

    /**
     * Set status
     *
     * @param int $status
     * @return QuestionInterface
     */
    public function setStatus($status);

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition();

    /**
     * Set position
     *
     * @param int $position
     * @return QuestionInterface
     */
    public function setPosition($position);

    /**
     * Get updated at timestamp
     *
     * @return string|null
     */
    public function getUpdatedAt();
}
