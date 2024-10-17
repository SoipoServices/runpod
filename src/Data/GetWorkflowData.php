<?php

namespace SoipoServices\ComfyDeploy\Data;

use Exception;
use Saloon\Http\Response;

class GetWorkflowData
{
   /**
     * @param  array<string, string|int|float>  $workflow_inputs
     * @param  array<string, string>  $run_log
     */
    public function __construct(
        public string $id,
        public string $workflow_version_id,
        public array $workflow_inputs,
        public string $workflow_id,
        public string $machine_id,
        public string $origin,
        public string $status,
        public string $ended_at,
        public string $created_at,
        public string $queued_at,
        public string $started_at,
        public string $gpu,
        public string $machine_version,
        public string $machine_type,
        public string $modal_function_call_id,
        public string $user_id,
        public string $org_id,
        public array $run_log,
        public string $live_status,
        public int $progress,
        public bool $is_realtime,
    ) {
    }

    /**
     * @throws Exception
     */
    public static function fromResponse(Response $response): self
    {
        $data = $response->json();
        if (! is_array($data)) {
            throw new Exception('Invalid response');
        }

        return new GetWorkflowData(
            id: $data['id'],
            workflow_version_id: $data['workflow_version_id'],
            workflow_inputs: $data['workflow_inputs'],
            workflow_id: $data['workflow_id'],
            machine_id: $data['machine_id'],
            origin: $data['origin'],
            status: $data['status'],
            ended_at: $data['ended_at'],
            created_at: $data['created_at'],
            queued_at: $data['queued_at'],
            started_at: $data['started_at'],
            gpu: $data['gpu'],
            machine_version: $data['machine_version'],
            machine_type: $data['machine_type'],
            modal_function_call_id: $data['modal_function_call_id'],
            user_id: $data['user_id'],
            org_id: $data['org_id'],
            run_log: $data['run_log'],
            live_status: $data['live_status'],
            progress: $data['progress'],
            is_realtime: $data['is_realtime'],
        );
    }
}