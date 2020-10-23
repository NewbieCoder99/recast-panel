<?php

namespace App\Component\Services;

use App\Entity\Endpoint;

/**
 * Class Mixer
 * @author Soner Sayakci <shyim@posteo.de>
 */
class Mixer extends AbstractService
{
    /**
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getName(): string
    {
        return 'Mixer';
    }

    /**
     * @return bool
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function hasServerList(): bool
    {
        return true;
    }

    /**
     * @return array
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getServerList(): array
    {
        $list = json_decode(file_get_contents('https://mixer.com/api/v1/ingests?noCount=1'), true);
        return array_combine(array_column($list, 'name'), array_column($list, 'host'));
    }

    /**
     * @param Endpoint $endpoint
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function buildStreamUrl(Endpoint $endpoint): string
    {
        return 'rtmp://' . $endpoint->getServer() . ':1935/beam/' . $endpoint->getStreamKey();
    }
}