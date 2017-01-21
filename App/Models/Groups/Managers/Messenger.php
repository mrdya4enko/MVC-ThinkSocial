<?php

namespace App\Models\Groups\Managers;

/**
 * Class ResponseManager
 * @package App\Models\Groups\Managers
 */
class Messenger
{
    private $headers;

    public function send204Response()
    {
        header("HTTP/1.1 204 No Content");
        $this->prepareHeaders();
        exit;
    }

    public function send404Response()
    {
        header("HTTP/1.1 404 Not Found");
        header("Refresh:1; url=/groups");
        $this->prepareHeaders();
        exit;
    }

    public function send405Response()
    {
        header("HTTP/1.1 405 Method is not allowed");
        header("Refresh:1; url=/groups");
        $this->prepareHeaders();
        exit;
    }

    public function send406Response()
    {
        header("HTTP/1.1 406 Not Acceptable");
        $this->prepareHeaders();
        exit;
    }

    public function send503Response()
    {
        header("HTTP/1.1 503 Service Unavailable");
        header("Rerty-After: 15 minutes");
        exit;
    }

    /**
     * @param array $response
     * @throws \Exception
     */
    public function sendNewJSONResponse(array $response)
    {
        if (!empty($response)) {
            $this->prepareHeaders();
            header("Content-Type: application/json");
            echo json_encode($response);
            exit;
        } else {
            throw new \Exception("Empty Response given");
        }
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param mixed $header
     */
    public function setHeader($header)
    {
        $this->headers[] = $header;
    }


    private function prepareHeaders()
    {
        if (!empty($this->headers)) {
            foreach ($this->headers as $header) {
                header($header);
            }
        }
    }
}
