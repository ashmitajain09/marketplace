<?php

/**
 * Apptha
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.apptha.com/LICENSE.txt
 *
 * ==============================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * ==============================================================
 * This package designed for Magento COMMUNITY edition
 * Apptha does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Apptha does not provide extension support in case of
 * incorrect edition usage.
 * ==============================================================
 *
 * @category    Apptha
 * @package     Apptha_Marketplace
 * @version     1.2
 * @author      Apptha Team <developers@contus.in>
 * @copyright   Copyright (c) 2017 Apptha. (http://www.apptha.com)
 * @license     http://www.apptha.com/LICENSE.txt
 *
 */
namespace Apptha\Marketplace\Controller\Adminhtml\Categories;

use Apptha\Marketplace\Controller\Adminhtml\Categories;

class Edit extends Categories {
    public function execute() {
        $catId = $this->getRequest ()->getParam ( 'id' );
        $model = $this->_objectManager->get ( 'Apptha\Marketplace\Model\Category' );
        if ($catId) {
            $model->load ( $catId );
            if (! $model->getId ()) {
                $this->messageManager->addError ( __ ( 'This Category no longer exists.' ) );
                $this->_redirect ( '*/*/' );
                return;
            }
        }
        // Restore previously entered form data from session
        $data = $this->_session->getNewsData ( true );
        if (! empty ( $data )) {
            $model->setData ( $data );
        }
        $this->_coreRegistry->register ( 'marketplace_sellercategory', $model );
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create ();
        $resultPage->setActiveMenu ( 'Apptha_Marketplace::main_menu' );
        return $resultPage;
    }
}
