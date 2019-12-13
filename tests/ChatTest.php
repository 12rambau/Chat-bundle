<?php

namespace Btba\ChatBundle\Tests;

use Btba\ChatBundle\BtbaChatBundle;
use Btba\ChatBundle\Controller\ChatController;
use Btba\ChatBundle\Form\ChatMessageType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChatTest extends TestCase
{
    public function tearDown()
    {
        //empty the cache 
        $dir = __DIR__ . '/cache/';

        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST) as $path)
            $path->isDir() && !$path->isLink() ? rmdir($path->getPathname()) : unlink($path->getPathname());
    }
    public function test()
    {
        $this->assertEquals(0, 0);
    }

    /*public function testServiceWiring()
    {
        $kernel = new BtbaChatTestingKernel();
        $kernel->boot();
        $container = $kernel->getContainer();

    }*/
    public function testServiceWiringWithConfiguration()
    {


        $kernel = new BtbaChatTestingKernel([
            'update_interval' => 1000,
            'message_class' => 'App\Entity\Message.php',
            'author_class' => 'App\Entity\Author.php'
        ]);
        $kernel->boot();
        $container = $kernel->getContainer();

        //test services 
        $type = $container->get('btba_chat.type');
        $this->assertInstanceOf(ChatMessageType::class, $type);

        $controller = $container->get('btba_chat.controller');
        $this->assertInstanceOf(ChatController::class, $controller);
    }
}

class BtbaChatTestingKernel extends Kernel
{
    private $btbaChatConfig;

    public function __construct(array $btbaChatConfig = [])
    {
        $this->btbaChatConfig = $btbaChatConfig;

        parent::__construct('test', true);
    }
    public function registerBundles()
    {
        return [
            new BtbaChatBundle()
        ];
    }
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function (ContainerBuilder $container) {
            $container->loadFromExtension('btba_chat', $this->btbaChatConfig);
        });
    }
}
