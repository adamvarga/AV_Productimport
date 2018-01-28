<?php

class AV_Productimport_Model_Importer {

    public function main() {
        $this->runProcess();
        $this->clearCache();
        $this->clearindex();
    }

    public function runProcess() {
        $file_name = Mage::getStoreConfig('tab1/general/file');
        $file = Mage::getBaseDir() . DS . 'var/uploads' . DS . $file_name;
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mtype = finfo_file($finfo, $file);
        finfo_close($finfo);
        try {
            if (strtolower($ext) == 'csv' && in_array($mtype, array('text/csv', 'text/anytext', 'text/plain', 'text/comma-separated-values', 'application/csv', 'application/excel', 'application/vnd.ms-excel', 'application/vnd.msexcel'))) {
                return $this->readData($file);
            }
        } catch (Exception $ex) {
            Mage::log('File: ' . $file . ' - wrong format error - ' . $e->getMessage(), Zend_Log::ERR, 'exception.log', true);
        }
    }

    protected function readData($file, $column_name = false) {
        try {
            $csv = new Varien_File_Csv();
            $csv_data = $csv->getData($file);
            if ($column_name) {
                $columns = array_shift($csv_data);
                foreach ($csvData as $k => $v) {
                    $csv_data[$k] = array_combine($columns, array_values($v));
                }
            }
            $this->setImportData($csv_data);
            return $csv_data;
        } catch (Exception $e) {
            Mage::log('File: ' . $file . ' - unable to read csv file - ' . $e->getMessage(), Zend_Log::ERR, 'exception.log', true);
        }
    }

    protected function setImportData($result) {
        foreach ($result as $lines => $line) {
            if ($lines == 0) {
                continue;
            }
            $data[] = array(
                '_store' => $line[0],
                '_product_websites' => $line[1],
                '_attribute_set' => $line[2],
                '_type' => $line[3],
                //'_root_category' => $line[4],
                //'_category' => $line[5],
                'sku' => $line[6],
                'name' => $line[7],
                'image' => $line[8],
                'small_image' => $line[9],
                'thumbnail' => $line[10],
                'url_key' => $line[11],
                'url_path' => $line[12],
                'price' => $line[13],
                'special_price' => $line[14],
                'cost' => $line[15],
                'weight' => $line[16],
                'status' => $line[17],
                'visibility' => $line[18],
                'tax_class_id' => $line[19],
                'shipment_type' => $line[20],
                'enable_googlecheckout' => $line[21],
                'description' => $line[22],
                'short_description' => $line[23],
                'special_from_date' => $line[24],
                'special_to_date' => $line[25],
                'news_from_date' => $line[26],
                'news_to_date' => $line[27],
                'qty' => $line[28],
                'min_qty' => $line[29],
                'use_config_min_qty' => $line[30],
                'is_qty_decimal' => $line[31],
                'backorders' => $line[32],
                'use_config_backorders' => $line[33],
                'min_sale_qty' => $line[34],
                'use_config_min_sale_qty' => $line[35],
                'max_sale_qty' => $line[36],
                'use_config_max_sale_qty' => $line[37],
                'is_in_stock' => $line[38],
                'low_stock_date' => $line[39],
                'notify_stock_qty' => $line[40],
                'use_config_notify_stock_qty' => $line[41],
                'manage_stock' => $line[42],
                'use_config_manage_stock' => $line[43],
                'stock_status_changed_auto' => $line[44],
                'use_config_manage_stock' => $line[45],
                'use_config_qty_increments' => $line[46],
                'qty_increments' => $line[47],
                'use_config_enable_qty_inc' => $line[48],
                'enable_qty_increments' => $line[49],
                'is_decimal_divided' => $line[50],
                'stock_status_changed_automatically' => $line[51],
                'use_config_enable_qty_increments' => $line[52],
                'store_id' => $line[53],
                'product_status_changed' => $line[54],
                'product_changed_websites' => $line[55],
                'price_view' => $line[56],
                'image_label' => $line[57],
                'small_image_label' => $line[58],
                'thumbnail_label' => $line[59],
                'meta_title' => $line[60],
                'meta_description' => $line[61],
                'country_of_manufacture' => $line[62],
                'stockings_color' => $line[63],
                'stockings_denier_number' => $line[64],
                'meta_keyword' => $line[65],
            );
        }
        /** @var $import AvS_FastSimpleImport_Model_Import */
        $import = Mage::getModel('fastsimpleimport/import');
        $success_msg = "CSV file is successfully uploaded with " . count($data) . " product(s)";
        $error_msg = "Error occurred while uploading the file to the server. See more details in exepction.log";
        try {
            $import->processProductImport($data);
            Mage::getSingleton("core/session")->addSuccess($success_msg);
        } catch (Exception $e) {
            Mage::log($import->getErrorMessages(), Zend_Log::ERR, 'exception.log', true);
            Mage::getSingleton("core/session")->addError($error_msg);
        }
    }

    protected function clearindex() {
        for ($i = 1; $i <= 9; $i++) {
            $process = Mage::getModel('index/process')->load($i);
            $process->reindexAll();
        }
    }

    protected function clearCache() {
        $allTypes = Mage::app()->useCache();
        foreach ($allTypes as $type => $cache) {
            Mage::app()->getCacheInstance()->cleanType($type);
        }
    }

}
