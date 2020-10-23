<?php

namespace App\Component\Services;

use App\Entity\Endpoint;

/**
 * Class AbstractService
 * @author Soner Sayakci <shyim@posteo.de>
 */
abstract class AbstractService
{
    /**
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    abstract public function getName() : string;

    /**
     * @return bool
     * @author Soner Sayakci <shyim@posteo.de>
     */
    abstract public function hasServerList() : bool;

    /**
     * @return array
     * @author Soner Sayakci <shyim@posteo.de>
     */
    abstract public function getServerList() : array;

    /**
     * @param Endpoint $endpoint
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    abstract public function buildStreamUrl(Endpoint $endpoint) : string;
}