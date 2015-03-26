<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Theme\Model\Resource\Design;

/**
 * Core Design resource collection
 */
class Collection extends \Magento\Framework\Model\Resource\Db\Collection\AbstractCollection
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime
     */
    protected $dateTime;

    /**
     * @param \Magento\Framework\Data\Collection\EntityFactory $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Framework\Stdlib\DateTime $dateTime
     * @param mixed $connection
     * @param \Magento\Framework\Model\Resource\Db\AbstractDb $resource
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactory $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\Stdlib\DateTime $dateTime,
        $connection = null,
        \Magento\Framework\Model\Resource\Db\AbstractDb $resource = null
    ) {
        $this->dateTime = $dateTime;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    /**
     * Core Design resource collection
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magento\Theme\Model\Design', 'Magento\Theme\Model\Resource\Design');
    }

    /**
     * Join store data to collection
     *
     * @return \Magento\Theme\Model\Resource\Design\Collection
     */
    public function joinStore()
    {
        return $this->join(['cs' => 'store'], 'cs.store_id = main_table.store_id', ['cs.name']);
    }

    /**
     * Add date filter to collection
     *
     * @param null|int|string|\DateTime $date
     * @return $this
     */
    public function addDateFilter($date = null)
    {
        if ($date === null) {
            $date = $this->dateTime->formatDate(true);
        } else {
            $date = $this->dateTime->formatDate($date);
        }

        $this->addFieldToFilter('date_from', ['lteq' => $date]);
        $this->addFieldToFilter('date_to', ['gteq' => $date]);
        return $this;
    }

    /**
     * Add store filter to collection
     *
     * @param int|array $storeId
     * @return \Magento\Theme\Model\Resource\Design\Collection
     */
    public function addStoreFilter($storeId)
    {
        return $this->addFieldToFilter('store_id', ['in' => $storeId]);
    }
}
