<?php

namespace Request {


    class Request
    {
        public $url_elements;
        public $verb;
        public $queryParameters;
        public $bodyParameters;
        public $format = 'json'; // default format

        public function __construct()
        {
            if(isset($_SERVER['PATH_INFO'])){
                $this->url_elements = explode('/', $_SERVER['PATH_INFO']);
            }

            $this->verb = $_SERVER['REQUEST_METHOD'];

            if (isset($_SERVER['QUERY_STRING'])) {
                parse_str($_SERVER['QUERY_STRING'], $this->queryParameters);
            }

            $this->parseBodyParams();

            return true;
        }

        private function parseBodyParams()
        {
            //TODO: query and body parameters

            $parameters = [];

            $body = file_get_contents("php://input");

            $content_type = false;

            if (isset($_SERVER['CONTENT_TYPE'])) {
                $content_type = $_SERVER['CONTENT_TYPE'];
            }

            switch ($content_type) {
                case "application/json":
                    $body_params = json_decode($body);
                    if ($body_params) {
                        foreach ($body_params as $param_name => $param_value) {
                            $parameters[$param_name] = $param_value;
                        }
                    }
                    $this->format = "json";
                    break;
                default:
                    break;
            }

            $this->bodyParameters = $parameters;
        }
    }
}