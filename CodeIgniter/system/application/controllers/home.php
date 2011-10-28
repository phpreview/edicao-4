<?php
class Home extends Controller {
function __construct(){
parent::Controller();
$this->load->helper('logs');
$this->load->helper('cookie');
}
function index(){
redirect(base_url().'home/login', 'refresh');
}
function void(){
$data['js_to_load'] = null;
$this->load->view('libs/html-header',$data);
$this->load->view('libs/menu');
$this->load->view('libs/html-footer');
}
function sempermissao(){
echo "<html>”;
echo “<title>Acesso Negado</title>”;
echo “<body bgcolor='#EEEEEE'>”;
echo “ <div style='padding:20px;background-color:#FFCC00;'>”;
echo “<h2>Você não tem permissão para acessar esta funcionalidade.</h2>
echo “</div>”;
echo “</body>”;
echo “</html>";
exit();
}
function login(){
$this->load->view('login',$data);
}
function dologin(){
$usuario = $this->input->post('usuario');
$cnpj = $this->input->post('cnpj');
$senha = md5($this->input->post('senha'));
if($usuario=="" || $cnpj=="" || $this->input->post('senha')==""){
redirect(base_url().'home/login', 'refresh');
exit();
}
if(isset($_POST['lembrar'])){
setcookie("usuario", $usuario);
setcookie("cnpj", $cnpj);
setcookie("lembrar", "checked");
}
$sql = "SELECT id,cnpj,login,nome,email
FROM tb_usuarios
WHERE login ='" . $usuario . "'
AND cnpj ='" . $cnpj . "’
AND senha ='" . $senha . "'";
$query = $this->db->query($sql);
$result = $query->result();
if(count($result)<1){
redirect(base_url().'home/login', 'refresh');
exit();
}
else{
$login = array(
'id_usuario' => $result[0]->id,
'cnpj' => $result[0]->cnpj,
'usuario' => $result[0]->login,
'nome' => $result[0]->nome,
'email' => $result[0]->email,
'logged_in' => TRUE,
'data' => date("d/m/Y h:i:s")
);
$data['ip'] = getenv("REMOTE_ADDR");
$data['usuario'] = $result[0]->id;
$this->db->insert('tb_acessos',$data);
$this->session->set_userdata($login);
redirect(base_url().'home/void', 'refresh');
}
}
function logout()
{
$this->session->sess_destroy();
$this->login();
}
}