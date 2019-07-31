<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/7/31
 * Time: 上午12:55
 */
namespace EasySwoole\Consul;

use EasySwoole\Consul\Request\Acl\AuthMethod;
use EasySwoole\Consul\Request\Acl\AuthMethods;
use EasySwoole\Consul\Request\Acl\BindingRule;
use EasySwoole\Consul\Request\Acl\BindingRules;
use EasySwoole\Consul\Request\Acl\Bootstrap;
use EasySwoole\Consul\Request\Acl\CloneACLToken;
use EasySwoole\Consul\Request\Acl\Create;
use EasySwoole\Consul\Request\Acl\Destroy;
use EasySwoole\Consul\Request\Acl\Info;
use EasySwoole\Consul\Request\Acl\Lists;
use EasySwoole\Consul\Request\Acl\Login;
use EasySwoole\Consul\Request\Acl\Logout;
use EasySwoole\Consul\Request\Acl\Policy;
use EasySwoole\Consul\Request\Acl\Replication;
use EasySwoole\Consul\Request\Acl\Role;
use EasySwoole\Consul\Request\Acl\Roles;
use EasySwoole\Consul\Request\Acl\Token;
use EasySwoole\Consul\Request\Acl\Token\GetSelf;
use EasySwoole\Consul\Request\Acl\Token\CloneToken;
use EasySwoole\Consul\Request\Acl\Tokens;
use EasySwoole\Consul\Request\Acl\Update;

class Acl extends BaseFunc
{
    /**
     * Bootstrap ACLs
     * @param Bootstrap $bootstrap
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function bootstrap(Bootstrap $bootstrap)
    {
        $this->putJSON($bootstrap);
    }

    /**
     * Check ACL Replication
     * @param Replication $replication
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function replication(Replication $replication)
    {
        $this->getJson($replication);
    }

    /**
     * Lack
     * Translate Rules
     */

    /**
     * Lack
     * Translate a Legacy Token's Rules
     */

