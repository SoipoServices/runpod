# RunPod PHP client
This is a framework-agnostic PHP client for [runpod.com](https://www.runpod.com/) built on the amazing [Saloon v3](https://docs.saloon.dev/) 🤠 library. Use it to easily interact with machine learning models such as Stable Diffusion right from your PHP application.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/soiposervices/runpod.svg?style=flat-square)](https://packagist.org/packages/soiposervices/runpod)
[![GitHub Tests Action Status](https://github.com/SoipoServices/runpod/actions/workflows/tests.yml/badge.svg?branch=main)](https://github.com/SoipoServices/runpod/actions/workflows/tests.yml)

## Table of contents
- [Quick Start](https://github.com/soiposervices/runpod#-quick-start)
- [Using with Laravel](https://github.com/soiposervices/runpod#using-with-laravel)
- [Response Data](https://github.com/soiposervices/runpod#response-data)
- [Webhooks](https://github.com/soiposervices/runpod#webhooks)
- [Workflow Methods](https://github.com/soiposervices/runpod#available-prediction-methods)
    - [get](https://github.com/soiposervices/runpod#get)
    - [run](https://github.com/soiposervices/runpod#run)

## 🚀 Quick start

Install with composer.

```bash
composer require soiposervices/runpod
```
### 

Create a new api instance.
```php
use SoipoServices\runpod\runpod;
...

$api = new runpod(
    apiToken: $_ENV['RUNPOD_API_TOKEN'],
);
```
###

Then use it to invoke your model (or in RunPod terms "create a workflow").
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
'runpod' => [
    'api_token' => env('RUNPOD_API_TOKEN'),
],
```
###

Bind the `runpod` class in a service provider.
```php
// app/Providers/AppServiceProvider.php
public function register()
{
    $this->app->bind(runpod::class, function () {
        return new runpod(
            apiToken: config('services.runpod.api_token'),
        );
    });
}
````
###

And use anywhere in your application.
```php
$data = app(runpod::class)->workflows()->get($run_id);
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
$data = app(runpod::class)->workflows()->get($run_id);

// However, the next time the request is made, the fixture will 
// exist, and Saloon will not make the request again.
$data = app(runpod::class)->workflows()->get($run_id);
```

## Response Data
All responses are returned as data objects. Detailed information can be found by inspecting the following class properties:

* [GetWorkflowData](https://github.com/SoipoServices/runpod/blob/main/src/Data/GetWorkflowData.php)
* [RunWorkflowData](https://github.com/SoipoServices/runpod/blob/main/src/Data/RunWorkflowData.php)

## Webhooks
RunPod allows you to configure a webhook to be called when your prediction is complete. To do so chain `withWebhook($url)` onto your api instance before calling the `run` method. For example:

```php
$api->workflows()->withWebhook('https://www.example.com/webhook')->run($deployment_id, $input);
$data->run_id; // 257b65b8-ac23-49be-8aca-53d2dd8556c6
```

## Available Workflow Methods
### get()
Use to get details about an existing workflow.
```php
use SoipoServices\runpod\Data\GetWorkflowData;
...
$run_id = '257b65b8-ac23-49be-8aca-53d2dd8556c6'
/* @var GetWorkflowData $data */
$data = $api->workflows()->get($run_id);
$data->id;
```

### run()
Use to run a workflow via deployment_id. Returns an RunWorkflowData object.
```php
use SoipoServices\runpod\Data\RunWorkflowData
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
