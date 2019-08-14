<?php
class Sulopa_Countdown_Controller_Router_Standard extends Mage_Core_Controller_Varien_Router_Standard{
     
    public function match(Zend_Controller_Request_Http $request){		 
		$storeenabled = Mage::getStoreConfig('countdown/countdown/enabled', $request->getStoreCodeFromPath());
		$clockenabled = Mage::getStoreConfig('countdown/countdown/settime', $request->getStoreCodeFromPath());
		$now = new DateTime(date('Y-m-d H:i:s'));
		$ref = new DateTime($clockenabled);
		$diff = $now->diff($ref);
		$days = ($diff->days)+(($diff->h+(($diff->i+($diff->s/60))/60))/24);
		$remailday = Mage::getStoreConfig('countdown/countdown/timer',Mage::app()->getStore())-$days;	
		if ($storeenabled){ 
			if($now >= $ref){
				if($remailday > 0){
				
					Mage::getSingleton('core/session', array('name' => 'adminhtml'));
					if (!Mage::getSingleton('admin/session')->isLoggedIn())
					{  
						Mage::getSingleton('core/session', array('name' => 'front'));
						
						$front = $this->getFront();
						$response = $front->getResponse();
						$response->setHeader('HTTP/1.1','503 Service Temporarily Unavailable');
						$response->setHeader('Status','503 Service Temporarily Unavailable');
						$response->setHeader('Retry-After','5000');
						$html = Mage::app()->getLayout()->createBlock('core/template')->setTemplate('Countdown/Countdown.phtml')->toHtml();
						$response->setBody(html_entity_decode( $html, ENT_QUOTES, "utf-8" )); 			$response->sendHeaders();
						$response->outputBody();
						
						exit;
					}
					else
					{				
						$showreminder = Mage::getStoreConfig('countdown/countdown/showreminder', $request->getStoreCodeFromPath());
						if ($showreminder)
						{
							$front = $this->getFront();
							$response = $front->getResponse()->appendBody('<div style="height:12px; background:red; color: white; position:relative; width:100%;padding:3px 0; z-index:100000;text-trasform:capitalize;">Offline</div>');
						}
					}
				}
			}
		}
		return parent::match($request);
        
    }   
}