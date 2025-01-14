<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use SoipoServices\RunPod\RunPod;

function getConnector(): RunPod
{
    $apiToken = getenv('COMFY_DEPLOY_API_TOKEN');
    return new RunPod(
        apiToken: $apiToken ?: '',
    );
}

/**
 */
function getMockClient(string $class, string $fixture): MockClient
{
    return new MockClient([
        $class => MockResponse::fixture($fixture),
    ]);
}

/**
 */
function getMockConnector(string $class, string $fixture): RunPod
{
    $mockClient = getMockClient($class, $fixture);
    $connector = getConnector();

    return $connector->withMockClient($mockClient);
}
