<?php
/**
 * @category Shopwerft
 * @package Shopwerft_LogMailer
 * @authors Shopwerft GmbH <info@shopwerft.com>
 * @developer Benjamin Wunderlich <b.wunderlich@shopwerft.com, http://www.shopwerft.com/>
 * @version 1.0.0
 * @copyright Shopwerft GmbH
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Shopwerft_LogMailer_Model_Cron
    extends Mage_Core_Model_Abstract
{

    /**
     * @param Mage_Cron_Model_Schedule $schedule
     */
    public function sendLog(Mage_Cron_Model_Schedule $schedule)
    {
        /** @var $helper Shopwerft_LogMailer_Helper_Data */
        $helper = Mage::helper('shopwerft_logmailer');

        if (!$helper->isActive()) {
            $schedule->setMessages('Disabled in system configuration.');
            return;
        }

        /** @var $logFilter Shopwerft_LogMailer_Model_Filter */
        $logFilter = Mage::getModel('shopwerft_logmailer/filter');
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
