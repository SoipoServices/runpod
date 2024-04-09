<?php

namespace SoipoServices\ComfyDeploy;

use Saloon\Http\Connector;

final class ComfyDeploy extends Connector
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
        return 'https://www.comfydeploy.com/api';
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