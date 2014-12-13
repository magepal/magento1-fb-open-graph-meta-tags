<?php
/**
 * Facebook Page Block
 *
 * @package    MagePal_FbOpenGraphMetaTags_Block_Tags
 * @author     R.S <rs@magepal.com>
 */

class MagePal_FbOpenGraphMetaTags_Block_Tags extends Mage_Core_Block_Template{
    
    private $tags = array(
        'og:title' => null,
        'og:type' => null,
        'og:image' => null,
        'og:description' => null,
        'og:url' => null,
        'og:site_name' => null,
        'fb:app_id' => null,
        'og:locale' => null,
        'og:locale:alternate' => null,
        'article:author' => null,
        'article:publisher' => null   
    );
    
    private $systemConfigTranslation = array(
        'fb_app_id' => 'fb:app_id',
        'og_locale' => 'og:locale',
        'og_locale_alternate' => 'og:locale:alternate',
        'article_author' => 'article:author',
        'article_publisher' => 'article:publisher'
    );

    
    /**
     * Get system config array
     *
     * @return string
     */
    public function getConfigValueArray(){
        return (array) Mage::getStoreConfig("fbopengraphmetatags/general_option");
    }
    
    
    public function getTags(){
        $this->tags['og:url'] = $this->helper('core/url')->getCurrentUrl();
        $this->tags['og:site_name'] = Mage::app()->getStore()->getName();
        $this->tags['og:type'] = 'website';
        $this->tags['og:title'] = $this->getLayout()->getBlock('head')->getTitle();
        $this->tags['og:description'] = $this->getLayout()->getBlock('head')->getDescription();
        
        //If on the product page
        if($product = Mage::registry('current_product')){
            $this->tags['og:type'] = 'product';
            $this->tags['og:title'] = $product->getName();
            $this->tags['og:description'] = $product->getShortDescription() ? $product->getShortDescription() : $this->tags['og:description'];
            $this->tags['og:image'] = $this->helper('catalog/image')->init($product, 'image')->resize(500,500);
        }
       
        foreach($this->getConfigValueArray() as $key => $value){
            if(array_key_exists($key, $this->systemConfigTranslation)){
                $this->tags[$this->systemConfigTranslation[$key]] = $value;
            }
        }
        
        return $this->tags;
    }
}
