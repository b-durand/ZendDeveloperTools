<?php
/**
 * Zend Developer Tools for Zend Framework (http://framework.zend.com/)
 *
 * @link       http://github.com/zendframework/ZendDeveloperTools for the canonical source repository
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @package    ZendDeveloperTools
 * @subpackage Collector
 */

namespace ZendDeveloperTools\Collector;

use Zend\Mvc\MvcEvent;
use Zend\Authentication\AuthenticationService;

/**
 * Authentication (Zend\Authentication) Data Collector.
 *
 * @category   Zend
 * @package    ZendDeveloperTools
 * @subpackage Collector
 */
class AuthenticationCollector extends AbstractCollector implements AutoHideInterface
{
    /**
     * @var AuthenticationService
     */
    protected $service;

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'authentication';
    }

    /**
     * @inheritdoc
     */
    public function getPriority()
    {
        return 10;
    }

    /**
     * @inheritdoc
     */
    public function collect(MvcEvent $mvcEvent)
    {
        if (!isset($this->data)) {
            $this->data = array();
        }

        $service = $this->getAuthenticationService();
        if (null === $service) {
            $this->data['has_identity'] = false;
            $this->data['identity'] = '';
        } else {
            $this->data['has_identity'] = $service->hasIdentity();
            $this->data['identity'] = $service->getIdentity();
        }
    }

    /**
     * @return AuthenticationService|null
     */
    public function getAuthenticationService()
    {
        if (null === $this->service) {
            $this->service = new AuthenticationService();
        }
        return $this->service;
    }

    /**
     * @param AuthenticationService $service
     * @return AuthenticationCollector
     */
    public function setAuthenticationService(AuthenticationService $service)
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return boolean
     */
    public function hasIdentity()
    {
        return $this->data['has_identity'];
    }

    /**
     * @return string
     */
    public function getIdentity()
    {
        return $this->data['identity'];
    }

    /**
     * @inheritdoc
     */
    public function canHide()
    {
       return true;
    }
}
