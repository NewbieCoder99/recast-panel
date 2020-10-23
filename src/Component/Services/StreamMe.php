<?php


namespace App\Component\Services;

use App\Entity\Endpoint;

/**
 * Class Youtube
 * @author Soner Sayakci <shyim@posteo.de>
 */
class StreamMe extends AbstractService
{
    /**
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getName(): string
    {
        return 'Stream.me';
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
            'US, Central' => 'rtmp://uc-origin.stream.me/origin',
            'US, East' => 'rtmp://ue-origin.stream.me/origin',
            'US, West' => 'rtmp://uw-origin.stream.me/origin',
            'Europe, West' => 'rtmp://ew-origin.stream.me/origin',
            'Asia, East' => 'rtmp://ae-origin.stream.me/origin'
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
