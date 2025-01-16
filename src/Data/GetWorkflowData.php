<?php

namespace SoipoServices\RunPod\Data;

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
        public array $input,
        public array $output,
        public string $status,
        public string $webhook,
        public int $delayTime,
        public int $executionTime,
        
    ) {
    }

    /**
     * @throws Exception
     */
    public static function fromResponse(Response $response): self
    {
        $data = $response->json();
        if (!is_array($data)) {
            throw new Exception('Invalid response');
        }

        return new GetWorkflowData(
            id: $data['id'],
            input: $data['input'],
            status: $data['status'],
            webhook: $data['webhook'],
            output: $data['output'],
            delayTime: $data['delayTime'],
            executionTime: $data['executionTime']
        );
    }
}