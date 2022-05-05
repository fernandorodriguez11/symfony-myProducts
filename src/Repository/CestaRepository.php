<?php

namespace App\Repository;

use App\Entity\Cesta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cesta|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cesta|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cesta[]    findAll()
 * @method Cesta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CestaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cesta::class);
    }

    public function buscarCesta(){

        return $this->getEntityManager()
            ->createQuery('
                Select cesta.id, cesta.cantidad, cesta.comprado, productos.id as pro, productos.nombre, productos.tienda, productos.foto_producto as fotoproducto, user.username
                From App:Cesta cesta 
                Join cesta.user user
                Join cesta.producto productos')->getResult();
            /*->getResult()
                Quitamos el getResult() porque con el bundle de paginacion nos pide que solo devolvamos la query.
                Si para otra cosa quisieramos los resultados si deberíamos de ponerlo.
                Para este ejemplo vamos a dvolver la query.
            */
    }

    public function buscarCestaPaginado(){

        return $this->getEntityManager()
            ->createQuery('
                Select cesta.id, cesta.cantidad, cesta.comprado, productos.id as pro, productos.nombre, productos.tienda, productos.foto_producto as fotoproducto, user.username
                From App:Cesta cesta 
                Join cesta.user user
                Join cesta.producto productos');
    }
    // /**
    //  * @return Cesta[] Returns an array of Cesta objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cesta
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
