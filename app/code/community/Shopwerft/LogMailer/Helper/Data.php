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

class Shopwerft_LogMailer_Helper_Data
    extends Mage_Core_Helper_Abstract
{

    const CONFIG_PATH_ACTIVE         = 'dev/log/logmailingactive';
    const CONFIG_PATH_LOGFILES       = 'dev/log/logfiles';
    const CONFIG_PATH_RECEIVERS      = 'dev/log/receivers';

    /**
     * Check if sending out of log files is enabled.
     *
     * @param null|int|Mage_Core_Model_Store $store
     * @return bool
     */
    public function isActive($store = null)
    {
        return Mage::getStoreConfigFlag(self::CONFIG_PATH_ACTIVE, $store);
    }

    /**
     * Get the configured log files to observe.
     *
     * @param Mage_Core_Model_Store $store
     * @return array The log files configured in backend
     */
    public function getLogFiles(Mage_Core_Model_Store $store = null)
    {
        $config = Mage::getStoreConfig(self::CONFIG_PATH_LOGFILES, $store);
        return array_map('trim', explode("\n", $config));
    }

    /**
     * Get the notification receivers (email-addresses).
     *
     * @param Mage_Core_Model_Store $store
     * @return array
     */
    public function getReceivers(Mage_Core_Model_Store $store = null)
    {
        $config = Mage::getStoreConfig(self::CONFIG_PATH_RECEIVERS, $store);
        return array_map('trim', explode("\n", $config));
    }

}
