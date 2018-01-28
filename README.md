AV_Productimport BETA Version
=====================
Simple product import with AvS_FastSimpleImport
-------------------------------

Requirements
------------
- PHP >= 5.3.0
- AvS_FastSimpleImport http://avstudnitz.github.io/AvS_FastSimpleImport
- Required CSV Format: https://www.mag-manager.com/useful-articles/tipstricks/required-csv-file-values-for-error-free-magento-import-via-admin/

Compatibility
-------------
- Magento >= 1.6.0.0 / Magento EE >= 1.11.0.0

Installation Instructions
-------------------------
1. Install the extension via GitHub, and deploy with modman.
2. Clear the cache, logout from the admin panel and then login again.
3. Uplod CSV File at System -> Configuration -> CSV DATA CONFIG -> Upload.

Uninstallation
--------------
1. Remove all extension files from your Magento installation OR
2. Modman remove AV_Productimport & modman clean


ToDO & Fix Me:
------------
- Category import & assing to product
- Fix with another product type (conf., grouped etc.)
- Dashboard with imported data
- Transaction email for admin with import result

Support
-------
If you have any issues with this extension, open an issue on [GitHub](https://github.com/adamvarga).

Contribution
------------
Any contribution is highly appreciated. The best way to contribute code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developer
---------
Adam Varga
