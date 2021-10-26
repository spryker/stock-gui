<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\StockGui\Communication\Controller;

use Generated\Shared\Transfer\StockResponseTransfer;
use Generated\Shared\Transfer\StockTransfer;
use Generated\Shared\Transfer\StoreRelationTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\StockGui\Communication\StockGuiCommunicationFactory getFactory()
 */
class CreateWarehouseController extends AbstractController
{
    /**
     * @uses \Spryker\Zed\StockGui\Communication\Controller\WarehouseController::listAction()
     *
     * @var string
     */
    protected const REDIRECT_URL = '/stock-gui/warehouse/list';

    /**
     * @var string
     */
    protected const MESSAGE_SUCCESS = 'Warehouse has been successfully saved';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function indexAction(Request $request)
    {
        $stockTabs = $this->getFactory()->createStockTabs();

        $stockTransfer = (new StockTransfer())->setStoreRelation(new StoreRelationTransfer());

        $stockForm = $this->getFactory()
            ->getStockForm($stockTransfer)
            ->handleRequest($request);

        if ($stockForm->isSubmitted() && $stockForm->isValid()) {
            return $this->handleStockForm($stockForm);
        }

        return $this->viewResponse([
            'stockForm' => $stockForm->createView(),
            'stockTabs' => $stockTabs->createView(),
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $stockForm
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function handleStockForm(FormInterface $stockForm): RedirectResponse
    {
        $stockResponseTransfer = $this->getFactory()
            ->getStockFacade()
            ->createStock($stockForm->getData());

        if ($stockResponseTransfer->getIsSuccessful()) {
            $this->addSuccessMessage(static::MESSAGE_SUCCESS);

            return $this->redirectResponse(static::REDIRECT_URL);
        }

        $this->setErrors($stockResponseTransfer);

        return $this->redirectResponse(static::REDIRECT_URL);
    }

    /**
     * @param \Generated\Shared\Transfer\StockResponseTransfer $stockResponseTransfer
     *
     * @return void
     */
    protected function setErrors(StockResponseTransfer $stockResponseTransfer): void
    {
        foreach ($stockResponseTransfer->getMessages() as $messageTransfer) {
            $this->addErrorMessage($messageTransfer->getValue());
        }
    }
}
