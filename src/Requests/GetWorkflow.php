<?php

namespace SoipoServices\RunPod\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SoipoServices\RunPod\Data\GetWorkflowData;

class GetWorkflow extends Request
{

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
        return "{$this->run_id}/run";
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