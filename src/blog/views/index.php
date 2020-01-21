<?= $renderer->render('header'); ?>

<h1>Bienvenue sur le blog</h1>

<ul>
    <li><a href="<?= $router->generateUri('blog.show', ['slug'=>'aze-aze54-za']); ?>">Article 1</a></li>
    <li>article-2</li>
    <li>article-3</li>
    <li>article-4</li>
    <li>article-5</li>
    <li>article-6</li>
</ul>
<?= $renderer->render('footer'); ?>
