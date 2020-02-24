<?php
namespace Xome\Http;

/**
 * Interface
 *
 * @package Xome
 */
interface RequestBodyInterface
{
    /**
     * Get the body of the request to send to Graph.
     *
     * @return string
     */
    public function getBody();
}
