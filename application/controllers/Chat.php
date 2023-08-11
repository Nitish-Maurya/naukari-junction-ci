<?php
class Chat extends CI_Controller
{
    function __construct()
	{
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->library('google');
		
    }
    
    function send_message(){
        if(isset($_POST['user_from']) && !empty($_POST['user_from'])){
		
			$user_from = $_POST['user_from'];
			$user_to = $_POST['user_to'];
			$user_msg = strip_tags($_POST['user_msg']);
            
            if(isset($_SESSION['seeker'])){
                $user_from = 'seeker-'.$_POST['user_from'];
                $user_to = 'recruiter-'.$_POST['user_to'];
                $senderData = $this->Common_model->select_data('name,img','seeker',array('id'=>$_POST['user_from']));
            }else if(isset($_SESSION['recruiter'])){
                $user_from = 'recruiter-'.$_POST['user_from'];
                $user_to = 'seeker-'.$_POST['user_to'];
                $senderData = $this->Common_model->select_data('name,img','recruiter',array('id'=>$_POST['user_from']));
            }

			$array = array(
				'user_from' => $user_from,
				'user_to' => $user_to,
				'msg' => $user_msg,
				'deliver' => 0,
				'date' => date('Y-m-d H:i:s')
			);
			
            $ins = $this->Common_model->insert('jp_chat_message',$array);
            
            if($ins){
                $msg_id = $this->db->insert_id();
                if(!empty($senderData[0]['img'])){
                    $name = '<img src="'.base_url().$senderData[0]['img'].'" class="jp_chat_user_img">';
                }else{
                    $name = '<label>'.substr($senderData[0]['name'], 0, 1).'</label>';
                }
                $html = '<div class="jp_chat_item sender">
                            <div class="jp_chat_message">
                                <div class="jp_chat_user">'.$name.'
                                </div>
                                <div class="jp_chat_text">
                                    <p>'.$user_msg.'</p>
                                </div>
                            </div>
                        </div>';
                echo json_encode( array( 'status' => 1, 'html' => $html, 'msgid' =>$msg_id ) );
            }else{
                echo json_encode( array( 'status' => 0, 'html' => '') );
            }
		}
    }

    function getchathistory(){
        if(isset($_POST['user_to']) && isset($_POST['user_from'])){
           
            if(isset($_SESSION['seeker'])){
                $sender = 'seeker-'.$_POST['user_from'];
                $reciever = 'recruiter-'.$_POST['user_to'];
                $senderData = $this->Common_model->select_data('name,img','seeker',array('id'=>$_POST['user_from']));
                $recvrData = $this->Common_model->select_data('name,img','recruiter',array('id'=>$_POST['user_to']));
            }else if(isset($_SESSION['recruiter'])){
                $sender = 'recruiter-'.$_POST['user_from'];
                $reciever = 'seeker-'.$_POST['user_to'];
                $senderData = $this->Common_model->select_data('name,img','recruiter',array('id'=>$_POST['user_from']));
                $recvrData = $this->Common_model->select_data('name,img','seeker',array('id'=>$_POST['user_to']));
            }
            $cond = "(user_from = '$sender' AND user_to = '$reciever') OR (user_to = '$sender' AND user_from = '$reciever')";
           
            $chatdata = $this->Common_model->select_data('id,user_from,user_to,msg','jp_chat_message use index (id)',$cond,10,array('id','desc'));
            
            $html = '';
            $html .= '<div class="jp_chat_inner">
            <div class="jp_chat_header">
                <div class="jp_chat_title">'.$senderData[0]['name'].'</div>
                <div class="jp_chat_close_window">X</div>
            </div>
            <div class="jp_chat_body">
                <div class="jp_chat_body_inner">
                    <div class="jp_chat_content" onScroll="handleOnScroll()" data-limit="10">';

            if(!empty($chatdata)){
                foreach($chatdata as $chat){
                    if($chat['user_from']==$sender){
                        $senderCls = 'sender';
                        if(!empty($senderData[0]['img'])){
                            $name = '<img src="'.base_url().$senderData[0]['img'].'" class="jp_chat_user_img">';
                        }else{
                            $name = '<label>'.substr($senderData[0]['name'], 0, 1).'</label>';
                        }
                       
                    }else{
                        $senderCls = '';
                        if(!empty($recvrData[0]['img'])){
                            $name = '<img src="'.base_url().$recvrData[0]['img'].'" class="jp_chat_user_img">';
                        }else{
                            $name = '<label>'.substr($recvrData[0]['name'], 0, 1).'</label>';
                        }
                        
                    }

                    $html .= '<div class="jp_chat_item '.$senderCls.'">
                        <div class="jp_chat_message">
                            <div class="jp_chat_user">'.$name.'
                            </div>
                            <div class="jp_chat_text">
                                <p>'.$chat['msg'].'</p>
                            </div>
                        </div>
                    </div>';
                    $this->Common_model->update_data( 'jp_chat_message', array('deliver'=>1), array('user_from'=>$reciever,'user_to'=>$sender) ); 
                }    
                
            }
            $html .= '</div>
                    <div class="jp_chat_user_typing"></div>
                    </div>
                </div>
                <div class="jp_chat_footer">
                    <div class="jp_chat_reply">
                        <input type="text" data-msgid="" class="jp_chat_type_message" data-sid="'.$_SESSION['user_id'].'" data-rid="'.$_POST['user_to'].'" placeholder="Write Message"><button class="jp_chat_submit"><img src="'.base_url('assets/images/send.png').'"></button>
                    </div>
                </div>
            </div>';
            
			echo json_encode(array( 'status' => 1, 'html' => $html ));
		}
    }

