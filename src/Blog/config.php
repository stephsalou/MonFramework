<?php
use App\Blog\BlogModule;
use function \DI\get ;
use function \DI\create ;

return [
    'blog.prefix'=> '/blog',
//    BlogModule::class => create()->constructor(get('blog.prefix'))
];
