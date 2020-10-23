<?php

namespace App\Component;

use App\Component\Services\AbstractService;

/**
 * Class ServiceManager
 * @author Soner Sayakci <shyim@posteo.de>
 */
class ServiceManager
{
    /**
     * @var AbstractService[]
     */
    private $services;

    /**
     * @var array
     */
    private $data;

    /**
     * ServiceManager constructor.
     * @param iterable $services
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function __construct(iterable $services)
    {
        $this->services = $services;
    }

    /**
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getTemplateData(): array
    {
        $data = [];

        if ($this->data !== null) {
            return $this->data;
        }

        /** @var AbstractService $service */
        foreach ($this->services as $service) {
            $data[$service->getName()] = $service->getServerList();
        }

        $this->data = $data;

        return $data;
    }

    /**
     * @param string $name
     * @return AbstractService
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getServiceByName(string $name) : AbstractService
    {
        foreach ($this->services as $service) {
            if ($service->getName() === $name) {
                return $service;
            }
        }
    }
}