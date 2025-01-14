<?php

namespace SoipoServices\RunPod\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SoipoServices\RunPod\Data\RunWorkflowData;

class RunWorkflow extends Request implements HasBody
{

    use HasJsonBody;

    /**
     * @var Method
     */
    protected Method $method = Method::POST;

    /**
     * @param string $deployment_id
     * @param array $input
     */
    public function __construct(
        protected string $deployment_id,
        protected array $input
    ) {
    }

    /**
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return '/run';
    }

    /**
     * @return array<string, array<string, float|int|string|null>|string>
     */
    protected function defaultBody(): array
    {
        return [
            'deployment_id' => $this->deployment_id,
            'inputs' => $this->input,
        ];
    }

    /**
     * @param Response $response
     * @return RunWorkflowData
     * @throws \Exception
     */
    public function createDtoFromResponse(Response $response): RunWorkflowData
    {
        return RunWorkflowData::fromResponse($response);
    }
}