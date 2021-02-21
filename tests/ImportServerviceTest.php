<?php

use App\Domain\TypeEnum as TypeEnumAlias;

test('validade type import', function () {

    $importService = new \App\Services\ImportService();
    $salesmanData = ['001', '08625455956', 'David Richard', '5800'];
    $customerData = ['002', '70241790000182', 'Check List Facil', 'develop'];
    $salesData = ['003','08','[1­34­10, 2­33­1. 50, 3­40­0. 10]' ,'Elias'];

    expect($importService->getTypeId($salesmanData[0]))->toEqual(TypeEnumAlias::SALESMAN);
    expect($importService->getTypeId($customerData[0]))->toEqual(TypeEnumAlias::CUSTOMER);
    expect($importService->getTypeId($salesData[0]))->toEqual(TypeEnumAlias::SALES);

    expect($importService->importSalesman($salesmanData))->toBeInstanceOf(\App\Domain\Salesman\Salesman::class);
    expect($importService->importCustomer($customerData))->toBeInstanceOf(\App\Domain\Customer\Customer::class);
    //expect($importService->importSales($salesmanData))->toBeInstanceOf(\App\Domain\Sales\Sales::class);



    //expect($importService->importSalesItems($salesData[2]))->toBeInstanceOf(SaleItemsCollecion::class);





});
