<?php

namespace SoipoServices\ComfyDeploy;

use Exception;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use SoipoServices\ComfyDeploy\Data\GetWorkflowData;
use SoipoServices\ComfyDeploy\Data\RunWorkflowData;
use SoipoServices\ComfyDeploy\Requests\GetWorkflow;
use SoipoServices\ComfyDeploy\Requests\RunWorkflow;

class WorkflowResource extends Resource
{
    protected ?string $webhookUrl = null;

    /**
     * @param string $run_id
     * @return GetWorkflowData
     * @throws Exception
     */
    public function get(string $run_id): GetWorkflowData
    {
        $request = new GetWorkflow($run_id);
        $response = $this->connector->send($request);

        $data = $response->dtoOrFail();
        if (! $data instanceof GetWorkflowData) {
            throw new Exception('Unexpected data type');
        }

        return $data;
    }

    /**
     * @param string $deployment_id
     * @param array $inputs
     * @return RunWorkflowData
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function run(string $deployment_id, array $inputs): RunWorkflowData
    {
        $request = new RunWorkflow($deployment_id, $inputs);
        if ($this->webhookUrl) {
            $request->body()->merge([
                'webhook' => $this->webhookUrl,
            ]);
        }

        $response = $this->connector->send($request);

        $data = $response->dtoOrFail();
        if (! $data instanceof RunWorkflowData) {
            throw new Exception('Unexpected data type');
        }

        return $data;
    }

    public function withWebhook(string $url): self
    {
        $this->webhookUrl = $url;

        return $this;
    }
}