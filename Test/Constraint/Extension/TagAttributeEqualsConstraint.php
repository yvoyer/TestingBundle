<?php

namespace Ka\Bundle\TestingBundle\Test\Constraint\Extension;

/**
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class TagAttributeEqualsConstraint extends \PHPUnit_Framework_Constraint
{
    /**
     * @var array
     */
    private $attributes;

    /**
     * @var string
     */
    private $attribute;

    /**
     * @param array $attributes
     * @param string $attribute
     */
    public function __construct(array $attributes, $attribute)
    {
        $this->attributes = $attributes;
        $this->attribute = $attribute;
    }

    /**
     * @param string $other
     *
     * @return bool
     */
    public function matches($other)
    {
        return (isset($this->attributes[0][$this->attribute]) && $this->attributes[0][$this->attribute] === $other);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->attribute . ' attribute is equal to';
    }

    /**
     * @param mixed $other
     *
     * @return string
     */
    protected function failureDescription($other)
    {
        return $this->toString() . ' ' . \PHPUnit_Util_Type::export($other);
    }

} 
