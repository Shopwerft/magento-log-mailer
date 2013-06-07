<?php

/**
 * @category Shopwerft
 * @package Shopwerft_LogMailer
 * @authors Shopwerft GmbH <info@shopwerft.com>
 * @developer Benjamin Wunderlich <b.wunderlich@shopwerft.com, http://www.shopwerft.com/>
 * @version 0.1.0
 * @copyright Shopwerft GmbH
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Shopwerft_LogMailer_Model_Cron extends Mage_Core_Model_Abstract {


    public function sendLog($event)
    {
        /** @var $helper Shopwerft_LogMailer_Helper_Data */
        $helper = Mage::helper('swlogmailer');
        /** @var $logFilter Shopwerft_LogMailer_Model_Filter */
        $logFilter = Mage::getModel('swlogmailer/filter');
        $logFilter->setDate(date('Y-m-d', time() - 24*60*60)) // yesterday (all my troubles ...)
                  ->addLogfile($helper->getLogFiles());
        foreach($helper->getReceivers() as $receiver) {
            /** @var $email Mage_Core_Model_Email */
            $email = Mage::getModel('core/email');
            $email->setSubject('Log from ' . $logFilter->getDate())
                  ->setBody($logFilter->getLines())
                  ->setToEmail($receiver)
                  ->setToName($receiver)
                  ->setFromEmail($receiver)
                  ->setFromName($receiver)
                  ->send();
        }
    }

}