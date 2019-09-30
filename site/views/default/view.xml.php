<?php // No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.application.component.view');


 class PcnwexportViewDefault extends JViewLegacy
{
	function display($tpl = null)
	{
	    
	    $document = JFactory::getDocument();
		$document->setMimeEncoding('application/xml');
	    
 
$db   = JFactory::getDBO();
$query = $db->getQuery(true);
//$query->select('products.product_sku AS sku, products.product_availability AS availability, products.modified_on AS modified, prices.product_price AS price');
//$query->from('#__virtuemart_products products LEFT JOIN #__virtuemart_product_prices prices ON products.virtuemart_product_id=prices.virtuemart_product_id');
$query->select('products.product_sku AS sku, products.product_availability AS availability, products.modified_on AS modified, prices.product_price AS price');
$query->from('#__virtuemart_products products LEFT JOIN #__virtuemart_product_prices prices ON products.virtuemart_product_id=prices.virtuemart_product_id');
$query->where('products.virtuemart_product_id IN (
SELECT * FROM
    ( SELECT virtuemart_product_id FROM #__virtuemart_product_categories WHERE virtuemart_category_id in (77,104,90,91,92,93,96,100,105,98,94,89,87,86,88,95,99,97,85,107,111,108,78) GROUP BY virtuemart_product_id
     ) AS subselect
    )');
$db->setQuery((string) $query);
$products = $db->loadObjectList();


/*SELECT products.product_sku AS sku, products.product_availability AS availability, products.modified_on AS modified, prices.product_price AS price FROM gblw_virtuemart_products products LEFT JOIN gblw_virtuemart_product_prices prices ON products.virtuemart_product_id=prices.virtuemart_product_id
WHERE products.virtuemart_product_id IN (
SELECT * FROM
    ( SELECT virtuemart_product_id FROM gblw_virtuemart_product_categories WHERE virtuemart_category_id in (113,120,120,125,127,131,129,121,117,118,122,123,124,126,128,119,114) GROUP BY virtuemart_product_id HAVING COUNT(*) > 1
     ) AS subselect
    )

*/	

  $products_xml = new SimpleXMLElement('<products></products>');
  
  
  
   foreach($products as $product) {
  
  $prod=$products_xml->addChild('product');
  
  if($product->sku) {
  $prod->addAttribute('sku', $product->sku);
  }
  
   if($product->price) {
  $prod->addChild('price',  $product->price);
   }
    if($product->availability) {
  $prod->addChild('availability',  $product->availability);
    }
    if($product->modified) {
  $prod->addChild('modified',  $product->modified);
    }
  

   }
   
  echo "<!-- PCNW EXPORT FROM VIRTUEMART ONLY FOR WATCHES . TOTAL: ".count($products)." PRODUCTS -->";
  echo $products_xml->asXML();
  

	
	}
}

?>