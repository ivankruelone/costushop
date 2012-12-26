<?php

class Miembros_model extends CI_Model
{

    function validate()
    {
        $this->db->where('tipo', 1);
        $this->db->where('username', $this->input->post('username'));
        $this->db->where('password', $this->input->post('password'));
        return $this->db->get('usuarios');

    }

    function datos_usuario($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('usuarios');
    }

    function update_usuario()
    {
        $update = array(
            'username' => $this->input->post('username'),
            'nombre' => $this->input->post('nombre'),
            'puesto' => $this->input->post('puesto'),
            'email' => $this->input->post('email'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('usuarios', $update);
        $this->session->set_userdata($update);
    }

    function update_avatar($avatar)
    {
        $update = array('avatar' => $avatar);
        $this->db->where('id', $this->session->userdata('id'));
        $this->db->update('usuarios', $update);
        $this->session->set_userdata($update);
        return "<img src=\"" . base_url() . "img/avatar/" . $this->session->userdata('avatar') .
            "\" alt=\"" . $this->session->userdata('nombre') . "\">";
    }

}