    function getpreviouschat(){
        if(isset($_POST['user_to']) && isset($_POST['user_from'])){
           
            if(isset($_SESSION['seeker'])){
                $sender = 'seeker-'.$_POST['user_from'];
                $reciever = 'recruiter-'.$_POST['user_to'];
                $senderData = $this->Common_model->select_data('name,img','seeker',array('id'=>$_POST['user_from']));
                $recvrData = $this->Common_model->select_data('name,img','recruiter',array('id'=>$_POST['user_to']));
            }else if(isset($_SESSION['recruiter'])){
                $sender = 'recruiter-'.$_POST['user_from'];
                $reciever = 'seeker-'.$_POST['user_to'];
                $senderData = $this->Common_model->select_data('name,img','recruiter',array('id'=>$_POST['user_from']));
                $recvrData = $this->Common_model->select_data('name,img','seeker',array('id'=>$_POST['user_to']));
            }
            $cond = "(user_from = '$sender' AND user_to = '$reciever') OR (user_to = '$sender' AND user_from = '$reciever')";
           
            $chatdata = $this->Common_model->select_data('id,user_from,user_to,msg','jp_chat_message use index (id)',$cond,array(10,$_POST['limit']),array('id','desc'));
            
            $html = '';
           
            if(!empty($chatdata)){
                foreach($chatdata as $chat){
                    if($chat['user_from']==$sender){
                        $senderCls = 'sender';
                        if(!empty($senderData[0]['img'])){
                            $name = '<img src="'.base_url().$senderData[0]['img'].'" class="jp_chat_user_img">';
                        }else{
                            $name = '<label>'.substr($senderData[0]['name'], 0, 1).'</label>';
                        }
                       
                    }else{
                        $senderCls = '';
                        if(!empty($recvrData[0]['img'])){
                            $name = '<img src="'.base_url().$recvrData[0]['img'].'" class="jp_chat_user_img">';
                        }else{
                            $name = '<label>'.substr($recvrData[0]['name'], 0, 1).'</label>';
                        }
                        
                    }

                    $html .= '<div class="jp_chat_item '.$senderCls.'">
                        <div class="jp_chat_message">
                            <div class="jp_chat_user">'.$name.'
                            </div>
                            <div class="jp_chat_text">
                                <p>'.$chat['msg'].'</p>
                            </div>
                        </div>
                    </div>';
                    $this->Common_model->update_data( 'jp_chat_message', array('deliver'=>1), array('user_from'=>$reciever,'user_to'=>$sender) ); 
                }    
                
            }
            
			echo json_encode(array( 'status' => 1, 'html' => $html ));
		}
    }

    public function show_messages(){
		if(isset($_POST['sid']) && !empty($_POST['sid'])){			
			$msg_id = $_POST['msg_id'];
			$sid = $_POST['sid'];
            $rid = $_POST['rid'];
            $html = '';	
            $cond = array('deliver' => 0);
			if(isset($_SESSION['seeker'])){
                $userData = $this->Common_model->select_data('name,img','recruiter',array('id'=>$rid));
                $cond['user_from'] = 'recruiter-'.$rid;
            }else if(isset($_SESSION['recruiter'])){
                $userData = $this->Common_model->select_data('name,img','seeker',array('id'=>$rid));
                $cond['user_from'] = 'seeker-'.$rid;
            }	
            
            if(!empty($msg_id)){
               $cond['id >'] = $msg_id;
            }
          
            $chatdata = $this->Common_model->select_data('*','jp_chat_message use index (id)',$cond);

            if(!empty($chatdata)){
    
                if(!empty($userData[0]['img'])){
                    $name = '<img src="'.base_url().$userData[0]['img'].'" class="jp_chat_user_img">';
                }else{
                    $name = '<label>'.substr($userData[0]['name'], 0, 1).'</label>';
                }
                
                for($i=0;$i<count($chatdata);$i++){
                    $html .= '<div class="jp_chat_item">
                        <div class="jp_chat_message">
                            <div class="jp_chat_user">'.$name.'
                            </div>
                            <div class="jp_chat_text">
                                <p>'.$chatdata[$i]['msg'].'</p>
                            </div>
                        </div>
                    </div>';	
                    $this->Common_model->updateData( 'jp_chat_message', array('deliver'=>1), $chatdata[$i]['id'], 'id' ); 
                }
                
            }
			echo json_encode( array( 'status' => 1, 'html' => $html) );
		}
    }
    
    function message_count($uid=''){
        if(isset($_POST['type'])){
            if(isset($_SESSION['seeker'])){
                $cond = array('user_to' => 'seeker-'.$_SESSION['user_id'], 'deliver' => 0);
                if($_POST['type'] == 'inpage'){
                    $cond['user_from'] = 'recruiter-'.$uid;
                }
            }else if(isset($_SESSION['recruiter'])){
                $cond = array('user_to' => 'recruiter-'.$_SESSION['user_id'], 'deliver' => 0);
                if($_POST['type'] == 'inpage'){
                    $cond['user_from'] = 'seeker-'.$uid;
                }
            }	

            $chatCount = $this->Common_model->aggregate_data('jp_chat_message use index (id)','id','count',$cond);

            if($chatCount!=0)
                echo json_encode( array( 'status' => 1, 'count' => $chatCount) );
            else
                echo json_encode( array( 'status' => 0, 'count' => '') );
        }
        
    }  

}

?>