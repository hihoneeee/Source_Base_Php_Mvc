<?php
class Mapper
{
    public static function map(object $source, object $destination): object
    {
        $sourceReflection = new ReflectionObject($source);
        $destinationReflection = new ReflectionObject($destination);

        foreach ($destinationReflection->getProperties() as $property) {
            $name = $property->getName();

            if ($sourceReflection->hasProperty($name)) {
                $sourceProperty = $sourceReflection->getProperty($name);
                $sourceProperty->setAccessible(true);

                $property->setAccessible(true);
                $property->setValue($destination, $sourceProperty->getValue($source));
            }
        }

        return $destination;
    }
}
