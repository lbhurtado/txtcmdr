<?php

if (!function_exists('build_nested_nodes')) {

    function build_nested_nodes($array, $field = 'name') {
        if (! is_array($array))
            $array = explode('.', $array);

    	$name = array_shift($array);

    	if (count($array)>0) {
	    	return array(
	    		$field => $name,
	    		'children' => array(build_nested_nodes($array))
	    	);    		
    	}
    	else
    		return array($field => $name);
    } 
}

if (!function_exists('remove_non_ascii_for_smsc_consumption')) {

    function remove_non_ascii_for_smsc_consumption($mobile) {
        return preg_replace("/[^A-Za-z0-9]/", '', $mobile);
    } 
}

if (!function_exists('excel_range_to_array')) {

    function test_alter(&$item1, $key, $prefix)
    {
        $item1 = "$prefix: $item1";
    }

    function excel_range_to_array($filename = null, $headers = true, $topleft = null) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $filename = $filename ?? storage_path(config('txtcmdr.path.spreadsheet'));
        $spreadsheet = $reader->load($filename);
        
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); 

        $topleft = $topleft ?? 'A1';
        $excel = $worksheet->rangeToArray("{$topleft}:{$highestColumn}{$highestColumnIndex}");


        $array = [];
        if ($headers === false) {
            $array = $excel;
        }
        else {
            $h1 = array_shift($excel);
            if ($headers === true)
                $headers = $h1;
            if (is_array($headers)) {
                foreach ($excel as $record) {
                    $array [] = array_combine($headers, $record); 
                }                
            }
        }

        return $array;
    } 
}