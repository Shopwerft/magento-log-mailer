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

class Shopwerft_LogMailer_Model_Filter
    extends Mage_Core_Model_Abstract
{

    /** @var array */
    protected $_files = array();

    /**
     * Add a single (string) or multiple log filenames (array) to filter.
     * @param string|array $filename
     * @return Shopwerft_LogMailer_Model_Filter
     */
    public function addLogfile($filename)
    {
        if(is_array($filename)) {
            $this->_files = array_merge($this->_files, $filename);
        } elseif(is_string($filename)) {
            $this->_files[] = $filename;
        }
        return $this;
    }

    /**
     * Get the log file lines as a report.
     *
     * @return string
     */
    public function getLines()
    {
        $resultLines = "Log Messages from ". $this->getDate();
        $logDir = Mage::getBaseDir('var').DS.'log'.DS;
        foreach($this->_files as $filename) {
            $file = $logDir . $filename;
            if(!file_exists($file)) {
                $resultLines .= "\n\nFile $filename does not exist!";
                continue;
            }

            $lines = file($file);

            $resultLines .= "\n\nFile $filename:\n\n";

            $matches = false;
            $linesCount = 0;
            foreach ($lines as $line_num => $line) {
                if(preg_match('#\A\d\d\d\d-\d\d-\d\d#', $line)) {
                    if(substr($line, 0, 10) == $this->getDate()) {
                        $matches = true;
                    } else {
                        $matches = false;
                    }
                }
                if($matches) {
                    $linesCount++;
                    $resultLines .= $line;
                }
            }

            if($linesCount == 0) {
                $resultLines .= "---";
            }
        }

        return $resultLines;
    }

}
