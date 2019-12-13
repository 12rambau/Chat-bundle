<?php

namespace Btba\ChatBundle\Tests\Controller;

use Btba\ChatBundle\BtbaChatBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class ChatControllerTest extends TestCase
{ 

    //TODO be careful with the /cache/ directory 

    //test if the wehook work 
    
   /* public function testTest()
    {
        $kernel = new BtbaChatTestingKernel([
            'update_interval' => 1000,
            'message_class' => 'App\Entity\Message.php',
            'author_class' => 'App\Entity\Author.php'
        ]);

        $client = new Client($kernel);
        $client->request('GET', '/test/');

        var_dump($client->getResponse()->getContent());
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }*/
    
    public function test()
    {
        $this->assertEquals(0, 0);
    }
}

class BtbaChatTestingKernel extends Kernel
{
    use MicroKernelTrait;

    private $btbaChatConfig;

    public function __construct(array $btbaChatConfig = [])
    {
        $this->btbaChatConfig = $btbaChatConfig;

        parent::__construct('test', true);
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    { 
        $routes->import(__DIR__.'/../../src/Resources/config/routes.yaml', '/test');
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    { 
        $c->loadFromExtension('framework', [
            'secret' => 'F00',
            'translator' => ['enabled' => true]
        ]);

        $loader->load(function (ContainerBuilder $container) {
            $container->loadFromExtension('btba_chat', $this->btbaChatConfig);
        });
    }

    public function registerBundles()
    {
        return [
            new BtbaChatBundle(),
            new FrameworkBundle(),
        ];
    }
}
