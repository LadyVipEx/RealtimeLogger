<?php 

namespace RealtimeLogger\Client\Describer;

use RealtimeLogger\Client\Describer\AbstractValueDescriber;
use RealtimeLogger\Client\ValueDescriber;
use ReflectionObject;

class ObjectValueDescriber extends AbstractValueDescriber
{
    /**
     * Handle's and set the value
     * 
     * @param  mixed $value
     * @return $this
     */
    public function handleValue($object)
    {
        $describedValues = [];
        
        $reflectionObject = new ReflectionObject($object);

        $this->setPrefix($reflectionObject->getShortName());

        foreach ($reflectionObject->getConstants() as $key => $value) 
        {
            $describedValues[] = $this->getValueDescriber()
                ->getValueDescriber($value)
                ->setPrefix('const')
                ->setKey($key)
                ->getDescribed();
        }

        foreach ($reflectionObject->getProperties() as $reflectionProperty) 
        {
            $reflectionProperty->setAccessible(true);

            $describedValues[] = $this->getValueDescriber()
                ->getValueDescriber($reflectionProperty->getValue($object))
                ->setPrefix($this->getVisibility($reflectionProperty))
                ->setKey($reflectionProperty->getName())
                ->getDescribed();
        }

        foreach ($reflectionObject->getMethods() as $reflectionMethod) 
        {
            $parameters = [];

            foreach ($reflectionMethod->getParameters() as $reflectionParameter) 
            {
                $parameters[] = $reflectionParameter->getName();
            }

            $describedValues[] = $this->getValueDescriber()
                ->getValueDescriber('function(' . join(', ', $parameters) . ') {}')
                ->setPrefix($this->getVisibility($reflectionMethod))
                ->isExplainingString(true)
                ->setKey($reflectionMethod->getName())
                ->getDescribed();
        }

        return $this->setValue($describedValues);
    }

    public function getVisibility($object)
    {
        $visibility = [];

        if ($object->isPrivate()) 
        {
            $visibility[] = 'private';
        }
        else if ($object->isProtected())  
        {
            $visibility[] = 'protected';
        }
        else if ($object->isPublic())  
        {
            $visibility[] = 'public';
        }
        
        if ($object->isStatic()) 
        {
            array_unshift($visibility, 'static');
        }

        return join(' ', $visibility);
    }
}
