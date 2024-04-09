<?php

use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use SoipoServices\ComfyDeploy\Data\GetWorkflowData;
use SoipoServices\ComfyDeploy\Requests\GetWorkflow;

test(/**
 * @throws FatalRequestException
 * @throws RequestException
 */ 'get workflow endpoint', function () {

    $connector = getMockConnector(
        GetWorkflow::class,
        'getWorkflow'
    );

    $request = new GetWorkflow("8b3c8358-cc23-99ba-dn70-a8d3fff3eee0");

    $response = $connector->send($request);

    /* @var GetWorkflowData $data */
    $data = $response->dtoOrFail();

    expect($response->ok())
        ->toBeTrue()
        ->and($data->id)
        ->toBe('3fa85f64-5717-4562-b3fc-2c963f66afa6');
});