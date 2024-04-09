<?php

use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use SoipoServices\ComfyDeploy\Data\RunWorkflowData;
use SoipoServices\ComfyDeploy\Requests\RunWorkflow;

test(/**
 * @throws FatalRequestException
 * @throws RequestException
 */ 'run workflow endpoint', function () {

    $connector = getMockConnector(
        RunWorkflow::class,
        'runWorkflow'
    );

    $request = new RunWorkflow("8b3c8358-cc23-99ba-dn70-a8d3fff3eee0", ["test" => "test value 1", "test2" => "test value 2"]);

    $response = $connector->send($request);

    /* @var RunWorkflowData $data */
    $data = $response->dtoOrFail();

    expect($response->ok())
        ->toBeTrue()
        ->and($data->run_id)
        ->toBe('a8073bca-2c04-40cf-8d2d-d0022e63dcf9');
});