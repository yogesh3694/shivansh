<?php 
class MainModel extends CI_Model{

    public function __construct(){
        $this->load->database();
    }
    /*public function login($data){ 
        $this->db->from('trader_user');
        $this->db->where("email",$data['email']);
        $this->db->where('password', $data['password']);
        $query = $this->db->get();
        echo $query; exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }*/
    public function getalldata($tbl){
            $query = $this->db->get($tbl);
            return $query->result();
    }
    public function validate_user($data){
            $email = $data['user_email'];
            $pwd = md5($data['password']);
            $this->db->where("email",$email);
            $this->db->where("password",$pwd);
            $this->db->where("isActive","1");
            $this->db->where("isDelete","0");
            //$this->db->where("isVerify","1");
            $query = $this->db->get("trader_user");
            //echo $this->db->last_query();exit;
            return $query->row();
    }
    public function verify_validate_user($data){
            $email = $data['user_email'];
            $pwd = $data['password'];
            $this->db->where("email",$email);
            $this->db->where("password",$pwd);
            $this->db->where("isActive","1");
            $this->db->where("isDelete","0");
            $query = $this->db->get("trader_user");
            return $query->row();
    }
    public function forgotpassword($data,$email){      
           $this->db->where("email",$email);
           $query = $this->db->update("trader_user",$data);
           return $query;
    }
    public function getcount($tbname,$cond){
        foreach($cond as $key=>$value){
            $this->db->where($key,$value);
        }
        $q = $this->db->get($tbname); 
        return $q->num_rows();
    }
    public function customjoinrow($table1,$table2,$common1,$common2,$cond)
    {
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join("$table2", "$table1.$common1 = $table2.$common2",'inner');
        if(!empty($cond)){
            foreach ($cond as $key => $value) {
                $query = $this->db->where($key,$value);
            }
        }
        $query=$this->db->get();
        //echo $this->db->last_query();exit;
        return $query->row();
    }
    public function joinwithorderby($table1,$table2,$common1,$common2,$where,$ordby1,$ordby2,$start,$length)
    {
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join("$table2", "$table1.$common1 = $table2.$common2",'left');

        foreach($where as $key=>$value){
            $query =$this->db->where($key,$value);
        }
        if($ordby != ''){
            $query=$this->db->order_by($table1.'.'.$ordby1,$ordby2);
        }
        if($start !='' && $length != ''){
            $query=$this->db->limit($start,$length);    
        }
        $query=$this->db->get();
        //echo $this->db->last_query();exit;
        return $query->result();
    }
    public function get_singlerecord($table,$cond)
    {
        $query = $this->db->get_where($table,$cond);
        return $query->row();
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
// echo $this->db->last_query();
        return $q->result();
    }
    public function runselect($query){
        $result = $this->db->query($query);
        //echo $this->db->last_query();
       //die;
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

    //---for get max amount 
    public function fetchmaxamount($tbname){
        $this->db->select_max('base_price');
        $query = $this->db->get($tbname);
        return $query->result();
    }
 public function getamountrange($maxprice,$diffval){
  $arrayodd=array();
             $arrayeven=array();
            $i=0;
            foreach (range(0, $maxprice, $diffval) as $arrval) {
              if($i%2==0){
                 array_push($arrayodd, $arrval);
             }else{
                  array_push($arrayeven, $arrval);
             }
             $i++;         
               
            }
            $arramountnew = array();
            for ($b=0; $b < (count($arrayodd)-1); $b++) { 
                        if($b>0){
                  
                array_push($arramountnew, str_pad( ($arrayodd[$b]+1),4,"0",STR_PAD_LEFT).'-'.str_pad($arrayeven[$b],4,"0",STR_PAD_LEFT));

                }else{
                array_push($arramountnew, str_pad(($arrayodd[$b]+1),4,"0",STR_PAD_LEFT).'-'.str_pad(($arrayeven[$b]),4,"0",STR_PAD_LEFT));

                }
                array_push($arramountnew,str_pad( ($arrayeven[$b]+1),4,"0",STR_PAD_LEFT).'-'.str_pad(($arrayodd[$b+1]),4,"0",STR_PAD_LEFT));
 

               
            }
            return $arramountnew;
   }  
    public function fetchrows($tbname,$field,$value){
        $this->db->where($field,$value);
        $query = $this->db->get($tbname);
        return $query->result();
    }
    public function emailexists($emailid){
        $this->db->where("email",$emailid);
        $this->db->where("isDelete",'0');
        $result = $this->db->get("trader_user");
        return $result->num_rows();
    }
    public function editemailexists($emailid){
        $this->db->where("email",$emailid);
        $this->db->where("isDelete",'0');
        $result = $this->db->get("trader_user");
        return $result->num_rows();
    }
    public function insertdata($tbname,$data)
    { 
        $result = $this->db->insert($tbname,$data);
        // /echo $this->db->last_query();exit;
       return $this->db->insert_id();
    }
    public function insertrow($tbname,$data){
        $insert = $this->db->insert($tbname,$data);
        //echo $this->db->last_query();exit;
        return $insert?true:false;
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
    public function updaterecords($tbname,$cond,$data){
        foreach ($cond as $key => $value) {
            $this->db->where($key,$value);
        }
        $upd = $this->db->update($tbname,$data);
        return $upd;
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
         //echo $this->db->last_query();
        return $q->result();
        }
    
    public function getdescdata($tbname,$cond,$con,$limit){
        foreach($cond as $key=>$value){
            $this->db->where($key,$value);
        }
        foreach($con as $key=>$value){
            $this->db->order_by($key,$value);
           // echo $value."<br>";
        }
        foreach($limit as $key=>$value){

            //echo $value."<br>";
            $this->db->limit($key,$value);
        }
        
        $q = $this->db->get($tbname); 
    //    echo $this->db->last_query();
    // exit;
        return $q->result();
        }    
    public function getdescdatalimit($tbname,$con,$limit){

    foreach($con as $key=>$value){
    $this->db->order_by($key,$value);
    }
    foreach($limit as $key=>$value){
    $this->db->limit($key,$value);
    }

    $q = $this->db->get($tbname); 
    //    echo $this->db->last_query();
    // exit;
    return $q->result();
    }    


    public function ratingjoinrecord(){
        $this->db->join("product_master","product_master._ID = rateproduct._ProductID");
        $this->db->join("subscriber","subscriber._ID=rateproduct._UserID");
        $this->db->order_by("rateproduct._ID","desc");
        return $this->db->get("rateproduct")->result();
    }

    public function batchInsert($data){
        $current_time = date("Y-m-d h:i:sa");
        $product_id = $data['product_id'];

        $this->db->where("_ProductID",$product_id);
        $delete = $this->db->delete("productdetails");
        if($delete){
            $count = count($data['title']);
            for($i = 0; $i<$count; $i++){
                $entries[] = array(
                    '_Title'=>$data['title'][$i],
                    '_Description'=>$data['description'][$i],
                    '_ProductID'=>$data['product_id'],
                    '_Created'=>$current_time,
                    '_Updated'=>$current_time
                );
            }
            $this->db->insert_batch('productdetails', $entries); 
            if($this->db->affected_rows() > 0)
            return 1;
            else
            return 0;
        }else{
            return 0;
        }
    }
    public function search_disc(){
        $this->db->select("td.*,");
        $this->db->from('trader_discussion as td');
        $this->db->join('trader_category as tc', 'td.category = tc.category_ID','left');
        $this->db->where('u._Usertype !=', "2");
        if($this->input->post('usertype') != ""){
            if($this->input->post('usertype') == "0"){
                $this->db->where('u._Usertype', "0");
            }elseif ($this->input->post('usertype') == "1") {
                $this->db->where('pu._Type', "0");
            }elseif ($this->input->post('usertype') == "2") {
                $this->db->where('pu._Type', "1");
            }
        }
        if($this->input->post('location') != ""){
            $this->db->having('pu._Location LIKE "%'.$this->input->post('location').'%"');
            $this->db->or_having('location LIKE "%'.$this->input->post('location').'%"');
        }
        if($this->input->post('lastloggedin') != ""){
            $this->db->having('DATE(_Loggedin)', date('Y-m-d',strtotime($this->input->post('lastloggedin'))));
        }
        if($this->input->post('txtrating') != ""){
            $this->db->having('review', $this->input->post('txtrating'));
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
    public function get_notification($id,$limit=''){
        $this->db->select("trader_notifications.*,trader_user.virtual_name,trader_user.profile_photo,trader_discussion.discussion_title");
        $this->db->from('trader_notifications');
        $this->db->join('trader_discussion','trader_discussion.discussion_ID = trader_notifications.post_discu_ID', 'left');
        $this->db->join('trader_user', 'trader_user.user_ID = trader_notifications.fromuser_ID', 'left');
        $this->db->where('trader_notifications.touser_ID', $id);
        //$this->db->where('notifications.status', 0);
        $this->db->order_by('trader_notifications.createdDate', "DESC");
        if($limit != ''){
            $this->db->limit($limit);
        }
        $result = $this->db->get();
        return $result->result();
    }
    public function get_notificationcount($id,$limit=''){
        $this->db->select("trader_notifications.*,trader_user.virtual_name,trader_user.profile_photo,trader_discussion.discussion_title");
        $this->db->from('trader_notifications');
        $this->db->join('trader_discussion','trader_discussion.discussion_ID = trader_notifications.post_discu_ID', 'left');
        $this->db->join('trader_user', 'trader_user.user_ID = trader_notifications.fromuser_ID', 'left');
        $this->db->where('trader_notifications.touser_ID', $id);
        $this->db->where('trader_notifications.status', '0');
        $this->db->order_by('trader_notifications.createdDate', "DESC");
        if($limit != ''){
            $this->db->limit($limit);
        }
        $result = $this->db->get();
        return $result->num_rows();
    }

}
?>