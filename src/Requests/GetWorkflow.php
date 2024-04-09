<?php

namespace SoipoServices\ComfyDeploy\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SoipoServices\ComfyDeploy\Data\GetWorkflowData;

class GetWorkflow extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * @var Method
     */
    protected Method $method = Method::GET;

    /**
     * @param string $run_id
     */
    public function __construct(
        protected string $run_id,
    ) {
    }

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
            'run_id' => $this->run_id,
        ];
    }

    /**
     * @param Response $response
     * @return GetWorkflowData
     * @throws \Exception
     */
    public function createDtoFromResponse(Response $response): GetWorkflowData
    {
        return GetWorkflowData::fromResponse($response);
    }
}