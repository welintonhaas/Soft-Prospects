<?php
namespace DAO;
mysqli_report(MYSQLI_REPORT_STRICT);
require_once('../models/Prospect.php');
use models\Prospect;

/**
 * Esta classe é responsável por fazer a comunicação com o banco de dados,
 * promovendo as funções de logar e incluir novo prospect
 * @author Welinton Haas
 *
 */
class DAOProspect{

    /**
    * Inclui um novo prospect no banco de dados
    * @param Prospect $prospect Objeto do tipo Prospect que deverá ser cadastrado
    * @return TRUE|Exception TRUE para inclusão bem sucedida ou Exception para inclusão mal sucedida
    */
    public function incluirProspect($nome, $email, $celular, $facebook, $whatsapp)
    {
        
        try {
            $connDB = $this->conectarBanco();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $sqlInsert = $connDB->prepare(" INSERT INTO 
                                            prospect  (nome, email, celular, facebook, whatsapp)
                                        VALUES
                                            (?, ?, ?, ?, ?)");
        $sqlInsert->bind_param("sssss", $nome, $email, $celular, $facebook, $whatsapp);
        $sqlInsert->execute();

        if(!$sqlInsert->error){
            $retorno =  TRUE;
        }else{
            throw new \Exception("Não foi possível incluir novo prospect!");
            die;
        }

        $connDB->close();
        $sqlInsert->close();
        return $retorno;

    }

    /**
    * Atualiza um prospect no banco de dados
    * @param Prospect $prospect Objeto do tipo Prospect que deverá ser atualizado
    * @return TRUE|Exception TRUE para alteração bem sucedida ou Exception para alteração mal sucedida
    */
    public function atualizarProspect($id, $nome, $email, $celular, $facebook, $whatsapp)
    {
        
        try {
            $connDB = $this->conectarBanco();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $sqlUpdate = $connDB->prepare(" UPDATE 
                                            prospect 
                                        SET
                                            nome = ?, 
                                            email = ?, 
                                            celular = ?, 
                                            facebook = ?, 
                                            whatsapp = ?
                                        WHERE 
                                            id = ?");
        $sqlUpdate->bind_param("sssssi", $nome, $email, $celular, $facebook, $whatsapp, $id);
        $sqlUpdate->execute();

        if(!$sqlUpdate->error){
            $retorno =  TRUE;
        }else{
            throw new \Exception("Não foi atualizar o prospect!");
            die;
        }

        $connDB->close();
        $sqlInsert->close();
        return $retorno;

    }
    
    /**
    * Excluir um prospect no banco de dados
    * @param Prospect $prospect Objeto do tipo Prospect que deverá ser excluir
    * @return TRUE|Exception TRUE para exclusão bem sucedida ou Exception para exclusão mal sucedida
    */
    public function excluirProspect($id)
    {
        
        try {
            $connDB = $this->conectarBanco();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $sqlDelete = $connDB->prepare(" DELETE 
                                            prospect
                                        WHERE 
                                            id = ? ");
        $sqlDelete->bind_param("i", $id);
        $sqlDelete->execute();

        if(!$sqlDelete->error){
            $retorno =  TRUE;
        }else{
            throw new \Exception("Não foi excluir o prospect!");
            die;
        }

        $connDB->close();
        $sqlInsert->close();
        return $retorno;

    }
    
    /**
    * Buscar um prospect no banco de dados
    * @param Prospect $prospect Objeto do tipo Prospect que deverá ser encontrado
    * @return Prospect Retorna o prospect encontrado
    */
    public function buscarProspect($email)
    {
        
        try {
            $connDB = $this->conectarBanco();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $sql = $connDB->prepare("SELECT * FROM prospect WHERE email = ? ");
        $sql->bind_param("s", $email);
        $result = $sql->execute();

        if(!$sql->error){
            $retorno =  $result->fetch_assoc();
        }else{
            throw new \Exception("Não foi encontrar o prospect!");
            die;
        }

        $connDB->close();
        $sqlInsert->close();
        return $retorno;

    }

    /**
    * Efetua conexão com ob banco de dados
    * @return MySQLi|Exception Retorna a conexão com o banco de dados MySQL se ela for estabelecida com sucesso ou Exception para inclusão mal sucedida
    */
    private function conectarBanco()
    {
        $ds = DIRECTORY_SEPARATOR;
        $base_dir = dirname(__FILE__).$ds;
        
        require($base_dir.'bd_config.php');

        try{
            $conn = new \MySQLi($dbhost, $user, $password, $db);
            return $conn;
        }catch(mysqli_sql_exception $e){
            throw new \Exception($e);
            die;
        }
        
    }
}
?>