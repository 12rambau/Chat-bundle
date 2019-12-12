<?php

namespace Btba\ChatBundle\Query;

trait MessageQuery
{
    public function countAll()
    {
        return $this->createQueryBuilder('m')
            ->select('count(m.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
