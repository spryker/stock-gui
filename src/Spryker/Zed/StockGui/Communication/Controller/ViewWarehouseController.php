<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\StockGui\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\StockGui\Communication\StockGuiCommunicationFactory getFactory()
 */
class ViewWarehouseController extends AbstractController
{
    /**
     * @var string
     */
    public const PARAM_ID_STOCK = 'id-stock';

    /**
     * @var string
     */
    protected const REDIRECT_URL = '/stock-gui/warehouse/list';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function indexAction(Request $request)
    {
        $idStock = $this->castId($request->query->get(static::PARAM_ID_STOCK));
        $stockTransfer = $this->getFactory()
            ->getStockFacade()
            ->findStockById($idStock);

        if ($stockTransfer === null) {
            return $this->redirectResponse(static::REDIRECT_URL);
        }

        $storeToStockMapping = $this->getFactory()->getStockFacade()->getStoreToWarehouseMapping();

        return $this->viewResponse([
            'stock' => $stockTransfer,
            'storeToStockMapping' => $storeToStockMapping,
        ]);
    }
}
