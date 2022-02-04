<?php

namespace Egal\Core\Support;

class ClassFinder
{
    // TODO делать поиск по пути
    public static function getClasses(string $pathClasses, string $namespaceClasses, string $parentClass = null, &$classes = []): array
    {
        foreach (array_diff(scandir($pathClasses), ['.', '..']) as $file) {
            $fileWithPath = realpath($pathClasses . DIRECTORY_SEPARATOR . $file);
            if (!is_dir($fileWithPath)) {
                $className = basename($file, '.php');
                $class = $namespaceClasses . '\\' . $className;
                if (class_exists($class)) {
                    if ($parentClass) {
                        if (get_parent_class($class) === $parentClass) {
                            $classes[$className] = $class;
                        }
                    } else {
                        $classes[$className] = $class;
                    }
                }
            } else {
                self::getClasses($fileWithPath, $namespaceClasses . '\\' . $file, null, $classes);
            }
        }
        return $classes;
    }
}