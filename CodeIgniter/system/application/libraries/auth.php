<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth
{
    private $ci;    
    public function __construct(){
    	$this->ci = &get_instance();        
    }

    function check_logged($classe,$metodo)
    {
    	/*
    	* Criando uma instância do CodeIgniter para poder acessar
    	* banco de dados, sessionns, models, etc... 
    	*/
    	$this->CI =& get_instance();
    	
    	/**
    	* Buscando a classe e metodo da tabela sys_metodos
    	*/
    	$array = array('classe' => $classe, 'metodo' => $metodo);
		$this->CI->db->where($array);
		$query = $this->CI->db->get('sys_metodos');		
		$result = $query->result();
		
		// Se este metodo ainda não existir na tabela sera cadastrado
		if(count($result)==0){
			$data = array(
               	'classe' => $classe ,
               	'metodo' => $metodo ,
               	'apelido' => $classe .  '/' . $metodo,
				'privado' => 1
            );

			$this->CI->db->insert('sys_metodos', $data); 
			redirect(base_url(). $classe . '/' . $metodo, 'refresh');
		}
		//Se ja existir tras as informacoes de publico ou privado
		else{
			
			if($result[0]->privado==0){
				// Escapa da validacao e mostra o metodo.
				return false;
			}
			else{
				// Se for privado, verifica o login
				$nome = $this->ci->session->userdata('nome');
		    	$logged_in = $this->ci->session->userdata('logged_in');
		    	$data = $this->ci->session->userdata('data');
		    	$email = $this->ci->session->userdata('email');
				$id_usuario =  $this->ci->session->userdata('id_usuario');
		        
				$id_sys_metodos = $result[0]->id;
				
				// Se o usuario estiver logado vai verificar se tem permissao na tabela.
				if($nome && $logged_in && $id_usuario){
		            
					$array = array('id_metodo' => $id_sys_metodos, 'id_usuario' => $id_usuario);
					$this->CI->db->where($array);
					$query2 = $this->CI->db->get('sys_permissoes');		
					$result2 = $query2->result();

					// Se não vier nenhum resultado da consulta, manda para página de 
					// usuario sem permissão.
					if(count($result2)==0){
						redirect(base_url().'home/sempermissao', 'refresh');	
					}
					else{
						return true;
					}
										
		        } 
		        // Se não estiver logado, sera redirecionado para o login.
		        else{
		            redirect(base_url().'home/login', 'refresh');
		        }
			}
		}	
    }
    
    /**
    * Método auxiliar para autenticar entradas em menu.
    * Não faz parte do plugin como um todo.
    */
    function check_menu($classe,$metodo){
    	$this->CI =& get_instance();
		$sql = "SELECT SQL_CACHE
				count(sys_permissoes.id) as found
				FROM
				sys_permissoes
				INNER JOIN sys_metodos
				ON sys_metodos.id = sys_permissoes.id_metodo
				WHERE id_usuario = '" . $this->ci->session->userdata('id_usuario') . "'
				AND classe = '" . $classe . "'
				AND metodo = '" . $metodo . "'";
		$query = $this->CI->db->query($sql);		
		$result = $query->result();
		return $result[0]->found;
    }
}