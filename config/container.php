<?php
/**
 * Initialize a dependency injection container that implemented PSR-11 and return the container.
 */

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\Context\ApplicationContext;
use Hyperf\Di\Container;
use Hyperf\Di\Definition\DefinitionSourceFactory;
use HyperfHelper\Dependency\Annotation\Collector\DependencyCollector;

$container = new Container((new DefinitionSourceFactory())());

if (! $container instanceof \Psr\Container\ContainerInterface) {
    throw new RuntimeException('The dependency injection container is invalid.');
}

/*     start */
// Add this line between `new Container` and `setContainer()`
DependencyCollector::walk([$container, 'define']);
/*      end */

return ApplicationContext::setContainer($container);
