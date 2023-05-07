<?php

namespace App\Repository;

use App\Entity\FbTeam;
use App\Entity\Players;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sample>
 *
 * @method Sample|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sample|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sample[]    findAll()
 * @method Sample[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FbTeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FbTeam::class);
    }

    public function save(FbTeam $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FbTeam $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Sample[] Returns an array of Sample objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    public function fetchWholeTeam(?array $pagination = []): array
    {
        $itemlist = array();

        $raw_data = $this
            ->createQueryBuilder('t')
            ->select('t', 'p')
            ->join(Players::class, 'p')
            // ->where('p.team=t.id')
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult();

        if (!empty($raw_data)) {
            foreach ($raw_data as $rdata) {
                if ($rdata instanceof Players) {
                    $itemlist[$rdata->getTeam()]['players'][] = $rdata;
                } else if ($rdata instanceof FbTeam) {
                    $itemlist[$rdata->getId()]['team'] = $rdata;
                    if (!isset($itemlist[$rdata->getId()]['players']))
                        $itemlist[$rdata->getId()]['players'] = [];
                }
            }
        }

        if (!empty($pagination)) {
            $teamPage    = (isset($pagination['teamid'])) ? $pagination['teamid'] : '';
            $page_no     = (isset($pagination['page_no'])) ? $pagination['page_no'] : 0;
            $recsperpage = (isset($pagination['recsperpage'])) ? $pagination['recsperpage'] : 10;

            if (isset($itemlist[$teamPage]) && $page_no > 0) {
                $offset = $recsperpage * ($page_no - 1);
                $startlimit = ($offset <= 0) ? 0 : $offset + 1;
                $endlimit   = $offset + $recsperpage;

                //s echo "startlimit: $startlimit, endlimit: $endlimit , teamPage: $teamPage<br>";

                $data = array_values($itemlist[$teamPage]['players']);
                //dd($data);
                if (!empty($data)) {
                    $itemlist[$teamPage]['players'] = [];
                    for ($ix = $startlimit; ($ix < count($data) && $ix < $endlimit); $ix++) {
                        $itemlist[$teamPage]['players'][] = $data[$ix];
                    }
                }
            }
        }

        //dd($itemlist);

        return $itemlist;
    }

    public function findTeamByID($value): ?FbTeam
    {
        return $this->createQueryBuilder('t')
            ->setParameter('val', $value)
            // ->innerJoin(Players::class, 'p')
            // ->where('p.team=t.id')
            ->where('t.id = :val')
            ->getQuery()
            ->getOneOrNullResult();
    }
}
