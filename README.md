![POGODEV](https://github.com/12rambau/Chat-bundle/blob/master/assets/img/github_logo.png?raw=true)

# Welcome to the chat bundle project !
[![Build Status](https://travis-ci.org/12rambau/Chat-bundle.svg?branch=master)](https://travis-ci.org/12rambau/Chat-bundle) [![Maintainability](https://api.codeclimate.com/v1/badges/64fb6d9d5c953d42eba9/maintainability)](https://codeclimate.com/github/12rambau/Chat-bundle/maintainability) [![Test Coverage](https://api.codeclimate.com/v1/badges/64fb6d9d5c953d42eba9/test_coverage)](https://codeclimate.com/github/12rambau/Chat-bundle/test_coverage) [![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://github.com/12rambau/Chat-bundle/LICENSE)

This project aim to offer a simple chat service to any symfony application.

## installation
As this project is very new, we decided not to add a receipe on Symfony Flex at the moment so the configuration must be performed manually.

### register

First install the dependencies by running this comand in your repository
```
composer require btba/chat-bundle
```

and register the bundle
```php
// config/bundles.php

return [
    //your bundles
    Btba\ChatBundle\BtbaChatBundle::class => ['all' => true]
];
```
### config

then in your app directory add a config file. The following parameters are mandatory:
```yaml
# config/packages/btba_chat.yaml

btba_chat:
    update_interval: 1000
    message_class: App\Entity\ChatMessage
    author_class: App\Entity\User
```

> `update_interval` refers to the time between two refresh of the chat  
> `message_class` refers to the ORM class that host the messages (Doctrine supported)  
> `author_class` refers to the ORM class that host the auhors (Doctrine supported)


Then register the bundle routes and change the `prefix` according to your needs 
```yaml
# config/routes/btba_chat.yaml

btba_chat:
    resource: '@BtbaChatBundle/Resources/config/routes.yaml'
    prefix: /chat-bundle/
```

### database

In order to save authors and messages in your database you need to create at least two classes that extends the bundle model as such:
```php
// App\Entity\User

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends BaseAuthor implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    protected $username;
    
     /**
     * @ORM\OneToMany(targetEntity="App\Entity\ChatMessage", mappedBy="author", cascade={"persist"}, orphanRemoval=true)
     */
    private $messages;
```

```php
// App\Entity\ChatMesssage

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Btba\ChatBundle\Model\BaseChatMessage;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChatMessageRepository")
 */
class ChatMessage extends BaseChatMessage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $content;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="messages", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected $author;

}
```


and in the `message_class` repository add the following trait:
```php
// src/Repository/ChatMessageRepository.php

namespace App\Repository;

use Btba\ChatBundle\Query\MessageQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class ChatMessageRepository extends ServiceEntityRepository
{
    use MessageQuery;
    
    //your code...
}
```


configuration is over you are good to go !


## usage

To use this bundle, you need to add several component to your views. 

If you're using encore, add the following assets to you're `app.css` file 
```css
@import '../../vendor/btba/chat-bundle/assets/css/chat.css';
```
and `app.js` file 
```js
import * as chat from '../../vendor/btba/chat-bundle/assets/js/chat';

//functions for the chat window management 
$(function(){
    $("#chevron").click(function(e) {
        chat.changeChevron(e.target);
    });
    
    $("#chat-submit").click(function(e) {
        chat.submitChat(e);
    });
});
```

in your view you now just have to render the following controller:
```twig
{{ render(controller('Btba\\ChatBundle\\Controller\\ChatController::show')) }}

