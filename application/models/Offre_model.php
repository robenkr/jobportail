<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Offre_model extends CI_Model
{

    public $table = 'offre';
    public $id = 'idOffre';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('idOffre', $q);
	$this->db->or_like('posteOffre', $q);
	$this->db->or_like('dateDebutOffre', $q);
	$this->db->or_like('dateFinOffre', $q);
    $this->db->or_like('fk_idEmployeur', $q);
    
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    // get total rows by id_employeur
    function total_rows_id($q = NULL,$idEmp) {
        
	    $this->db->like('posteOffre', $q);
    
        $this->db->from($this->table);
        $this->db->where('fk_idEmployeur', $idEmp);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('idOffre', $q);
        $this->db->or_like('posteOffre', $q);
        $this->db->or_like('dateDebutOffre', $q);
        $this->db->or_like('dateFinOffre', $q);
        $this->db->or_like('dateFinOffre', $q);
        $this->db->or_like('employeur.nomEmployeur', $q);
        $this->db->join('employeur', 'offre.fk_idEmployeur = employeur.idEmployeur');
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // get data with limit and search by id
    function get_limit_data_id($limit, $start = 0, $q = NULL,$idEmp) {
        $this->db->where('fk_idEmployeur', $idEmp);
        $this->db->order_by($this->id, $this->order);
        $this->db->like('posteOffre', $q);

        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}