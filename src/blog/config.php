<?php
use App\Blog\BlogModule;
use function \DI\get ;
use function \DI\object ;

return [
    'blog.prefix'=> '/blog',
    BlogModule::class => object()->constructorParameter('prefix', get('blog.prefix'))
];
