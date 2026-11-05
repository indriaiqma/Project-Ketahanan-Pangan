<?php

if (! function_exists('angka')) {
    /**
     * Format angka gaya Indonesia: 12.345,67
     */
    function angka($nilai, int $desimal = 2): string
    {
        return number_format((float) ($nilai ?? 0), $desimal, ',', '.');
    }
}
