# Nimbus 3D Products

Nimbus's Magento extension for viewing 3D models of your products.

More information: http://www.nimbusvisualization.com

You can install this module in various ways:

1) Download the Magento source archive from our GitHub repository (https://github.com/NimbusVisualization/nimbus-3dproducts), extract the files and upload to your Magento root folder. Make sure to flush the Magento cache. Make sure to logout once you're done.

2) Use `modman` to install the git repository for you:

    modman init
    modman clone https://github.com/nimbus/nimbus-3dproducts
    modman update nimbus-3dproducts

## Custom Magento Theme

To customize the templates for your Magento Theme, create a new template file for your theme:

	/app/design/frontend/YOURTHEME/default/template/nimbus/catalog/product/view/3dmodel.phtml

You may also edit the layout by overriding the XML found in:

	app/design/frontend/base/default/layout/nimbus.xml