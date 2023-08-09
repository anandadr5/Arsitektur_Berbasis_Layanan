<?php

class Hospital_model extends CI_Model
{
    public function getHospital($id = null)
    {
        if( $id === null) {
            return $this->db->get('hospital')->result_array();
        } else {
            return $this->db->get_where('hospital', ['id' => $id])->result_array();
        }
    }

    public function deleteHospital($id)
    {
        $this->db->delete('hospital', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function createHospital($data)
    {
        $this->db->insert('hospital', $data);
        return $this->db->affected_rows();
    }

    public function updateHospital($data, $id)
    {
        $this->db->update('hospital', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}