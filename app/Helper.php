<?php
if (!function_exists('readJsonFile')) {
    /**
     * Returns a human readable file size
     *
     * @param string $path
     * Path to Json file
     *
     * @return string a string in human readable format
     *
     * */
    function human_file_size($path, $decimals = 2)
    {
        $sz = 'BKMGTPE';
        $factor = (int)floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $sz[$factor];
 
    }
}
