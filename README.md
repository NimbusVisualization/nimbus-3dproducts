# Nimbus 3D Products

Nimbus's Magento extension for viewing 3D models of your products.

More information: http://www.nimbusvisualization.com

You can install this module in various ways:

1) Download the Magento source archive from our GitHub repository (https://github.com/nimbus/nimbus-3dproducts), extract the files and upload the files to your Magento root folder as follows:

Location | Destination
-------- | -----------
code | app/code/local/Nimbus/3dProducts
design/layout/* | app/design/frontend/base/default/layout/
design/template | app/design/frontend/base/default/template/nimbus/
design/adminhtml/template/nimbus/ | app/design/adminhtml/base/default/template/nimbus/
js | js/nimbus
skin/adminhtml | skin/adminhtml/base/default/nimbus
Nimbus_3dProducts.xml | app/etc/modules/Nimbus_3dProducts.xml


Make sure to flush the Magento cache. Make sure to logout once you're done.

2) Use `modman` to install the git repository for you:

    modman init
    modman clone https://github.com/nimbus/nimbus-3dproducts
    modman update nimbus-3dproducts

