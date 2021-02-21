<?php


namespace App\Services;


use App\Domain\Result\Result;
use Doctrine\Common\Collections\Collection;

class ExportService
{
    public function exportFile(array $result, string $fileName)
    {
        $fileName = $this->getFileName($fileName);

        $path = '../../data/out/';

        $file = fopen($path . $fileName, "w") or die("Unable to open file!");

        $data = implode(',', $result);

        fwrite($file, $data);

        fclose($file);
    }

    public function getFileName(string $fileName)
    {
        $fileName = preg_replace('/\.[^.]+$/', '', $fileName);

        return $fileName . '.done' . '.dat';
    }
}