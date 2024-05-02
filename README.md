# Comfy Deploy PHP client
This is a framework-agnostic PHP client for [Comfy Deploy.com](https://www.comfydeploy.com/) built on the amazing [Saloon v3](https://docs.saloon.dev/) 🤠 library. Use it to easily interact with machine learning models such as Stable Diffusion right from your PHP application.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/soiposervices/comfydeploy.svg?style=flat-square)](https://packagist.org/packages/soiposervices/comfydeploy)
[![GitHub Tests Action Status](https://github.com/SoipoServices/comfydeploy/actions/workflows/tests.yml/badge.svg?branch=main)](https://github.com/SoipoServices/comfydeploy/actions/workflows/tests.yml)

## Table of contents
- [Quick Start](https://github.com/soiposervices/comfydeploy#-quick-start)
- [Using with Laravel](https://github.com/soiposervices/comfydeploy#using-with-laravel)
- [Response Data](https://github.com/soiposervices/comfydeploy#response-data)
- [Webhooks](https://github.com/soiposervices/comfydeploy#webhooks)
- [Workflow Methods](https://github.com/soiposervices/comfydeploy#available-prediction-methods)
    - [get](https://github.com/soiposervices/comfydeploy#get)
    - [run](https://github.com/soiposervices/comfydeploy#run)

## 🚀 Quick start

Install with composer.

```bash
composer require soiposervices/comfydeploy
```
### 

Create a new api instance.
```php
use SoipoServices\ComfyDeploy\ComfyDeploy;
...

$api = new ComfyDeploy(
    apiToken: $_ENV['COMFY_DEPLOY_API_TOKEN'],
);
```
###

Then use it to invoke your model (or in comfy deploy terms "create a workflow").
```php
$deployment_id = 'e4a14vs9-q40j-4ee2-1375-778b2je3221c';
$input = [
    'model' => 'prompt',
    'postive_prompt' => 'a photo of an astronaut riding a horse on mars',
    'seed' => null,
];

$data = $api->workflows()->run($deployment_id, $input);
$data->run_id; // 257b65b8-ac23-49be-8aca-53d2dd8556c6
```

## Using with Laravel
Begin by adding your credentials to your services config file.
```php
// config/services.php
'comfy_deploy' => [
    'api_token' => env('COMFY_DEPLOY_API_TOKEN'),
],
```
###

Bind the `ComfyDeploy` class in a service provider.
```php
// app/Providers/AppServiceProvider.php
public function register()
{
    $this->app->bind(ComfyDeploy::class, function () {
        return new ComfyDeploy(
            apiToken: config('services.comfy_deploy.api_token'),
        );
    });
}
````
###

And use anywhere in your application.
```php
$data = app(ComfyDeploy::class)->workflows()->get($run_id);
```
###

Test your integration using Saloon's amazing [response recording](https://docs.saloon.dev/testing/recording-requests#fixture-path).
```php
use Saloon\Laravel\Saloon; // composer require sammyjo20/saloon-laravel "^2.0"
...
Saloon::fake([
    MockResponse::fixture('getWorkflow'),
]);

$run_id = '257b65b8-ac23-49be-8aca-53d2dd8556c6';

// The initial request will check if a fixture called "getWorkflow" 
// exists. Because it doesn't exist yet, the real request will be
// sent and the response will be recorded to tests/Fixtures/Saloon/getWorkflow.json.
$data = app(ComfyDeploy::class)->workflows()->get($run_id);

// However, the next time the request is made, the fixture will 
// exist, and Saloon will not make the request again.
$data = app(ComfyDeploy::class)->workflows()->get($run_id);
```

## Response Data
All responses are returned as data objects. Detailed information can be found by inspecting the following class properties:

* [GetWorkflowData](https://github.com/SoipoServices/comfydeploy/blob/main/src/Data/GetWorkflowData.php)
* [RunWorkflowData](https://github.com/SoipoServices/comfydeploy/blob/main/src/Data/RunWorkflowData.php)

## Webhooks
Comfy Deploy allows you to configure a webhook to be called when your prediction is complete. To do so chain `withWebhook($url)` onto your api instance before calling the `run` method. For example:

```php
$api->workflows()->withWebhook('https://www.example.com/webhook')->run($deployment_id, $input);
$data->run_id; // 257b65b8-ac23-49be-8aca-53d2dd8556c6
```

## Available Workflow Methods
### get()
Use to get details about an existing workflow.
```php
use SoipoServices\ComfyDeploy\Data\GetWorkflowData;
...
$run_id = '257b65b8-ac23-49be-8aca-53d2dd8556c6'
/* @var GetWorkflowData $data */
$data = $api->workflows()->get($run_id);
$data->id;
```

### run()
Use to run a workflow via deployment_id. Returns an RunWorkflowData object.
```php
use SoipoServices\ComfyDeploy\Data\RunWorkflowData
...
$deployment_id = 'e4a14vs9-q40j-4ee2-1375-778b2je3221c';
$input = [
    'postive_prompt' => 'a photo of an astronaut riding a horse on mars',
];

/* @var RunWorkflowData $data */
$data = $api->workflows()
    ->withWebhook('https://www.example.com/webhook') // optional
    ->run($deployment_id, $input);
$data->run_id; // 257b65b8-ac23-49be-8aca-53d2dd8556c6
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
