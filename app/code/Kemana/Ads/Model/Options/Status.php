<?php
namespace Kemana\Ads\Model\Options;

class Status implements \Magento\Framework\Option\ArrayInterface {

	public function toOptionArray(){
		$result = [];
		foreach(self::getOptionArray() as $index=>$value):
			$result[] = ['value'=>$index, 'label'=>$value];
		endforeach;

		return $result;
	}

	public static function getOptionArray(){
		return [
			'0' => 'Disable',
			'1' => 'Enable'
		];
	}

	public function getAllOptions()
    {
        $result = [];

        foreach (self::getOptionArray() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }

        return $result;
    }

    public function getOptionText($optionId)
    {
        $options = self::getOptionArray();

        return isset($options[$optionId]) ? $options[$optionId] : null;
    }
}