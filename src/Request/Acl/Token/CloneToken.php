<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/7/31
 * Time: 下午7:01
 */
namespace EasySwoole\Consul\Request\Acl\Token;

use EasySwoole\Spl\SplBean;

class CloneToken extends SplBean
{
    /**
     * @var string
     */
    protected $AccessorID;
    /**
     * @var string
     */
    protected $Description;

    protected $clone;
    /**
     * @return null|string
     */
    public function getAccessorID(): ?string
    {
        return $this->AccessorID;
    }

    /**
     * @param string $AccessorID
     */
    public function setAccessorID(string $AccessorID): void
    {
        $this->AccessorID = $AccessorID;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->Description;
    }

    /**
     * @param string $Description
     */
    public function setDescription(string $Description): void
    {
        $this->Description = $Description;
    }

}