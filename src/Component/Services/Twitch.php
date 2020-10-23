<?php


namespace App\Component\Services;

use App\Entity\Endpoint;

/**
 * Class Twitch
 * @author Soner Sayakci <shyim@posteo.de>
 */
class Twitch extends AbstractService
{
    /**
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getName(): string
    {
        return 'Twitch';
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
        $list = json_decode(file_get_contents('https://ingest.twitch.tv/ingests'), true);
        return array_combine(array_column($list['ingests'], 'name'), array_column($list['ingests'], 'url_template'));
    }

    /**
     * @param Endpoint $endpoint
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function buildStreamUrl(Endpoint $endpoint): string
    {
        return str_replace('{stream_key}', $endpoint->getStreamKey(), $endpoint->getServer());
    }
}