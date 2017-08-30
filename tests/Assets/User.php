<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Tests\Assets;

use Leaditin\Annotations\Exception\ReflectionException;
use Leaditin\Annotations\Exception\CollectionException as Alias;

/**
 * Class Model
 *
 * @Source("users")
 * @BelongTo("role_id","Role","id",{"alias":"role"})
 */
class User
{
    /**
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", nullable=false)
     */
    protected $id;

    /**
     * @Column(column='role_id', type='int', nullable=false)
     * @FormElement(label="Role", type="String", required=true)
     */
    protected $roleId;

    protected static $identityField = 'id';

    /**
     * @return Role
     */
    public function getRole() : Role
    {
        return new Role();
    }

    /**
     * @param Role $role
     * @return self
     */
    public function setRole(Role $role) : self
    {
        $this->roleId = $role->getId();

        return $this;
    }

    /**
     * @throws \LogicException|ReflectionException|Alias
     */
    public function throwException()
    {
        throw new ReflectionException('Exception');
    }

    public function void()
    {
    }
}
