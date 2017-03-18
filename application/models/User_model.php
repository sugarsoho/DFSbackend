<?php
use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;

class User_model extends CI_Model {


  /**
   * [get_info description]
   * @param  [array] $map   [查询字段]
   * @param  [string] $field [返回字段]
   * @return [array]        []
   */
  public function getData($map='',$field=''){
    if ($field=='') {
      //当返回字段为空，查询字段不为空时
      if ($map!='') {
        $data=$this -> db
              -> where($map)
              -> get('user');
      }
      //当当返回字段为空，查询字段为空时
      else{
        $data=$this -> db
              -> get('user');
      }
    }else{
      //当返回字段不为空，查询字段不为空时
      if ($map!='') {
        $data=$this -> db
              -> select($field)
              -> where($map)
              -> get('user');
      }
      //当返回字段不为空，查询字段为空时
      else{
        $data=$this -> db
              -> select($field)
              -> get('user');
      }
    }
    return $data->result_array();
  }


    //获取当前微信用户的uid
    public function getuid()
    {
        //获取用户openid
        $ui = LoginService::check();
        if($ui['code']==-1){
            return $ui['code'];
        }
        $uinfo = $ui['data']['userInfo'];
        //根据openid查询是否已经在用户表注册
        $query = $this->db->get_where('user',array('openId'=>$uinfo['openId']));
        $row = '';
        if($query){
             log_message('error', 'id ok');
            $row = $query->result();
        }else{
             log_message('error', 'id err');
             return -1;
        }
        //如果不存在则插入并返回新id
        if(sizeof($row)==0){
            log_message('error', 'new user insert' . "\n");
            $row = $this->db->insert('user',array('nickname'=>$uinfo['nickName'],
            'gender'=>$uinfo['gender'],
            'language'=>$uinfo['language'],
            'city'=>$uinfo['city'],
            'province'=>$uinfo['province'],
            'country'=>$uinfo['country'],
            'avatarUrl'=>$uinfo['avatarUrl'],
            'openId'=>$uinfo['openId']));
            return $this->db->insert_id();
        }

        return $row[0]->uid;
    }

    public function add_user($ui){
        $uinfo = $ui['data']['userInfo'];
        //根据openid查询是否已经在用户表注册
        $query = $this->db->get_where('user',array('openId'=>$uinfo['openId']));
        $row = '';
        if($query){
             log_message('error', 'id ok');
            $row = $query->result();
        }else{
             log_message('error', 'id err');
             return -1;
        }
        //如果不存在则插入并返回新id
        if(sizeof($row)==0){
            log_message('error', 'new user insert' . "\n");
            $row = $this->db->insert('user',array('nickname'=>$uinfo['nickName'],
            'gender'=>$uinfo['gender'],
            'language'=>$uinfo['language'],
            'city'=>$uinfo['city'],
            'province'=>$uinfo['province'],
            'country'=>$uinfo['country'],
            'avatarUrl'=>$uinfo['avatarUrl'],
            'openId'=>$uinfo['openId']));
            return $this->db->insert_id();
        }

        return $row[0]->uid;
    }

    public function insert($ggz){
        return $this->db->insert('user',$ggz);
    }

    public function get($uid){
        $this->db->from("user");
        $this->db->where("uid",$uid);
        return $this->db->get()->row_array();
        //$q = $this->db->get_where('guanggao',array('uid'=>$uid));
        //return $q->result_array();
    }
}
