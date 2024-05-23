<?php

declare(strict_types=1);

namespace Magebit\PageListWidget\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory as PageCollectionFactory;

class PageList extends Template implements BlockInterface
{
    public const DISPLAY_MODE_SPECIFIC = 'specific';
    public const DISPLAY_MODE_ALL = 'all';

    /**
     * @var string
     */
    protected $_template = "Magebit_PageListWidget::page-list.phtml";

    /**
     * @var PageCollectionFactory
     */
    protected $pageCollectionFactory;

    /**
     * @param Template\Context $context
     * @param PageCollectionFactory $pageCollectionFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        PageCollectionFactory $pageCollectionFactory,
        array $data = []
    ) {
        $this->pageCollectionFactory = $pageCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Gets titles
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getData('title');
    }

    /**
     * Gets pages
     *
     * @return \Magento\Cms\Model\ResourceModel\Page\Collection | null
     */
    public function getPages(): ?\Magento\Cms\Model\ResourceModel\Page\Collection
    {
        $displayMode = $this->getData('display_mode');

        if ($displayMode == self::DISPLAY_MODE_ALL) {
            $pages = $this->pageCollectionFactory->create()->addFieldToFilter('is_active', 1)->setOrder('title', 'ASC');
            return $pages;
        } elseif ($displayMode == self::DISPLAY_MODE_SPECIFIC) {
            $pageIds = $this->getData('page_list');
            if (!empty($pageIds)) {
                $pages = $this->pageCollectionFactory
                ->create()
                ->addFieldToFilter('page_id', ['in' => $pageIds])
                ->addFieldToFilter('is_active', 1)
                ->setOrder('title', 'ASC');
                return $pages;
            }
        }

        return null;
    }
}
