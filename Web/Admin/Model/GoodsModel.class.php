<?php
	namespace Admin\Model;
	use Think\Model;

	class GoodsModel extends Model
	{
		 // protected $_validate = array(  
		   
		 // array('goodsname','require','名称不能为空！'),  
		 // array('typeid','require','分类不能为空！'), 
		 // array('size','require','尺寸不能为空！'), 
		 // array('color','require','颜色不能为空！'), 
		 // array('store','require','库存不能为空！'),
		 // array('store','number','库存一定要是数字！'), 
		 // array('makein','require','生产地不能为空！'), 
		 // array('desc','require','摘要不能为空！'),
		 // array('price','require','价格不能为空！'),
		 // array('price','number','价格必须为数字！'),
		 // array('desc','require','分类描述不能为空！！'),     
		 //   );


		function getData($data)
		{
			
			$pic = M('goods_pic');
			foreach ($data as $k => &$v) {
				
				$gid = $v[id];
			
				$aaa = $pic->where("gid=$gid")->find();
				$aaa['pic']=ltrim($aaa['pic'],'.');
				$v['pic'] = $aaa['pic'];


			}

			return $data;


		}
	}

?>