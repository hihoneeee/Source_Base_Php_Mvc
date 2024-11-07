<?php class Mapper {
    public static function map($source, $destination) {
        $sourceReflection = new ReflectionClass($source);
        $destReflection = new ReflectionClass($destination);

        foreach ($sourceReflection->getProperties() as $prop) {
            $name = $prop->getName();
            if ($destReflection->hasProperty($name)) {
                $prop->setAccessible(true);
                $destProp = $destReflection->getProperty($name);
                $destProp->setAccessible(true);
                $destProp->setValue($destination, $prop->getValue($source));
            }
        }

        return $destination;
    }
}