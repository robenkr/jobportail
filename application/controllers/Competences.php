<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Competences extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
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
        $config['total_rows'] = $this->Competences_model->total_rows($q);
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
            'fk_idDemandeur' => $this->input->post('fk_idDemandeur',TRUE),
            );
            try{
                $this->competences_model->insert($data);
                $this->session->set_flashdata('message', '<p style="color:green;">Create Record Success</p?>');
                redirect(site_url('competences/create'));
            }catch(Exception $e){
                $this->session->set_flashdata('message', '<p style="color:red;">Create Record Failed >>'.$e.'</p>');
                redirect(site_url('competences/create'));
            }
        }
    }

    public function _rules() 
    {
        $this->form_validation->set_rules('nomCompetence', 'Nom de competence', 'trim|required');
        $this->form_validation->set_rules('fk_idDemandeur', 'fk_iddemandeur', 'trim|required');

        $this->form_validation->set_error_delimiters('<span class="text-danger" style="color:red;">', '</span>');
    }
}