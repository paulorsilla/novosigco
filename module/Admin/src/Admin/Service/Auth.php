<?php

namespace Admin\Service;

use Core\Service\Service;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\Ldap as AuthAdapterLDAP;
use Zend\Authentication\Adapter\DbTable as AuthAdapterDbTable;
use Zend\Config\Factory as Factory;

/**
 * Serviço responsável pela autenticação dos usuários na aplicação
 *
 * @category Admin
 * @package Service
 * @author Paulo R. Silla <paulo.silla@embrapa.br>
 */
class Auth extends Service {
    
    /**
     * Faz a autenticação dos usuários
     *
     * @param array $params
     * @return array
     */
    public function authenticate($params, $em) {
        if (!isset($params['nome']) || !isset($params['senha'])) {
            throw new \exception("Parâmetros inválidos");
        }
        $nome = $params['nome'];
        $senha = $params['senha']; 
        $user = $em->getRepository('\Admin\Model\Usuario')->findOneBy(array('login' => $nome));
        if (!$user) {
        	error_log('Usuario invalido ou nao cadastrado');
            return 'Usuário inválido ou não cadastrado';
            //Verifica se o usuário é válido ou se ele está cadastrado para utilizar o sistema
            //	throw new \exception("Usuário inválido ou não cadastrado");
        }

        $auth = new AuthenticationService();

        //Realiza a autenticação na base LDAP
        if (!is_file('./module/Admin/config/ldapconfig.php')) {
            throw new \exception("Falta arquivo de configuração ldap em: ./module/Admin/config/ldapconfig.php");
        }
        $config = new Factory();
        $options = $config->fromFile('./module/Admin/config/ldapconfig.php');
        $authAdapter = new AuthAdapterLDAP($options, $nome, $senha);
        $result = $auth->authenticate($authAdapter);
        
//        error_log(print_r($result, TRUE));
        
        if (!$result->isValid()) {
            return 'Login ou senha inválidos';
        }

        //salva o usuario na sessão
        $session = $this->getServiceManager()->get('Session');
        $session->offsetSet('user', $user);
        return true;
    }

    /**
     * Faz a autorização do usuário para acessar o recurso
     * @param string $moduleName Nome do módulo sendo acessado
     * @param string $controllerName Nome do controller
     * @param string $actionName Nome da ação
     * @return boolean
     */
    public function authorize($moduleName, $controllerName, $actionName) {
        $auth = new AuthenticationService();
        $role = 'comum';
        if ($auth->hasIdentity()) {
            $session = $this->getServiceManager()->get('Session');
            $user = $session->offsetGet('user');
            $role = $user->papel;
        }
        $resource = $controllerName . '.' . $actionName;
        $acl = $this->getServiceManager()->get('Core\Acl\Builder')->build();
        if ($acl->isAllowed($role, $resource)) {
            return true;
        }
        return false;
    }

    /**
     * Faz o logout do sistema
     *
     * @return void
     */
    public function logout() {
        $auth = new AuthenticationService();
        $session = $this->getServiceManager()->get('Session');
        $session->offsetUnset('user');
        $auth->clearIdentity();
        return true;
    }
}
