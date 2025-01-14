<?php

namespace SoipoServices\RunPod;

use Saloon\Http\Connector;

class RunPod extends Connector
{
    public function __construct(
        public string $apiToken,
    ) {
    }

    /**
     * @return string
     */
    public function resolveBaseUrl(): string
    {
        return 'https://api.runpod.ai/v2/';
    }

    /**
     * @return array<string, string>
     */
    protected function defaultHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->apiToken,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /**
     * @return WorkflowResource
     */
    public function workflows(): WorkflowResource
    {
        return new WorkflowResource($this);
    }
}