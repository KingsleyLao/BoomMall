<?php
	namespace Admin\Model;
	use Think\Model;

	class BrandModel extends Model
	{
		public function getData($a='')
		{
			if(empty($a)){
				
				$data=$this->field('id,bname,desc,pic')->select();

				foreach($data as $k=>&$v){
					$v['pic']=ltrim($v['pic'],'.');
				}
				return $data;
			
			}else{
				
				$data=$this->where('id='.$a)->field('id,bname,desc,pic')->find();
				$data['pic']=ltrim($data['pic'],'.');
				return $data;	
			}
		}

		public function addData($a,$b='')
		{
			$data['pic']=$a['img'];
			$data['desc']=$a['desc'];
			$data['bname']=$a['bname'];

			if(empty($b)){
				$bool=$this->add($data);
				return $bool;
			}else{
		
				$bool=$this->where('id='.$b)->save($data);
				return $bool;
			}
		}
	}



?>