    /**
     * Login to Auth Method
     * @param Login $login
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function login(Login $login)
    {
        $this->postJson($login);
    }

    /**
     * Logout from Auth Method
     * @param Logout $logout
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function logout(Logout $logout)
    {
        $header = array(
            'X-Consul-Token' => 'b78d37c7-0ca7-5f4d-99ee-6d9975ce4586',
        );
        $this->postJson($logout, '', $header);
    }

    /**
     * Create a Token  OR Read a Token OR Update a Token
     * @param Token $token
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function token(Token $token)
    {
        $this->putJSON($token);
    }

    /**
     * Read a Token
     * @param Token $token
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function readToken(Token $token)
    {
        if (!empty($token->getAccessorID())) {
            $action = $token->getAccessorID();
            $token->setAccessorID('');
        }
        $this->getJson($token, $action);
    }

    /**
     * Read Self Token
     * @param GetSelf $getSelf
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function self(GetSelf $getSelf)
    {
        $beanRoute = new \ReflectionClass($getSelf);
        if (empty($beanRoute)) {
            throw new \ReflectionException(static::class);
        }
        $route = substr($beanRoute->name, strpos($beanRoute->name,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, 0, strripos($route,'\\') + 1);
        $route .= 'self';
        $route = strtolower(str_replace('\\','/',$route));
        $useRef = [
            'reflection' => true,
            'url' => $this->route.$route,
        ];
        $header = array(
            'X-Consul-Token' => '6a1253d2-1785-24fd-91c2-f8e78c745511',
        );
        $this->postJson($getSelf, '', $header, $useRef);
    }

    /**
     * Clone a Token
     * @param CloneToken $cloneToken
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function cloneToken(CloneToken $cloneToken)
    {
        $beanRoute = new \ReflectionClass($cloneToken);
        if (empty($beanRoute)) {
            throw new \ReflectionException(static::class);
        }
        $route = substr($beanRoute->name, strpos($beanRoute->name,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, 0, strripos($route,'\\') + 1);
        $route .= 'clone';
        $route = strtolower(str_replace('\\','/',$route));
        $useRef = [
            'reflection' => true,
            'url' => $this->route.$route,
        ];
        if (!empty($cloneToken->getAccessorID())) {
            $this->route .= '/' . $cloneToken->getAccessorID();
            $cloneToken->setAccessorID('');
        }
        $this->putJSON($cloneToken, '', false, $useRef);
    }

    /**
     * Delete a Token
     * @param Token $token
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function delete(Token $token)
    {
        if (!empty($token->getAccessorID())) {
            $action = $token->getAccessorID();
            $token->setAccessorID('');
        }
        $this->deleteJson($token, $action);
    }

    /**
     * List Tokens
     * @param Tokens $tokens
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function tokens(Tokens $tokens)
    {
        $this->getJson($tokens);
    }

    /**
     * Create ACL Token
     * @param Create $create
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function create(Create $create)
    {
        $this->putJSON($create);
    }

    /**
     * Update ACL Token
     * @param Update $update
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function update(Update $update)
    {
        $this->putJSON($update);
    }

    /**
     * Delete ACL Token
     * @param Destroy $destroy
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function destroy(Destroy $destroy)
    {
        if (!empty($destroy->getUuid())) {
            $action = $destroy->getUuid();
            $destroy->setUuid('');
        }
        $this->putJSON($destroy, $action);
    }

    /**
     * Read ACL Token
     * @param Info $info
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function info(Info $info)
    {
        if (!empty($info->getUuid())) {
            $action = $info->getUuid();
            $info->setUuid('');
        }
        $this->putJSON($info, $action);
    }

    /**
     * Clone ACL Token
     * @param CloneACLToken $cloneACLToken
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function cloneAclToken(CloneACLToken $cloneACLToken)
    {
        $beanRoute = new \ReflectionClass($cloneACLToken);
        if (empty($beanRoute)) {
            throw new \ReflectionException(static::class);
        }
        $route = substr($beanRoute->name, strpos($beanRoute->name,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, 0, strripos($route,'\\') + 1);
        $route .= 'clone';
        $route = strtolower(str_replace('\\','/',$route));
        $useRef = [
            'reflection' => true,
            'url' => $this->route.$route,
        ];
        if (!empty($cloneACLToken->getUuid())) {
            $this->route .= '/' . $cloneACLToken->getUuid();
            $cloneACLToken->setUuid('');
        }
        $this->putJSON($cloneACLToken, '',true,$useRef);
    }

    /**
     * @param Lists $lists
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function getList(Lists $lists)
    {
        $beanRoute = new \ReflectionClass($lists);
        if (empty($beanRoute)) {
            throw new \ReflectionException(static::class);
        }
        $route = substr($beanRoute->name, strpos($beanRoute->name,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, 0, strripos($route,'\\') + 1);
        $route .= 'list';
        $route = strtolower(str_replace('\\','/',$route));
        $useRef = [
            'reflection' => true,
            'url' => $this->route.$route,
        ];
        $this->getJson($lists,'',true, $useRef);
    }

    /**
     * Create a Policy
     * @param Policy $policy
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function policy(Policy $policy)
    {
        if (!empty($policy->getId())) {
            $action = $policy->getId();
            $policy->setId('');
            $this->putJSON($policy, $action);
        } else {
            $this->putJSON($policy);
        }
    }

    /**
     * Update a Policy
     * @param Policy $policy
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function updatePolicy(Policy $policy)
    {
        if (!empty($policy->getId())) {
            $action = $policy->getId();
            $policy->setId('');
        }
        $this->putJSON($policy, $action);
    }

    /**
     * Read a Policy
     * @param Policy $policy
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function readPolicy(Policy $policy)
    {
        if (!empty($policy->getId())) {
            $action = $policy->getId();
            $policy->setId('');
        }
        $this->getJson($policy, $action);
    }

    /**
     * Delete a Policy
     * @param Policy $policy
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function deletePolicy(Policy $policy)
    {
        if (!empty($policy->getId())) {
            $action = $policy->getId();
            $policy->setId('');
        }
        $this->deleteJson($policy, $action);
    }

    /**
     * Create a Role
     * @param Role $role
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function role(Role $role)
    {
        $this->putJSON($role);
    }

    /**
     * Read a Role
     * @param Role $role
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function readRole(Role $role)
    {
        if (!empty($role->getId())) {
            $action = $role->getId();
            $role->setId('');
        }
        $this->getJson($role, $action);
    }

    /**
     * Update a Role
     * @param Role $role
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function updateRole(Role $role)
    {
        if (!empty($role->getId())) {
            $action = $role->getId();
            $role->setId('');
        }
        $this->putJSON($role, $action);
    }

    /**
     * Delete a Role
     * @param Role $role
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function deleteRole(Role $role)
    {
        if (!empty($role->getId())) {
            $action = $role->getId();
            $role->setId('');
        }
        $this->deleteJson($role, $action);
    }

    /**
     * Read a Role by Name
     * @param Role\Name $name
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function name(Role\Name $name)
    {
        if (!empty($name->getname())) {
            $action = $name->getname();
            $name->setname('');
        }
        $this->getJson($name, $action);
    }

    /**
     * List Roles
     * @param Roles $roles
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function roles(Roles $roles)
    {
        $this->getJson($roles);
    }

    /**
     * Create an Auth Method
     * @param AuthMethod $authMethod
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function authMethod(AuthMethod $authMethod)
    {
        $beanRoute = new \ReflectionClass($authMethod);
        if (empty($beanRoute)) {
            throw new \ReflectionException(static::class);
        }
        $route = substr($beanRoute->name, strpos($beanRoute->name,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, 0, strripos($route,'\\') + 1);
        $route .= 'auth-method';
        $route = strtolower(str_replace('\\','/',$route));
        $useRef = [
            'reflection' => true,
            'url' => $this->route.$route,
        ];
        $this->putJSON($authMethod, '',true,$useRef);
    }

    /**
     * Read an Auth Method
     * @param AuthMethod $authMethod
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function readAuthMethod(AuthMethod $authMethod)
    {
        $beanRoute = new \ReflectionClass($authMethod);
        if (empty($beanRoute)) {
            throw new \ReflectionException(static::class);
        }
        $route = substr($beanRoute->name, strpos($beanRoute->name,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, 0, strripos($route,'\\') + 1);
        $route .= 'auth-method';
        $route = strtolower(str_replace('\\','/',$route));
        $useRef = [
            'reflection' => true,
            'url' => $this->route.$route,
        ];
        if (!empty($authMethod->g())) {
            $this->route .= '/' . $authMethod->getName();
            $authMethod->setName('');
        }
        $this->getJson($authMethod, '',true,$useRef);
    }

    /**
     * Update an Auth Method
     * @param AuthMethod $authMethod
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function updateAuthMethod(AuthMethod $authMethod)
    {
        $beanRoute = new \ReflectionClass($authMethod);
        if (empty($beanRoute)) {
            throw new \ReflectionException(static::class);
        }
        $route = substr($beanRoute->name, strpos($beanRoute->name,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, 0, strripos($route,'\\') + 1);
        $route .= 'auth-method';
        $route = strtolower(str_replace('\\','/',$route));
        $useRef = [
            'reflection' => true,
            'url' => $this->route.$route,
        ];
        if (!empty($authMethod->g())) {
            $this->route .= '/' . $authMethod->getName();
            $authMethod->setName('');
        }
        $this->putJSON($authMethod, '',true,$useRef);
    }

    /**
     * Delete an Auth Method
     * @param AuthMethod $authMethod
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function deleteAuthMethod(AuthMethod $authMethod)
    {
        $beanRoute = new \ReflectionClass($authMethod);
        if (empty($beanRoute)) {
            throw new \ReflectionException(static::class);
        }
        $route = substr($beanRoute->name, strpos($beanRoute->name,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, 0, strripos($route,'\\') + 1);
        $route .= 'auth-method';
        $route = strtolower(str_replace('\\','/',$route));
        $useRef = [
            'reflection' => true,
            'url' => $this->route.$route,
        ];
        if (!empty($authMethod->g())) {
            $this->route .= '/' . $authMethod->getName();
            $authMethod->setName('');
        }
        $this->deleteJson($authMethod, '',true,$useRef);
    }

    /**
     * List Auth Methods
     * @param AuthMethods $authMethods
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function authMethods(AuthMethods $authMethods)
    {
        $beanRoute = new \ReflectionClass($authMethods);
        if (empty($beanRoute)) {
            throw new \ReflectionException(static::class);
        }
        $route = substr($beanRoute->name, strpos($beanRoute->name,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, 0, strripos($route,'\\') + 1);
        $route .= 'auth-method';
        $route = strtolower(str_replace('\\','/',$route));
        $useRef = [
            'reflection' => true,
            'url' => $this->route.$route,
        ];
        $this->getJson($authMethods, '',true,$useRef);
    }

    /**
     * Create a Binding Rule
     * @param BindingRule $bindingRule
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function bindingRule(BindingRule $bindingRule)
    {
        $beanRoute = new \ReflectionClass($bindingRule);
        if (empty($beanRoute)) {
            throw new \ReflectionException(static::class);
        }
        $route = substr($beanRoute->name, strpos($beanRoute->name,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, 0, strripos($route,'\\') + 1);
        $route .= 'binding-rule';
        $route = strtolower(str_replace('\\','/',$route));
        $useRef = [
            'reflection' => true,
            'url' => $this->route.$route,
        ];
        $this->putJSON($bindingRule, '',true,$useRef);
    }

    /**
     * Read a Binding Rule
     * @param BindingRule $bindingRule
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function readBindingRule(BindingRule $bindingRule)
    {
        $beanRoute = new \ReflectionClass($bindingRule);
        if (empty($beanRoute)) {
            throw new \ReflectionException(static::class);
        }
        $route = substr($beanRoute->name, strpos($beanRoute->name,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, 0, strripos($route,'\\') + 1);
        $route .= 'binding-rule';
        $route = strtolower(str_replace('\\','/',$route));
        $useRef = [
            'reflection' => true,
            'url' => $this->route.$route,
        ];
        if (!empty($bindingRule->getid())) {
            $this->route .= '/' . $bindingRule->getid();
            $bindingRule->setid('');
        }
        $this->getJson($bindingRule, '',true,$useRef);
    }

    /**
     * Update a Binding Rule
     * @param BindingRule $bindingRule
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function updateBindingRule(BindingRule $bindingRule)
    {
        $beanRoute = new \ReflectionClass($bindingRule);
        if (empty($beanRoute)) {
            throw new \ReflectionException(static::class);
        }
        $route = substr($beanRoute->name, strpos($beanRoute->name,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, 0, strripos($route,'\\') + 1);
        $route .= 'binding-rule';
        $route = strtolower(str_replace('\\','/',$route));
        $useRef = [
            'reflection' => true,
            'url' => $this->route.$route,
        ];
        if (!empty($bindingRule->getid())) {
            $this->route .= '/' . $bindingRule->getid();
            $bindingRule->setid('');
        }
        $this->putJSON($bindingRule, '',true,$useRef);
    }

    /**
     * Delete a Binding Rule
     * @param BindingRule $bindingRule
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function deleteBindingRule(BindingRule $bindingRule)
    {
        $beanRoute = new \ReflectionClass($bindingRule);
        if (empty($beanRoute)) {
            throw new \ReflectionException(static::class);
        }
        $route = substr($beanRoute->name, strpos($beanRoute->name,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, 0, strripos($route,'\\') + 1);
        $route .= 'binding-rule';
        $route = strtolower(str_replace('\\','/',$route));
        $useRef = [
            'reflection' => true,
            'url' => $this->route.$route,
        ];
        if (!empty($bindingRule->getid())) {
            $this->route .= '/' . $bindingRule->getid();
            $bindingRule->setid('');
        }
        $this->deleteJson($bindingRule, '',true,$useRef);
    }

    /**
     * List Binding Rules
     * @param BindingRules $bindingRules
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \ReflectionException
     */
    public function bindingRules(BindingRules $bindingRules)
    {
        $beanRoute = new \ReflectionClass($bindingRules);
        if (empty($beanRoute)) {
            throw new \ReflectionException(static::class);
        }
        $route = substr($beanRoute->name, strpos($beanRoute->name,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, strpos($route,'\\') + 1);
        $route = substr($route, 0, strripos($route,'\\') + 1);
        $route .= 'binding-rule';
        $route = strtolower(str_replace('\\','/',$route));
        $useRef = [
            'reflection' => true,
            'url' => $this->route.$route,
        ];
        $this->getJson($bindingRules, '',true,$useRef);
    }
}