<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Competences extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //Session verification
		if(!$this->session->user){
			$this->session->set_flashdata('message', '<p style="color:red;"><i class="material-icons">cancel</i> Veuillez vous connecter</p>');
			redirect('login');
		}
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'competences/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'competences/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'competences/index.html';
            $config['first_url'] = base_url() . 'competences/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->competences_model->total_rows($q);
        $competences = $this->competences_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'competences_data' => $competences,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $data['title']= "Liste des competences";
        $this->load->view('list_competences', $data);
    }

    public function create(){
        $data['title'] = "Ajout Competences";
        $this->load->view('ajout_competences', $data);
    }

    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
            'nomCompetence' => $this->input->post('nomCompetence',TRUE),
            'fk_idDemandeur' => $this->session->user->idDemandeur
            );
            try{
                $this->competences_model->insert($data);
                $this->session->set_flashdata('message', '<p style="color:green;">Create Record Success</p?>');
                redirect('uprofile');
            }catch(Exception $e){
                $this->session->set_flashdata('message', '<p style="color:red;">Create Record Failed >>'.$e.'</p>');
                redirect('uprofile');
            }
        }
    }

    public function update($id) 
    {
        $row = $this->competences_model->get_by_id($id);

        if ($row) {
            $data['competence'] = array(
                'idCompetences' => set_value('idCompetences', $row->idCompetences),
                'nomCompetence' => set_value('nomCompetence', $row->nomCompetence),
                'fk_idDemandeur' => set_value('fk_idDemandeur', $row->fk_idDemandeur),
            );
            $data['title'] ='modifier competence';
            $this->load->view('_inc/header',$data);
            $this->load->view('modif_competence');
            $this->load->view('_inc/footer');
        } else {
            $this->session->set_flashdata('message', '<p style="color:orange;"><i class="material-icons">cancel</i> Record Not Found</p>');
            redirect('uprofile');
        }
    }

    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('idCompetences', TRUE));
        } else {
            $data = array(
                'nomCompetence' => $this->input->post('nomCompetence',TRUE),
                'fk_idDemandeur' => $this->session->user->idDemandeur,
            );

            $this->competences_model->update($this->input->post('idCompetences', TRUE), $data);
            $this->session->set_flashdata('message', '<p style="color:green;">Update Record Success</p?>');
            redirect('uprofile');
        }
    }

    public function _rules() 
    {
        $this->form_validation->set_rules('nomCompetence', 'Nom de competence', 'trim|required');

        $this->form_validation->set_error_delimiters('<span class="white-text center red" style="color:red;">', '</span>');
    }
}