# Title: Symfony: MVC & Routing

- Repository: `challenge-symfony-mvc`
- Type of Challenge: `Learning Challenge`
- Duration: `1 day`
- Deployment strategy : `NA`
- Team challenge : `solo`

## Learning objectives
- Install Symfony
- Learn about the lifecycle of software
- Learn to use the MVC layer of Symfony
- Learn to use the routing compontent
- Learn the basics of twig

## The Mission
Today we are going to install Symfony, and then make some small pages and functionality using the MVC, Routing and Twig component.

### Step 1: Install Symfony
We will be installing Symfony 5, make sure that you always use the 5 documentation.

You can find instructions to install Symfony here:
https://symfony.com/doc/current/setup.html

Be sure to read the instructions the installer gives you in the command line. Depending on your installation you might need to do some manual commands to get the symfony binary up and running.

You can finish the installation with running the command

`symfony new --full YOUR_PROJECT_NAME`

Don't forget to create a vhost for this project!

```
<VirtualHost *:80>
    ServerName domain.tld
    ServerAlias www.domain.tld

    DocumentRoot /var/www/project/public
    <Directory /var/www/project/public>
        AllowOverride All
        Order Allow,Deny
        Allow from All
    </Directory>
</VirtualHost>
```

## Creating the routing configuration
In order for Symfony to give you nice routing rules, like /products/example, we need to install a package on apache.

`sudo a2enmod rewrite`

Don't forget to restart your server afterwards!

You also need to install a package in your Symfony Project to configure the routing for you.

`composer require symfony/apache-pack`

If you where a more advanced user you could [do this manually](https://symfony.com/doc/current/setup/web_server_configuration.html).
If you are still having problems with the routes not working check the documentation above.

## What do all those version numbers mean?

### Lifecycle of software
- Alpha & Beta candidates: Unstable software that is NEVER meant to be used in production. Very often you have to be involved with the project to even be allowed access in these stages.
- Release candidate: An unstable (might contain bugs) version that is close to being release while the last improvements and tests are made. While it is unlikly, the structure can still break . Still dangerous to use in a production project!
- Maintained version: The software "should" contain no bugs, and if bugs are security problems are found they are fixed in smaller upgrades.
- End of bug fixes: Bugs are no longer fixed. This is fine for software that is no longer developed, but you want to avoid creating new features in this stage.
End of life: security issues are also not fixed anymore, nothing is updated anymore. You do NOT want any production software in this stage. You should upgrade to a new version or you risk having your application hacked!

### Major versions vs minor versions?
There are three different upgrades, depending on the difference in version number:

- If the first number changes, for example you go from 1.0 to 2.0 it is a **major** upgrade, which can be dangerous because all changes might not be backwards compatible.
For example, version 1 might had a function `SendUserTo($url)` but the function was renamed in version 2 to `redirect($url)` .

Depending on the project a lot if time might needed to be allocated to upgrade and fix all incompatibilities.

- You have a **small upgrade** when the second, for example from version 1.5 tot 1.6. While such an upgrade might add new functionality and bugfixes, it should never break backwards compatibility. It is still advised to do some testing afterwards. 

- A bugfix release has a number beyond the second number (eg. from 1.5.4 tot 1.5.6), contains only **bugfixes and security fixes**. No testing should be needed after these upgrades.

### Step 2: Use the MVC
If you forgot about the MVC you can reread some theory in the previous excersise [OOP Price Calculator](../../../2.The-Hills/php/5.oop-pricecalculator).

You could also read the [extensive Symfony documentation](https://symfony.com/doc/current/controller.html) for more info. This contains crucial information to finish this challenge.

Create a symfony controller called: `LearningController`. You can use `bin/console make:controller` command for this. 

Create a method called `aboutMe`. This page should contains ome *lorum ipsum* text and no further functionality.

This page should be reachable by adding "/about-me" to the url.

#### Twig
In symfony you cannot directly use PHP inside the view layer, you have to use a templating language called Twig.
Later on we will see a more detailed exercise for Twig, for now this is a practical example how you use it:

```php
//inside your action:controller
$this->render('example.twig', ['name' => 'BeCode']);
```

```twig
<h1>Hello {name}!</h1>
```

## Step 3: Let's add some functionality
Add 2 actions to the controller:

- `showMyName`: On this page you will greet the user by his name. The default name is "Unknown".

Below the greeting there should be a form where the user can save his name. When submitted (POST) this should send the user to the `changeMyName` page.

This page should be the homepage. If you just enter the domain name this should be the page that opens up.

- `changeMyName`: 
You should not be able to go to this URL if the method is not a POST request. Find a way in Symfony to enforce this.

If the user arrives here from the change your name form, save his choice in a $_SESSION variable.

After the form is saved, [redirect](https://symfony.com/doc/current/controller.html#redirecting) the user to the `showMyName` action. This should change the URL.

### Step 4: Modify the About Me Page.
It is time to modify the About Me page now, create a link to showMyName. We are not going to hardcode the url, we will use a [Twig helper `path()`](https://symfony.com/doc/current/reference/twig_reference.html#path
) to keep our code flexible by using the route name as parameter.

Add a link on the homepage to go to the About Me page.

### Step 5: Forwarding
Add the user his name on the About Me page (like you already have on the homepage).

If the user is on the About Me page without a name the page should [forward](https://symfony.com/doc/current/controller/forwarding.html) to the homepage, where he can use the form. The URL should not change this time.

#### Step 6: Change the name of your route
Change the url of the About Me page from "about-me" to "about-becode" in the annotation in your controller. If you did everything correctly the links should still work! Magic!

## Nice to have features
- Use the [Session bag](https://symfony.com/doc/current/components/http_foundation/sessions.html) from Symfony instead the native $_SESSION variable

- Complex: Use a symfony form for the "change name" form.
