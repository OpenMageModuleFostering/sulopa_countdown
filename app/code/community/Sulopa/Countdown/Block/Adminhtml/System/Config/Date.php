<?php
class Sulopa_Countdown_Block_Adminhtml_System_Config_Date extends Mage_Adminhtml_Block_System_Config_Form_Field{

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {
       $res = '';
		$divId = $element->getId();
    	$res .= <<<EOD
		<input name="{$element->getName()}" id="{$divId}_date" value="{$element->getValue()}" type="text" style="width:130px !important;" /> <img src="{$this->getSkinUrl('images/grid-cal.gif')}" alt="" id="{$divId}_date_trig" title="{$this->__('Select Date')}" style="" />
		<script type="text/javascript">
		//<![CDATA[
			//this example uses dd.MM.yyyy hh:mm format.
			Calendar.setup({
				inputField: "{$divId}_date",
				ifFormat: "%Y-%m-%d %H:%M:%S",
				showsTime: true,
				firstDay: 1,
				timeFormat: "24",
				button: "{$divId}_date_trig",
				align: "Bl",
				singleClick : true
			});
			
		//]]>
		</script>
EOD;
		return $res;
    }
}
?>