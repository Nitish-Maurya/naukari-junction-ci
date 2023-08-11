<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');



class CategoryModel extends CI_Model {



    public function __construct() {

        parent::__construct();

        

        // Load the database library

        $this->load->database();

        

        // $this->userTbl = 'registers';

    }


  function updateRowWhere($table, $where = array(), $data = array()) {
      $this->db->where($where);
      $this->db->set($data);
      $this->db->update($table,$data);
      $updated_status = $this->db->affected_rows();
      //echo $this->db->last_query();
    return $updated_status;
  }

    public function getAllCategory(){

        $this->db->select('*');

        $this->db->from('categories');

        $data = $this->db->get()->result();

        return $data;

    }

     public function getCatByVendorId($v_id){

        $this->db->select('products.category_id as id,categories.*');
        $this->db->from('products');
        $this->db->where('farmer_id',$v_id);
        $this->db->distinct();
        $this->db->join('categories','categories.id = products.category_id');
        $data = $this->db->get()->result();
        
        return $data;

    }

    public function Banner($farmer_id){
       if($farmer_id){
        $this->db->select('*');
        $this->db->from('slider');
        $this->db->where('farmer_id',$farmer_id);
        $query = $this->db->get();
        $result = $query->result_array();
       }
       else{
        $this->db->select('*');
        $this->db->from('slider');
        $query = $this->db->get();
        $result = $query->result_array();
       }
        
        return $result;
    }

    public function getdatafromtable($tbnm, $condition = array(), $data="*", $limit="", $offset="",$orderby ="",$ordertype = "DESC"){

    $this->db->select($data);

    $this->db->from($tbnm);

    $this->db->where($condition);
    
    if($limit != ''){

      $this->db->limit($limit, $offset);    

    }
    if($orderby != ''){

    $this->db->order_by("$orderby",$ordertype); 

    }
    $query = $this->db->get();

    if ($query->num_rows() > 0) {

      return $query->result_array();

    } else {

      return false;

    }

  }



    public function getAllProducts($data){

        if($data['farmer_id'])
        {

          $this->db->select('*');

          $this->db->from('products');

          $this->db->where('farmer_id',$data['farmer_id']);

          $data = $this->db->get()->result_array();


        }

        elseif($data['availability']){

         // echo "string";die;

        $currdate = $data['availability'];
        
        $data = $this->db->query('SELECT product_id,product_name,product_description,product_image,in_stock,price,discount_price,off_percentage,quantity,net_weight,wishlist_status,volume FROM products WHERE availability  Like "%'.$currdate.'%"' )->result_array();

        return $data;


          // $this->db->select('product_id,product_name,product_description,product_image,in_stock,price,discount_price,off_percentage,quantity,net_weight,wishlist_status');

          // $this->db->from('products');

          // $this->db->like('availability', $data['availability']);

          // $data = $this->db->get()->result_array(); 
        }

        elseif($data['product_name']){
          $this->db->select('product_id,product_name,product_description,product_image,in_stock,price,discount_price,off_percentage,quantity,net_weight,volume,wishlist_status');

          $this->db->from('products');

          $this->db->like('product_name',$data['product_name']);

          $data = $this->db->get()->result_array();
        }

        else{

          $this->db->select('*');

          $this->db->from('products');

          $data = $this->db->get()->result_array();
        }

        if($data){

          return $data;

        }

        else{
          return false;
        }


    }



    public function getProductByCategory($category_id,$vendorid){

        $this->db->select('product_id,product_name,product_description,product_image,category_id,categories.title,in_stock,price,discount_price,off_percentage,quantity,net_weight,volume,wishlist_status,farmer_id');

        $this->db->from('products');

        $this->db->where('category_id',$category_id);

        $this->db->join('categories','categories.id = products.category_id');
        $this->db->where('products.farmer_id',$vendorid);
        $data = $this->db->get()->result_array();

        return $data;

    }





     public function myOrder($user_id){

       $this->db->select('*');

        $this->db->from('sale as s');

        $this->db->where('s.user_id',$user_id);

        //$this->db->join('sale_items','r.user_id = sale.user_id');

        // $this->db->join('products as p ','p.product_id = sale.product_id');

        $data = $this->db->get()->result();

        return $data;

    }

    public function OrderDetails($order_id){

       $this->db->select('*');

        $this->db->from('sale as s');

        $this->db->where('s.sale_id',$order_id);

        //$this->db->join('sale_items','r.user_id = sale.user_id');

        // $this->db->join('products as p ','p.product_id = sale.product_id');

        $data = $this->db->get()->result();

        return $data;

    }



