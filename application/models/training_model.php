<?php

class Training_model extends CI_Model{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function getTrainingData($id = 0){
        $this->db->select('*');
        $this->db->from('training');
        if($id!=0){
            $this->db->where('id',$id);
        }
        $query = $this->db->get();
        return $query;
    }
    function getTrainingAllImages($id){
        $this->db->select('*');
        $this->db->from("training_images");
        $this->db->where('training_id',$id);
        $query = $this->db->get();
        return $query;
    }
    function getTrainingFullData($id){
        $this->db->select('t.id AS id, 
            t.link AS link, 
            t.title AS title, 
            tv.training_video AS video, 
            tt.training_text AS t_text');
        $this->db->from('training AS t');
        $this->db->join('training_video AS tv','t.id=tv.training_id','LEFT');
        $this->db->join('training_text AS tt','t.id=tt.training_id','LEFT');
        $this->db->where('t.id',$id);
        $query = $this->db->get();
        return $query;
    }
    function addTraining(){
        $data=array(
            'link'=>$this->input->post('link'),
            'title'=>$this->input->post('title'),
            'training_category'=>$this->input->post('category')
        );
        $this->db->insert('training',$data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
    function addVideo($id){
        $config['upload_path'] = './uploads/training/video/';
        $config['allowed_types'] = 'avi|flv|wmv|mp4|mp3';
        $config['max_size'] = '10000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $this->load->library('upload', $config);
        $source = $this->input->post('source');
        if($source==="youtube"){
            $video=$this->input->post('video_youtube');
        }
        elseif($source==="upload"){
            if($this->upload->do_upload('video')){
                $info=$this->upload->data();
                $video=$info['file_name'];
            }
            else{
                return false;
            }
        }
        else{
            return FALSE;
        }
        $data = array('training_video'=>$video,'training_id'=>$id);
        $this->db->insert('training_video',$data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
    function addText($id){
        $data = array(
            'training_id'=>$id,
            'training_text'=>  $this->input->post('training_text')
        );
        $this->db->insert('training_text',$data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
    function editText($id){
        $data = array(
            'training_text'=> $this->input->post('training_text')
        );
        $this->db->where('training_id',$id);
        $this->db->update('training_text',$data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
    function editVideo($id){
        $config['upload_path'] = './uploads/training/video/';
        $config['allowed_types'] = 'avi|flv|wmv|mp4|mp3';
        $config['max_size'] = '10000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $this->load->library('upload', $config);
        $source = $this->input->post('source');
        if($source==="youtube"){
            $video=$this->input->post('video_youtube');
        }
        elseif($source==="upload"){
            if($this->upload->do_upload('video')){
                $info=$this->upload->data();
                $video=$info['file_name'];
            }
            else{
                return false;
            }
        }
        else{
            return FALSE;
        }
        $data = array('training_video'=>$video);
        $this->db->where('training_id',$id);
        $this->db->update('training_video',$data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
    function addImages($id) {
        //echo 'function started.';
        $config['upload_path'] = './uploads/training/images/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '10000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $this->load->library('upload', $config);
        $errors = false;
        $files = $_FILES;
        $cpt = count($_FILES['images']['name']);
        $this->db->trans_start();
        for ($i = 0; $i < $cpt; $i++) {

            $_FILES['images']['name'] = $files['images']['name'][$i];
            $_FILES['images']['type'] = $files['images']['type'][$i];
            $_FILES['images']['tmp_name'] = $files['images']['tmp_name'][$i];
            $_FILES['images']['error'] = $files['images']['error'][$i];
            $_FILES['images']['size'] = $files['images']['size'][$i];
            $this->upload->initialize($config);
            if(move_uploaded_file($_FILES["images"]["tmp_name"], $config['upload_path'].$_FILES['images']['name'])){
                $data = array(
                    'training_id' => $id,
                    'training_image' => $_FILES['images']['name']
                );
                $this->db->insert('training_images', $data);
            }
            else{
                $errors = TRUE;
            }
        }
        $this->db->trans_complete();
        return !$errors;
    }
    function getCategories($id=0){
        $this->db->select('*');
        $this->db->from('training_category');
        if($id!==0){
            $this->db->where('id',$id);
        }
        $query = $this->db->get();
        return $query;
    }
    function addCategory(){
        $data=array(
            'category_name'=>$this->input->post('category_name')
        );
        $this->db->insert('training_category',$data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
    function editCategory($id){
        $data=array(
            'category_name'=>$this->input->post('category_name')
        );
        $this->db->where('id',$id);
        $this->db->update('training_category',$data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
    function deleteCategory($id){
        $this->db->where('id',$id);
        $this->db->delete('training_category');
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
    function deleteTraining($id){
        $this->db->where('id',$id);
        $this->db->delete('training');
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
}