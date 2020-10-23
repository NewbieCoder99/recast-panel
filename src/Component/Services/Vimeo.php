<?php


namespace App\Component\Services;

use App\Entity\Endpoint;

/**
 * Class Youtube
 * @author Soner Sayakci <shyim@posteo.de>
 */
class Vimeo extends AbstractService
{
    /**
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getName(): string
    {
        return 'Vimeo';
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
        return [
            'Default' => 'rtmp://rtmp.cloud.vimeo.com/live'
        ];
    }

    /**
     * @param Endpoint $endpoint
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function buildStreamUrl(Endpoint $endpoint): string
    {
        return $endpoint->getServer() . '/' . $endpoint->getStreamKey();
    }
}
