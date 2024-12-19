<?php

namespace App\Security\Identity;

use App\Security\Exception\InvalidSubjectIdentityException;
use App\Security\Exception\UnexpectedTypeException;
use App\Utils\ClassUtils;

class SubjectIdentity extends AbstractBaseIdentity
{
/**
     * @var null|object
     */
    private $subject;

    /**
     * Constructor.
     *
     * @param string      $identifier The identifier
     * @param string      $type       The type
     * @param null|object $subject    The instance of subject
     *
     * @throws InvalidArgumentException When the identifier is empty
     * @throws InvalidArgumentException When the type is empty
     * @throws UnexpectedTypeException  When the subject instance is not an object
     */
    public function __construct(string $type, string $identifier, $subject = null)
    {
        parent::__construct($type, $identifier);

        if (null !== $subject && !\is_object($subject)) {
            throw new UnexpectedTypeException($subject, 'object|null');
        }

        $this->subject = $subject;
    }

/**
     * Creates a subject identity for the given object.
     *
     * @param object $object The object
     *
     * @throws InvalidSubjectIdentityException
     *
     * @return SubjectIdentity
     */
    public static function fromObject($object): SubjectIdentity
    {
        try {
            if (!\is_object($object)) {
                throw new UnexpectedTypeException($object, 'object');
            }

            if ($object instanceof SubjectIdentity) {
                return $object;
            }
            if (method_exists($object, 'getId')) {
                return new self(ClassUtils::getClass($object), (string) $object->getId(), $object);
            }
        } catch (\InvalidArgumentException $e) {
            throw new InvalidSubjectIdentityException($e->getMessage(), 0, $e);
        }

        throw new InvalidSubjectIdentityException('The object must have a method named "getId"');
    }

    /**
     * Creates a subject identity for the given class name.
     *
     * @param string $class The class name
     *
     * @return static
     */
    public static function fromClassname(?string $class): SubjectIdentity
    {
        try {
            if (!class_exists($class)) {
                throw new \InvalidArgumentException(sprintf('The class "%s" does not exist', $class));
            }

            return new self(ClassUtils::getRealClass($class), 'class');
        } catch (\InvalidArgumentException $e) {
            throw new InvalidSubjectIdentityException($e->getMessage(), 0, $e);
        }
    }

    /**
     * Get the subject identity.
     *
     * @param object|string|SubjectIdentity $subject The subject instance or classname
     *
     * @return SubjectIdentityInterface
     */
    public static function getSubjectIdentity($subject): SubjectIdentity
    {
        if ($subject instanceof SubjectIdentity) {
            return $subject;
        }

        if (\is_string($subject)) {
            return SubjectIdentity::fromClassname($subject);
        }

        if (\is_object($subject)) {
            return SubjectIdentity::fromObject($subject);
        }

        throw new UnexpectedTypeException($subject, SubjectIdentity::class.'|object|string');
    }

    public function getObject()
    {
        return $this->subject;
    }
}