<?php

class AV_Productimport_Model_Observer extends AV_Productimport_Model_Importer {

    public function run() {
        return $this->main();
    }

}
