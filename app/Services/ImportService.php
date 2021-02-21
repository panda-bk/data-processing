<?php

namespace App\Services;


use App\Domain\Customer\Customer;
use App\Domain\Result\Result;
use App\Domain\Sales\SaleItem;
use App\Domain\Sales\Sales;
use App\Domain\Sales\SalesItemsCollection;
use App\Domain\Salesman\Salesman;
use App\Domain\TypeEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use phpDocumentor\Reflection\Types\Parent_;

class ImportService
{
    /**
     * @var ExportService
     */
    private ExportService $exportService;

    public function importFile()
    {
        $this->exportService = new ExportService();

        chdir('data/in/');
        $files = glob("{*.dat}", GLOB_BRACE);

        $fileName = $files[0];
        $handle = fopen($fileName, "r");

        $collectionSalesman = new ArrayCollection();
        $collectionCustomer = new ArrayCollection();
        $collectionSales = new ArrayCollection();

        while ($line = fgetcsv($handle, 1000, ";")) {
            $id = $this->getTypeId($line[0]);

            $this->validateType($id, $line[0], $collectionSalesman, $collectionCustomer, $collectionSales);
        }

        $result = $this->getResult($collectionSalesman, $collectionCustomer, $collectionSales);

        $this->exportService->exportFile($result, $fileName);
    }

    public function validateType(string $id, string $line, $collectionSalesman, $collectionCustomer, $collectionSales)
    {
        switch ($id) {
            case TypeEnum::SALESMAN:
                return $collectionSalesman->add($this->extractSalesman($line));
            case TypeEnum::CUSTOMER:
                return $collectionCustomer->add($this->extractCustomer($line));
            case TypeEnum::SALES:
                return $collectionSales->add($this->extractSales($line));
        }
    }

    public function getTypeId(string $line): string
    {
        return explode(',', $line)[0];
    }

    public function importSalesman(array $array)
    {
        return new Salesman($array[0], $array[1], $array[2], $array[3]);
    }

    public function extractSalesman(string $line)
    {
        $data = explode(',', $line);

        return $this->importSalesman($data);
    }

    public function importCustomer(array $array)
    {
        return new Customer($array[0], $array[1], $array[2], $array[3]);
    }

    public function extractCustomer(string $line)
    {
        $data = explode(',', $line);

        return $this->importCustomer($data);
    }

    public function importSales(string $id, string $salesId, string $salesman, Collection $items)
    {
        return new Sales($id, $salesId, $salesman, $items);
    }

    public function importItems(array $array)
    {
        return new SaleItem($array[0], floatval($array[1]), floatval($array[2]));
    }

    public function extractSales(string $line)
    {
        $pattern = '/\[(.*)\]/';

        if (!preg_match($pattern, $line, $matches)) {
            $matches[1] = '';
        }

        $items = $this->extractSalesItem($matches[1]);

        $sales = explode(',', $line);

        return $this->importSales($sales[0], $sales[1], end($sales), $items);
    }

    public function extractSalesItem(string $data): Collection
    {
        $data = str_replace(' ', '', $data);
        $items = $sales = explode(',', $data);

        $collectionItems = new ArrayCollection();

        foreach ($items as $item) {
            $item = explode('­', $item);
            $collectionItems->add($this->importItems($item));
        }

        return $collectionItems;
    }

    public function getResult(Collection $salesman, Collection $customer, Collection $sales)
    {
        $result = new Result();

        $salesman->map(function ($value) use ($result) {
            return $result->addSalesman($value);
        });

        $customer->map(function ($value) use ($result) {
            return $result->addCustomer($value);
        });

        $sales->map(function ($value) use ($result) {
            $result->addSales($value);
            $result->setMaxSale($value);

            return $result;
        });

        return [
            $result->getTotalCustomer(),
            $result->getTotalSalesman(),
            $result->getAverageWage(),
            $result->getMaxSale()[0],
            $result->getWorstSeller()
        ];
    }
}