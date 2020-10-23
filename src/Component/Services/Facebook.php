<?php

namespace App\Component\Services;

use App\Entity\Endpoint;

/**
 * Class Facebook
 * @author Soner Sayakci <shyim@posteo.de>
 */
class Facebook extends AbstractService
{
    /**
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getName(): string
    {
        return 'Facebook';
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
            'Facebook Streaming' => 'rtmp://live-api.facebook.com:80/rtmp/'
        ];
    }

    /**
     * @param Endpoint $endpoint
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function buildStreamUrl(Endpoint $endpoint): string
    {
        return $endpoint->getServer() . $endpoint->getStreamKey();
    }
}