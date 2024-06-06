<?php
foreach ($data as $value) {
	if (empty($value))
		continue;

	$id = $this->Id.'_'.str_replace(' ', '_', strtolower($value['label']));
	$id = str_replace('/', '_', strtolower($id));
	$style = "";
	$url = (!empty($value['url']) && $value['url'] != '#' ? Constant::baseUrl().'/'.$value['url'] : 'javascript:void(0)');
	$data_url = (!empty($value['url']) && $value['url'] != '#' ? $value['url'] : '');
	$class = "";
	$onclick = "";
	foreach ($value as $optional) {
		$class = (isset($optional['class']) ? 'class="'.$optional['class'].'"' : "");
		$id = (isset($optional['id']) ? $optional['id'] : $id);
		$style = (isset($optional['style']) ? 'style="'.$optional['style'].'"' : $style);
		$onclick = (isset($optional['onclick']) ? 'onclick="return '. $optional['onclick'] .'"' : '');
	}
	$icon = (isset($value['icon']) ? '<i class="fa '.$value['icon'].'"></i>' : '');
	echo '<a '.$class.' href="'. $url .'" id="'.$id.'" data-url="'. $data_url .'" '.$style.' '. $onclick .'>'.$icon.' '. $value['label'] .'</a>';
}
?>