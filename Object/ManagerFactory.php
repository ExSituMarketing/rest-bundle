<?php
namespace Lemon\RestBundle\Object;

use Symfony\Bridge\Doctrine\ManagerRegistry as Doctrine;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ManagerFactory implements ManagerFactoryInterface
{
    /**
     * @var Registry
     */
    protected $registry;
    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;
    /**
     * @var Doctrine
     */
    protected $doctrine;

    /**
     * @param Registry $registry
     * @param Doctrine $doctrine
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(
        Registry $registry,
        Doctrine $doctrine,
        EventDispatcher $eventDispatcher
    ) {
        $this->registry = $registry;
        $this->doctrine = $doctrine;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param string $resource
     * @return Manager
     */
    public function create($resource)
    {
        $definition = $this->registry->get($resource);

        return new Manager(
            $this->doctrine,
            $this->eventDispatcher,
            $definition
        );
    }
}
