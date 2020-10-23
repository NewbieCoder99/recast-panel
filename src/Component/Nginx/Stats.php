<?php

namespace App\Component\Nginx;
use App\Entity\Streams;

/**
 * Class Stats
 * @author Soner Sayakci <shyim@posteo.de>
 */
class Stats
{
    /**
     * @var array
     */
    private $data;

    /**
     * Stats constructor.
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function __construct()
    {
        $stats = file_get_contents('http://127.0.0.1:26765/stat');
        $xml = simplexml_load_string($stats, 'SimpleXMLElement', LIBXML_NOCDATA);
        $this->data = json_decode(json_encode($xml), true);
    }

    /**
     * @param Streams $stream
     * @author Soner Sayakci <shyim@posteo.de>
     * @return array
     */
    public function getStatsForStream(Streams $stream): array
    {
        $appKey = $stream->getUser()->getUsername() . '/' . $stream->getName();

        foreach ($this->data['server']['application'] as $application) {
            if ($application['name'] === $appKey && isset($application['live']['stream'])) {
                return $application['live']['stream'];
            }
        }

        return [];
    }
}
