<?php

namespace Btba\ChatBundle\Tests;

use Btba\ChatBundle\BtbaChatBundle;
use Btba\ChatBundle\Controller\ChatController;
use Btba\ChatBundle\Form\ChatMessageType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class ChatTest extends TestCase
{
    public function test()
    {
        $this->assertEquals(0, 0);
    }

    public function testServiceWiring()
    { 
        $kernel = new BtbaChatTestingKernel('test', true);
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
    public function registerBundles()
    { 
        return [
            new BtbaChatBundle()
        ];
    }
    public function registerContainerConfiguration(LoaderInterface $loader)
    { }
}