    public function singleProductDescription($product_id){

        $this->db->select('products.product_id,product_name,products.farmer_id,users.user_name,product_description,product_image,in_stock,price,discount_price,off_percentage,quantity,net_weight,wishlist_status,availability,users.user_email,users.user_phone,users.street_address,bankAcoountHolderName,bankName,accountNo,ifscCode,products.volume,ROUND(AVG(rating)),COUNT(review)');

        $this->db->from('products');

        $this->db->where('products.product_id',$product_id);

        $this->db->join('users','users.user_id = products.farmer_id');

        $this->db->join('rating','rating.product_id = products.product_id');

        $data = $this->db->get()->result_array();

        return $data;

    }



    public function contactFormData($contactFormData){

        $this->db->insert('contacts',$contactFormData);

        return $this->db->insert_id();

    }



    public function addWishlist($wishlist){

        $this->db->insert('wishlists',$wishlist);

        return $this->db->insert_id();

    }



    public function getWishlist($user_id){

        $this->db->select('wishlists.product_id,products.product_name,products.product_description,products.product_image,products.in_stock,products.price,products.discount_price,products.off_percentage,products.quantity,products.net_weight,wishlists.wishlist_status,products.volume');

        $this->db->from('wishlists');

        $this->db->where('wishlists.user_id',$user_id);

        $this->db->join('products','products.product_id = wishlists.product_id');

        $data = $this->db->get()->result();

        return $data;

    }



    public function deleteWishlist($product_id,$user_id){

      $this->db->select("*");    

      $this->db->from('wishlists');

      $this->db->where('product_id',$product_id);

      $this->db->where('user_id',$user_id);

      $data = $this->db->get()->row();

      if($data)

      {

          $this->db->where('product_id', $product_id);

          $this->db->where('user_id',$user_id);

          $this->db->delete('wishlists');

          return true;

      }

      else

      {

        return false;

      }
  

    }


    public function mostView(){
      $this->db->select('most_view_products.product_id,products.product_name,products.product_description,products.product_image,products.in_stock,products.price,products.discount_price,products.off_percentage,products.quantity,products.net_weight,count_status');

      $this->db->from('products');

      $this->db->order_by('rand()');

      $this->db->join('most_view_products','products.product_id = most_view_products.product_id');

      $data = $this->db->get()->result_array();

      if($data){
        return $data;
      }

      else{
        return false;
      }
    }


    public function couponListing(){
      $this->db->select("*");    

      $this->db->from('coupons');

      $data = $this->db->get()->result();

      if($data)

      {

        return $data;

      }

      else

      {

        return false;

      }
  
    }


    public function settings($settings_data){

        $this->db->insert('nofication_supervisor',$settings_data);

        return $this->db->insert_id();

    }

     public function singleRowdata($where_data,$table){  
    $this->db->where($where_data);
    $query = $this->db->get($table);
    return $query->row();
  }

    public function update($table,$data,$where_data){
    $this->db->where($where_data);
    $insertData=$this->db->update($table,$data);
    if($insertData){
      return TRUE;
    }else{
      return FALSE;
    }
  }


  public function getfarmerdata(){
     $this->db->select("*");
     $this->db->from('farmers');
    
     //$this->db->where('user_password',$con['user_password']);
     $data = $this->db->get()->result();
      return $data; 
      
    }


  public function getfarmer($user_id){
     $this->db->select("*");
     $this->db->from('farmers');
    $this->db->where('user_id',$user_id);
     $data = $this->db->get()->result();
      return $data; 
      
    }

    public function getallData($farmers_id=''){
     $this->db->select('farmers.*,farms.*,farms.farm_id as farms_id1,farms.state as farm_state,farms.district as farm_district,farms.villege as farm_villege,farms.taluka as farm_taluka');

    $this->db->from('farms');
     

    $this->db->where('farmers_id',$farmers_id);

     $this->db->join('farmers','farms.farmers_id=farmers.user_id'); 



        $data = $this->db->get()->result();
        
        return $data;  
    }

      public function getassignfarmer($supevisor_id=''){


     $this->db->select('*');

    $this->db->from('farms');
    $this->db->join('farmers','farms.farmers_id=farmers.user_id'); 

    $this->db->where('supevisor_id',$supevisor_id);
   //echo $this->db->last_query();
    $data = $this->db->get()->result();
     
        return $data;  
    }




public function getfarmerid($user_id=''){
     $this->db->select("*");
     $this->db->from('farmers');
     $this->db->where('user_id',$user_id);
    
     //$this->db->where('user_password',$con['user_password']);
     $data = $this->db->get()->row();
      return $data; 
      
    }

