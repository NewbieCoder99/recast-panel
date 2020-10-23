<?php


namespace App\Component\Services;

use App\Entity\Endpoint;

/**
 * Class Youtube
 * @author Soner Sayakci <shyim@posteo.de>
 */
class GoodGame extends AbstractService
{
    /**
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getName(): string
    {
        return 'GoodGame';
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
            'Moscow' => 'rtmp://msk.goodgame.ru:1940/live'
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
