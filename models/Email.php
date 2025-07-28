<?php
    require('class.phpmailer.php');
    include("class.smtp.php");

    require_once("../config/conexion.php");
    require_once("../Models/Ticket.php");

    class Email extends PHPMailer{
        protected $gCorreo = 'lauravelez1911@gmail.com';
        protected $gContraseña = "";

        public function ticket_abierto($tick_id){
            $ticket = new Ticket();
            $datos = $ticket->listar_ticket_x_id($tick_id);
            foreach ($datos as $row) {
                $id = $row["tick_id"];
                $usu = $row["usu_nom"];
                $titulo = $row["tick_titulo"];
                $categoria = $row["cat_nom"];
                $correo = $row["usu_correo"];
            }

            $this->IsSMTP();
            $this->Host = 'smtp.gmail.com';
            $this->Port = 587;
            $this->SMTPAuth = true;
            $this->Username = $this->gCorreo;
            $this->Password = $this->gContraseña;
            $this->From = $this->gCorreo;
            $this->SMTPSecure = 'tls';
            $this->FromName = "Ticket Abierto";
            $this->CharSet = 'UTF8';
            $this->addAddress($correo);
            $this->WordWrap = 50;
            $this->IsHTML(true);
            $this->Subject = "Ticket Abierto";

            $cuerpo = file_get_contents('../public/NuevoTicket.html');
            $cuerpo = str_replace("xnroticket", $id, $cuerpo);
            $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
            $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
            $cuerpo = str_replace("lblCate", $categoria, $cuerpo);

            $this->Body = $cuerpo;
            $this->AltBody = strip_tags("Ticket Abierto");
            return $this->Send();
        }

        public function ticket_cerrado($tick_id){
        }
        public function ticket_asignado($tick_id){
        }
    }

?>
