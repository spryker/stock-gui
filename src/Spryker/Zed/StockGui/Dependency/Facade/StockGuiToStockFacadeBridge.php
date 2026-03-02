<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\StockGui\Dependency\Facade;

use Generated\Shared\Transfer\StockResponseTransfer;
use Generated\Shared\Transfer\StockTransfer;

class StockGuiToStockFacadeBridge implements StockGuiToStockFacadeInterface
{
    /**
     * @var \Spryker\Zed\Stock\Business\StockFacadeInterface
     */
    protected $stockFacade;

    /**
     * @param \Spryker\Zed\Stock\Business\StockFacadeInterface $stockFacade
     */
    public function __construct($stockFacade)
    {
        $this->stockFacade = $stockFacade;
    }

    public function updateStock(StockTransfer $stockTransfer): StockResponseTransfer
    {
        return $this->stockFacade->updateStock($stockTransfer);
    }

    /**
     * @return array<array<string>>
     */
    public function getWarehouseToStoreMapping()
    {
        return $this->stockFacade->getWarehouseToStoreMapping();
    }

    /**
     * @return array<array<string>>
     */
    public function getStoreToWarehouseMapping()
    {
        return $this->stockFacade->getStoreToWarehouseMapping();
    }

    public function findStockById(int $idStock): ?StockTransfer
    {
        return $this->stockFacade->findStockById($idStock);
    }

    public function findStockByName(string $stockName): ?StockTransfer
    {
        return $this->stockFacade->findStockByName($stockName);
    }

    public function createStock(StockTransfer $stockTransfer): StockResponseTransfer
    {
        return $this->stockFacade->createStock($stockTransfer);
    }
}
