<?php

declare(strict_types=1);

namespace App\DependencyInjection\Compiler;

use App\Services\ClientBonus\Checker\ClientBonusCheckerPool;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ClientBonusCheckerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(ClientBonusCheckerPool::class)) {
            return;
        }

        $definition = $container->findDefinition(ClientBonusCheckerPool::class);

        $taggedServices = $container->findTaggedServiceIds('app.client_bonus_checker');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addClientBonusChecker', [new Reference($id)]);
        }
    }
}
