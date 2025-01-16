<?php

namespace SoipoServices\RunPod\Data;

use Exception;
use Saloon\Http\Response;

class RunWorkflowData
{
    /**
     * @param string $run_id
     */
    public function __construct(
        public string $id,
        public string $status
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

        return new RunWorkflowData(
            id: $data['id'],
            status: $data['status']
        );
    }
}