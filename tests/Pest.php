<?php

use SoipoServices\ComfyDeploy\ComfyDeploy;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

function getConnector(): ComfyDeploy
{
    $apiToken = getenv('COMFY_DEPLOY_API_TOKEN');
    return new ComfyDeploy(
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
function getMockConnector(string $class, string $fixture): ComfyDeploy
{
    $mockClient = getMockClient($class, $fixture);
    $connector = getConnector();

    return $connector->withMockClient($mockClient);
}