    public function farmers($user_id=''){
     $this->db->select("*");
     $this->db->from('farmers');
     $this->db->where('user_id',$user_id);
    
     //$this->db->where('user_password',$con['user_password']);
     $data = $this->db->get()->row();
      return $data; 
      
    }
    /****Farm details****/

    public function getfarmdata(){
     $this->db->select("*");
     $this->db->from('farms');
    
     //$this->db->where('user_password',$con['user_password']);
     $data = $this->db->get()->result();
      return $data; 
      
    }

    public function getreport($farmer_id='',$farms_id='',$sub_child_id=''){
     $this->db->select("*");
     $this->db->from('supervisor_analysis');
     $this->db->join('sub_child','sub_child.id=supervisor_analysis.sub_child_id'); 
     $this->db->where('farmer_id',$farmer_id);
     $this->db->where('farms_id',$farms_id);
      $this->db->where('sub_child_id',$sub_child_id);
     $data = $this->db->get()->result();
      return $data;   
    }

      public function getfertilizer(){
     $this->db->select("*");
     $this->db->from('fertilizer_shedule');
    
     //$this->db->where('user_password',$con['user_password']);
     $data = $this->db->get()->result();
      return $data; 
      
    }
      public function getcrops(){
     $this->db->select("*");
     $this->db->from('categories');
    
     //$this->db->where('user_password',$con['user_password']);
     $data = $this->db->get()->result();
      return $data; 
      
    }

     public function getsubcrops($cat_id){
     $this->db->select("*");
     $this->db->from('Sub_category');
      $this->db->where('cat_id',$cat_id);
    
     //$this->db->where('user_password',$con['user_password']);
     $data = $this->db->get()->result();
      return $data; 
      
    }

    /* public function getimage($cat_full_image){
     $this->db->select("*");
     $this->db->from('categories');
    
     $this->db->where('cat_full_image',$cat_full_image);
     $data = $this->db->get()->result();
      return $data; 
      
    }*/

     public function getdatewise($date_of_showing='',$cat_id=''){
     $this->db->select("*");
     $this->db->where('date_of_showing',$date_of_showing);
      $this->db->where('cat_id',$cat_id);
     $this->db->from('subcategories');
    
     //$this->db->where('user_password',$con['user_password']);
     $data = $this->db->get()->row();
      return $data; 
      
    }


    public function get_sub($cat_id=''){
     $this->db->select("*");
     $this->db->from('Sub_category');
     $this->db->where('cat_id',$cat_id);
    
     //$this->db->where('user_password',$con['user_password']);
     $data = $this->db->get()->result();
      return $data; 
      
    }

     public function get_child($cat_id='',$sub_id=''){
     $this->db->select("*");
     $this->db->from('child_category');
     $this->db->where('cat_id',$cat_id);
     $this->db->where('sub_id',$sub_id);
    
     //$this->db->where('user_password',$con['user_password']);
     $data = $this->db->get()->result();
      return $data; 
      
    }

    public function get_subchild($cat_id='',$sub_id='',$child_id=''){
     $this->db->select("*");
     $this->db->from('sub_child');
     $this->db->where('cat_id',$cat_id);
     $this->db->where('sub_id',$sub_id);
      $this->db->where('child_id',$child_id);
     $data = $this->db->get()->result();
      return $data; 
      
    }
     public function get_product($sub_child_id=''){
     $this->db->select("*");
     $this->db->from('products');
     $this->db->where('sub_child_id',$sub_child_id);
     $data = $this->db->get()->result();
      return $data; 
      
    }
   public function upload($image){

        $this->db->insert('supervisor_analysis',$image);
        
        return $this->db->insert_id();

    }

        function check($con){
     $this->db->select("*");
     $this->db->from('supervisor_analysis');
     $this->db->where('farmer_id',$con['farmer_id']);
     //$this->db->where('user_password',$con['user_password']);
     $data1 = $this->db->get()->row_array();
     
      if(!empty($data1))
      {
      
        return $data1;
         
      }
      else
      {
     
        return false;
      }
      
    }
    
    function check1($con1){
     $this->db->select("*");
     $this->db->from('supervisor_analysis');
     $this->db->where('farms_id',$con1['farms_id']);
     //$this->db->where('user_password',$con['user_password']);
     $data1 = $this->db->get()->row_array();
     
      if(!empty($data1))
      {
      
        return $data1;
         
      }
      else
      {
     
        return false;
      }
      
    }
    

 function child_data($cat_id){
     $this->db->select("*");
     $this->db->from('child_category');
     $this->db->where('cat_id',$cat_id);
     //$this->db->where('user_password',$con['user_password']);
     $data1 = $this->db->get()->result();
     
      if(!empty($data1))
      {
      
        return $data1;
         
      }
      else
      {
     
        return false;
      }
      
    }
 

}