#!/usr/bin/php
<?php
	function get_image($url, $path)
	{
	    $curl = curl_init ($url);
	    curl_setopt($curl, CURLOPT_HEADER, FALSE);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	    $data = curl_exec($curl);
		if (curl_errno($curl))
			return ;
	    curl_close ($curl);
	    if(file_exists($path))
	            unlink($path);
	    if (!($fd = fopen($path,'w+')))
	            return ;
	    fwrite($fd, $data);
	    fclose($fd);
	}

	if ($argc != 2)
		return ;
	$url = $argv[1];
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
	$str = curl_exec($curl);
	if (curl_errno($curl))
		return ;

	libxml_use_internal_errors(true);
	$DOMdoc = DOMDocument::loadHTML($str);
	$imgs = $DOMdoc->getElementsByTagName('img');

	$parsed_url = parse_url($url);
	$dir_path = "./".parse_url($url)[host];

	if (!is_dir($dir_path))
		mkdir($dir_path);

	$parsed_url = parse_url(curl_getinfo($curl, CURLINFO_EFFECTIVE_URL));
	$img_url = array();
	foreach($imgs as $img)
		$img_url[] = $img->attributes->getNamedItem("src")->nodeValue;
	$img_url = array_filter($img_url, function ($v) {
		return (!empty($v));
	});

	$tab = array();
	foreach($img_url as $key => $value)
	{
		$value = parse_url($value);
		if (!isset($value[host]))
			$tab[$key][url] = $parsed_url[scheme]."://".$parsed_url[host]."/".$value[path];
		else
			$tab[$key][url] = $value[scheme]."://".$value[host]."/".$value[path];
		$buf = pathinfo($value[path]);
		$tab[$key][path] = $dir_path."/".$buf[filename].".".$buf[extension];
	}
	foreach($tab as $tab)
	{
		// echo "url : ".$tab[url]."  path : ".$tab[path]."\n";
		get_image($tab[url], $tab[path]);
	}
	curl_close($curl);
?>