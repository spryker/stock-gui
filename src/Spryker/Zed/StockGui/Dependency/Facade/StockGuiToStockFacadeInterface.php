<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\StockGui\Dependency\Facade;

use Generated\Shared\Transfer\StockResponseTransfer;
use Generated\Shared\Transfer\StockTransfer;

interface StockGuiToStockFacadeInterface
{
    public function updateStock(StockTransfer $stockTransfer): StockResponseTransfer;

    /**
     * @return array<array<string>>
     */
    public function getWarehouseToStoreMapping();

    /**
     * @return array<array<string>>
     */
    public function getStoreToWarehouseMapping();

    public function findStockById(int $idStock): ?StockTransfer;

    public function findStockByName(string $stockName): ?StockTransfer;

    public function createStock(StockTransfer $stockTransfer): StockResponseTransfer;
}
