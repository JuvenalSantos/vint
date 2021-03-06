<?php

namespace Portotech\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * VisualizationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VisualizationRepository extends EntityRepository
{

    public function findAllOrderByDesc() {
        return $this->getEntityManager()->getRepository("PortotechAppBundle:Visualization")->findBy(
            array(),
            array('creatAt' => 'DESC')
        );
    }

}
