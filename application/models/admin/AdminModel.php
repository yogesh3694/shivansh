<?php 
class AdminModel extends CI_Model{

        public function __construct()
        {
            $this->load->database();
        }
        public function get_user()
        { 
            $this->db->select("u.*,u.user_ID as uid,u.email as useremail,CONCAT((SELECT `name` FROM `trader_countries` WHERE `country_ID`=`u`.`country`),', ',(SELECT `name` FROM `trader_cities` WHERE `city_ID`=`u`.`city`)) AS location");
            //$this->db->join('ph_user as pu', 'u._ID = pu._UserID','left');
            $this->db->where('u.role_type !=', "0");
            $this->db->where('u.isDelete !=', "1");
            $query = $this->db->get('trader_user as u');
            return $query->result();
        }
        public function get_country()
        { 
            $this->db->select("con.country_ID,state.state_ID");
            $this->db->join('trader_states as state', 'con.country_ID = state.country_ID','left');
            $this->db->join('trader_cities as city', 'state.state_ID = city.state_ID','left');
            $query = $this->db->get('trader_countries as con');
            //echo $this->db->last_query();
            return $query->result();
        }
        public function getcount($tbname,$cond){
            foreach($cond as $key=>$value){
                $this->db->where($key,$value);
            }
            $q = $this->db->get($tbname); 
            return $q->num_rows();
        }
        public function getdata($tbname)
        {
            $query = $this->db->get($tbname);
            return $query->result();
        }
        public function runselect($query){
            $result = $this->db->query($query);
            return $result->result();
        }
        public function runselectrow($query){
            $result = $this->db->query($query);        
            return $result->row();
        }
        public function get_singlerecord($table,$cond)
        {
            $query = $this->db->get_where($table,$cond);
            //echo $this->db->last_query();
            return $query->row();
        }
        public function fetchrow($tbname,$cond){
            foreach($cond as $key=>$value){
                $this->db->where($key,$value);
            }
            $q = $this->db->get($tbname); 
            return $q->row();
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
        public function fetchrows($tbname,$field,$value){
            $this->db->where($field,$value);
            $query = $this->db->get($tbname);
            return $query->result();
        }
        public function insertdata($tbname,$data)
        {
            $result = $this->db->insert($tbname,$data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
         public function getorderby($tbname,$orderby)
        {
            $this->db->order_by($orderby);
            $query = $this->db->get($tbname);
            return $query->result();
        }
        public function edit($tbname,$field,$value)
        {
            $this->db->where($field, $value);
            $query = $this->db->get($tbname);
            return $query->row();
        }
        public function updatedata($tbname,$field,$value,$data)
        {
            $this->db->where($field, $value);
            $query = $this->db->update($tbname, $data);
            return $query;
        }
        public function updaterecord($tbname,$cond,$data)
        {
            foreach($cond as $key=>$value){
                $this->db->where($key,$value);
            }
            $query = $this->db->update($tbname,$data);
           
            return $query;
        }

        public function deletedata($tbname,$field,$value){
            $this->db->where($field, $value);
            $del = $this->db->delete($tbname);
            return $del;
        }

        public function insertbatchdata($tbname,$data){
            $insert = $this->db->insert_batch($tbname,$data);
            return $insert?true:false;
        }
        public function runquery($sql){
            $result = $this->db->query($sql);

            return $result->result();
        }
        public function getrecorddesc($tbname,$cond){
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