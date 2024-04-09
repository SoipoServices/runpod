<?php

use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use SoipoServices\ComfyDeploy\Requests\GetWorkflow;
use SoipoServices\ComfyDeploy\Requests\RunWorkflow;


test(/**
 * @throws FatalRequestException
 * @throws RequestException
 */ 'run workflow', function () {
    $mockClient = new MockClient([
        RunWorkflow::class => MockResponse::fixture('runWorkflow'),
    ]);

    $connector = getConnector();
    $connector->withMockClient($mockClient);

    $data = $connector->workflows()->run("8b3c8358-cc23-99ba-dn70-a8d3fff3eee0", ["test" => "test value 1", "test2" => "test value 2"]);

    expect($data->run_id)
        ->toBe('a8073bca-2c04-40cf-8d2d-d0022e63dcf9');
});

test(/**
 * @throws Exception
 */ 'get workflow', function () {
    $mockClient = new MockClient([
        GetWorkflow::class => MockResponse::fixture('getWorkflow'),
    ]);

    $connector = getConnector();
    $connector->withMockClient($mockClient);

    $data = $connector->workflows()->get('8b3c8358-cc23-99ba-dn70-a8d3fff3eee0');

    expect($data->id)
        ->toBe('3fa85f64-5717-4562-b3fc-2c963f66afa6');
});