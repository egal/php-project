<?php

namespace Egal\Core\Support;

class ClassFinder
{
    public static function getClasses(string $namespaceClasses, string $parentClass = null): array
    {
        $pathClasses = lcfirst(str_replace('\\', '/', $namespaceClasses));

        $classes = [];
        foreach (scandir(base_path($pathClasses)) as $class) {
            $class = str_replace('.php', '', $class);
            if (!is_dir($class)) {
                if ($parentClass) {
                    if (get_parent_class($namespaceClasses . '\\' . $class) === $parentClass) {
                        $classes[] = $class;
                    }
                } else {
                    $classes[] = $class;
                }
            }
        }

        return $classes;
    }
}