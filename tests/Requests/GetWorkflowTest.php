<?php

use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use SoipoServices\RunPod\Data\GetWorkflowData;
use SoipoServices\RunPod\Requests\GetWorkflow;

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
        ->toBe('15826d2b-3bd1-47e3-baa9-1534c0ca562d-e1')
        ->and($data->delayTime)
        ->toBe(1465)
        ->and($data->executionTime)
        ->toBe(547)
        ->and($data->output["message"])
        ->toBe('base64:eyJzdGF0dXMiOiJzdWNjZXNzIn0=')
        ->and($data->output["status"])
        ->toBe('success');

})->group('run');