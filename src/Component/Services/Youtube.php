<?php


namespace App\Component\Services;

use App\Entity\Endpoint;

/**
 * Class Youtube
 * @author Soner Sayakci <shyim@posteo.de>
 */
class Youtube extends AbstractService
{
    /**
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getName(): string
    {
        return 'Youtube';
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
            'Live Streaming' => 'rtmp://a.rtmp.youtube.com/live2',
            'Live Streaming (backup)' => 'rtmp://b.rtmp.youtube.com/live2'
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
