<?php

use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use SoipoServices\RunPod\Requests\GetWorkflow;
use SoipoServices\RunPod\Requests\RunWorkflow;


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

    expect($data->id)
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
    ->toBe('15826d2b-3bd1-47e3-baa9-1534c0ca562d-e1')
    ->and($data->delayTime)
    ->toBe(1465)
    ->and($data->executionTime)
    ->toBe(547)
    ->and($data->output["message"])
    ->toBe('base64:eyJzdGF0dXMiOiJzdWNjZXNzIn0=')
    ->and($data->output["status"])
    ->toBe('success');
});