<?php

namespace Xofttion\Project\Traits;

use Xofttion\Project\Response;
use Xofttion\Project\Utils\Messages;
use Xofttion\Project\Utils\HttpCode;

trait ResponseTrait {
    
    // Métodos del trait ResponseTrait
    
    /**
     * 
     * @param string|null $resource
     * @param object $data
     * @return Response
     */
    public function responseRegisted(?string $resource, $data = null): Response {
        return $this->responseSuccess(Messages::getInstance()->getRegisted($resource), $data);
    }
    
    /**
     * 
     * @param string|null $resource
     * @param object $data
     * @return Response
     */
    public function responseUpdated(?string $resource, $data = null): Response {
        return $this->responseSuccess(Messages::getInstance()->getUpdated($resource), $data);
    }
    
    /**
     * 
     * @param string|null $resource
     * @param object $data
     * @return Response
     */
    public function responseDeleted(?string $resource, $data = null): Response {
        return $this->responseSuccess(Messages::getInstance()->getDeleted($resource), $data);
    }
    
    /**
     * 
     * @param string|null $resource
     * @param object $data
     * @return Response
     */
    public function responseAttached(?string $resource, $data = null): Response {
        return $this->responseSuccess(Messages::getInstance()->getAttached($resource), $data);
    }
    
    /**
     * 
     * @param string|null $resource
     * @param bool $status
     * @param object $data
     * @return Response
     */
    public function responseToggleStatus(?string $resource, bool $status, $data = null): Response {
        return $this->responseSuccess(Messages::getInstance()->getToggleStatus($resource, $status), $data);
    }
    
    /**
     * 
     * @param string|null $message
     * @param object $data
     * @return Response
     */
    public function responseSuccess(?string $message, $data = null): Response {
        return $this->responseKernel(true, $message, $data);
    }
    
    /**
     * 
     * @param string|null $message
     * @param object $data
     * @return Response
     */
    public function responseFailed(?string $message, $data = null): Response {
        return $this->responseKernel(false, $message, $data);
    }
    
    /**
     * 
     * @param bool $success
     * @param string|null $message
     * @param type $data
     * @return Response
     */
    public function responseKernel(bool $success, ?string $message, $data = null): Response {
        return new Response($success, $message, HttpCode::OK, $data);
    }
}