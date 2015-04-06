<?php

namespace Lemon\RestBundle\Tests\Controller;

use Lemon\RestBundle\Tests\FunctionalTestCase;
use Lemon\RestBundle\Event\RestEvents;
use Lemon\RestBundle\Object\Criteria\DefaultCriteria;
use Lemon\RestBundle\Object\Definition;
use Lemon\RestBundle\Tests\Fixtures\Car;
use Lemon\RestBundle\Tests\Fixtures\Tag;
use Lemon\RestBundle\Tests\Fixtures\Person;
use Lemon\RestBundle\Tests\Fixtures\FootballTeam;

class MongoResourceControllerTest extends ResourceControllerTest
{
    public function setUp()
    {
        $class = static::getKernelClass();

        $kernel = new $class('test_mongodb', true);
        $kernel->boot();


        $this->client = $kernel->getContainer()->get('test.client');
        $this->container = $this->client->getContainer();
        $this->doctrine = $this->container->get('doctrine_mongodb');
        $this->em = $this->doctrine->getManager();
        $this->serializer = $this->container->get('jms_serializer');

        $registry = $this->container->get('lemon_rest.object_registry');
        $registry->add(new Definition('person', 'Lemon\RestBundle\Tests\Fixtures\Person'));
        $registry->add(new Definition('footballTeam', 'Lemon\RestBundle\Tests\Fixtures\FootballTeam'));

        $this->controller = $this->container->get('lemon_rest.resource_controller');
    }

    public function tearDown()
    {
        $qb = $this->doctrine->getManager()->createQueryBuilder('Lemon\RestBundle\Tests\Fixtures\Person');
        $qb->remove()
            ->getQuery()
            ->execute();
    }
}
