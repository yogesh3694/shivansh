<?php 
class MainModel extends CI_Model{

    public function __construct(){
        $this->load->database();
    }
    public function login($data){
        $this->db->from('trader_user');
        $this->db->where("email",$data['email']);
        $this->db->where('password', $data['password']);
        $this->db->where('role_type', 0);
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    public function forgotpassword($data,$email){      
           $this->db->where("_Email",$email);
           $query = $this->db->update("usermaster",$data);
           return $query;
    }
    public function getcount($tbname,$cond){
        foreach($cond as $key=>$value){
            $this->db->where($key,$value);
        }
        $q = $this->db->get($tbname); 
        return $q->num_rows();
    }
    public function fetchrow($tbname,$cond){
        foreach($cond as $key=>$value){
            $this->db->where($key,$value);
        }
        $q = $this->db->get($tbname); 
        return $q->row();
    }
    public function fetchallrow($tbname,$cond){
        foreach($cond as $key=>$value){
            $this->db->where($key,$value);
        }
        $q = $this->db->get($tbname); 
        return $q->result();
    }
    public function runselect($query){
        $result = $this->db->query($query);
        return $result->result();
    }
    public function runselectrow($query){
        $result = $this->db->query($query);        
        return $result->row();
    }
    public function fetchrowsall($tbname){
        $query = $this->db->get($tbname);
        return $query->result();
    }
    public function fetchrows($tbname,$field,$value){
        $this->db->where($field,$value);
        $query = $this->db->get($tbname);
        return $query->result();
    }
    public function insertbatchdata($tbname,$data){
        $insert = $this->db->insert_batch($tbname,$data);
        //echo $this->db->last_query();exit;
        return $insert?true:false;
    }
    public function updaterecord($tbname,$field,$value,$data){
        $this->db->where($field,$value);
        $upd = $this->db->update($tbname,$data);
        return $upd;
    }
    public function get_singlerecord($table,$cond)
    {
        $query = $this->db->get_where($table,$cond);
        return $query->row();
    }
    public function deleterecord($tbname,$cond,$data){
        foreach($cond as $key=>$value){
            $this->db->where($key,$value);
        }
        $upd = $this->db->update($tbname,$data);
        return $upd;
    }
    public function removedata($tbname,$field,$value){
        $this->db->where($field,$value);
        $del = $this->db->delete($tbname);
        return $del;
    }

    public function insertrow($tbname,$data){
        $insert = $this->db->insert($tbname,$data);
        //echo $this->db->last_query();exit;
        return $insert?true:false;
    }

    public function getjoinrecord(){
            $this->db->select("productdetails._ID,productdetails._Title,product_master._Productname");
            $this->db->where("productdetails._Isactive","1");
            $this->db->join("product_master","product_master._ID=productdetails._ProductID");
        return $this->db->get("productdetails")->result();
    }

    public function updateproductrecord(){
        $current_time = date("Y-m-d h:i:sa");
        $pro_det_id = $this->input->post("product_id");
        $priority = $this->input->post("priority");
        $product_id = $this->input->post("product");
        $priority_hide = $this->input->post("priority_hide");
        $this->db->where("_ProductID",$product_id);
        $this->db->where("_Priority",$priority);
        $check_row = $this->db->get("productdetails")->row();

        if(count($check_row)==1){
            $pr = $check_row->_Priority;
            $p_id = $check_row->_ID;
            $data = array(
                "_ProductID"=>$product_id,
                "_Title"=>$this->input->post('title'), 
                "_Slug"=>url_title($this->input->post('title'), "dash", TRUE), 
                "_Description"=>$this->input->post('description'), 
                "_Priority"=>$this->input->post('priority'), 
                "_Updated" => $current_time, 
            );
            $this->db->where("_ID",$pro_det_id);
            $upd = $this->db->update("productdetails",$data);

            $data1 = array(
                "_Priority"=>$priority_hide
            );
            $this->db->where("_ID",$p_id);
            $upd1 = $this->db->update("productdetails",$data1);
            return $upd1?true:false;
        }else{
            $data = array(
                "_ProductID"=>$product_id,
                "_Title"=>$this->input->post('title'), 
                "_Slug"=>url_title($this->input->post('title'), "dash", TRUE), 
                "_Description"=>$this->input->post('description'), 
                "_Priority"=>$this->input->post('priority'), 
                "_Updated" => $current_time, 
            );
            $this->db->where("_ID",$pro_det_id);
                $upd = $this->db->update("productdetails",$data);
            return $upd?true:false;
        }
    }

    public function getrecorddesc($tablenm,$cond){
        foreach($cond as $key=>$value){
            $this->db->order_by($key,$value);
        }
        $q = $this->db->get($tbname); 
        return $q->result();

    }

    public function getdescstatus($tbname,$cond,$con){
        foreach($cond as $key=>$value){
            $this->db->where($key,$value);
        }
        foreach($con as $key=>$value){
            $this->db->order_by($key,$value);
        }
        $q = $this->db->get($tbname); 
        return $q->result();
        }
        
    public function ratingjoinrecord(){
        $this->db->join("product_master","product_master._ID = rateproduct._ProductID");
        $this->db->join("subscriber","subscriber._ID=rateproduct._UserID");
        $this->db->order_by("rateproduct._ID","desc");
        return $this->db->get("rateproduct")->result();
    }
}
?>