<?php
	namespace Admin\Controller;
	use Think\Controller;
	class SpecController extends Controller
	{
		public function index()
		{
			$m=new \Think\Model;
			//var_dump($m);
			$data=$m->query('select t.name,v.item_val,i.item_name from boom_spec_item i,boom_goods_type t,boom_spec_val v where i.type_id=t.id and v.item_id=i.item_id;');
			var_dump($data);
			$this->assign('data',$data);
			$this->display();
		}
	}



?>