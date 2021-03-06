<?php

namespace Portotech\AppBundle\Entity;


class VisMultiLine {

   /**
    * @var \Portotech\AppBundle\Entity\Visualization
    */
    private $visualization;

    /**
     * @var array
     */
    private $lines;

    /**
     * @var array
     */
    private $cloudTags;

    function __construct(Visualization $visualization)
    {
        $this->visualization = $visualization;
        $this->lines = array();
        $this->cloudTags = array();
    }


    /**
     * @return Visualization
     */
    public function getVisualization()
    {
        return $this->visualization;
    }

    /**
     * Set Lines
     *
     * @param array
     */
    public function setLines($lines){
        $points = array();
        foreach($lines as $point) {
            $points[] = array(
                'sentiment' => (int)$point['sentiment'],
                'creat_at' => $point['creat_at'],
                'y' => (int)$point['total']
            );
        }
        $this->lines = $points;
    }

    /**
     * Add Line
     *
     * @param array
     */
    public function addLine($line){
        $this->lines[] = $line;
    }

    /**
     * @return array
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @return array
     */
    public function getCloudTags()
    {
        return $this->cloudTags;
    }

    /**
     * @param array $cloudTags
     */
    public function setCloudTags($cloudTags)
    {
        foreach($cloudTags as $tag) {
            $this->cloudTags[] = array(
                'word' => ($tag['words']),
                'size' => (int)$tag['total'],
                'hash' => hash('crc32', $tag['words'], false)
            );
        }

    }
}