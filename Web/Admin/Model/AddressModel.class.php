<?php 
namespace Admin\Model;
use Think\Model;
class AddressModel extends Model
{
	public function getaddress()
	{
		$data = $this->select();

		$useradd = M('useradd');

		foreach ($data as $k=>&$v){

			$private = $v['private'];
			$city = $v['city'];
			$area = $v['area'];

			// $useradd->field('name')->getField($private);
			// $useradd->field('name')->getField($city);
			// $useradd->field('name')->getField($area);
		
			$v['private'] = $useradd->where("id=$private")->getField('name');
			$v['city'] = $useradd->where("id=$city")->getField('name');
			$v['area'] = $useradd->where("id=$area")->getField('name');

		}
		
		return $data;
	}

	
}




 ?>