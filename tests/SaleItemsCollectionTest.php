<?php

test('validade cpf import', function () {

    $importService = new ImportService();
    $salesmanData = ['001', '08625455956', 'David Richard', '5800'];
    $salesData = ['003','08','[1­34­10, 2­33­1. 50, 3­40­0. 10]' ,'Elias'];


    expect($importService->getTypeId($salesmanData[0]))->toEqual(TypeId::Salesman);
    expect($importService->getTypeId('002'))->toEqual(TypeId::Customer);
    expect($importService->getTypeId('003'))->toEqual(TypeId::Sales);

    expect($importService->importSalesman($salesmanData))->toBeInstanceOf(Salesman::class);
    expect($importService->importSalesItems($salesData[2]))->toBeInstanceOf(SaleItemsCollecion::class);
});
