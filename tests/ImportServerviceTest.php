<?php

use App\Domain\TypeEnum as TypeEnumAlias;

test('validade type import', function () {

    $importService = new \App\Services\ImportService();
    $salesmanData = ['001', '08625455956', 'David Richard', '5800'];
    $customerData = ['002', '70241790000182', 'Check List Facil', 'develop'];
    $salesData = "003,10,[1­10­100, 2­30­2. 50, 3­40­3. 10] ,Steve";

    expect($importService->getTypeId($salesmanData[0]))->toEqual(TypeEnumAlias::SALESMAN);
    expect($importService->getTypeId($customerData[0]))->toEqual(TypeEnumAlias::CUSTOMER);
    expect($importService->getTypeId('003'))->toEqual(TypeEnumAlias::SALES);

    expect($importService->importSalesman($salesmanData))->toBeInstanceOf(\App\Domain\Salesman\Salesman::class);
    expect($importService->importCustomer($customerData))->toBeInstanceOf(\App\Domain\Customer\Customer::class);
    expect($importService->extractSales($salesData))->toBeInstanceOf(\App\Domain\Sales\Sales::class);

    $items = '1­10­100, 2­30­2. 50, 3­40­3. 10';
    $item = ['1', '10', '100'];

    expect($importService->importItems($item))->toBeInstanceOf(\App\Domain\Sales\SaleItem::class);
    expect($importService->extractSalesItem($items))->toBeInstanceOf(\Doctrine\Common\Collections\ArrayCollection::class);
});
