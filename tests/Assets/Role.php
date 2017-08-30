<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Tests\Assets;

/**
 * Class Model
 *
 * @Source("roles")
 * @HasMany("id","User","role_id",{"alias":"users"})
 */
class Role
{
    /**
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", nullable=false)
     */
    protected $id;

    /**
     * @Column(column='username', type='string', nullable='false')
     * @FormElement(label="Email", type="Email", required=true)
     */
    protected $code;

    protected static $identityField = 'id';

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCode() : string
    {
        return $this->code;
    }
}
