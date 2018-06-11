<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\controller\Base;
class Images extends Base
{
    public function index()
    {
        if (request()->isPost()) {

            /*$file = request()->file('filea');
            $filesize = $_FILES['filea']['size'];
            if (empty($file)) {
                $this->error('请选择上传文件');
            }
            $info = $file->validate(['size'=>1567118,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static'. DS . 'uploads');
            if ($info) {
                /*$pic = $info->getPathName();*/
               /* $pic = $info->getFileName();
               $pic = $info->getSaveName();
               $pic = $info->getExtension();
                $a=date('Ymd');
                $c='/public/static/uploads/'.$a.'/'.$pic;
                echo $c;
                $data=[
                    'images'=>$c,
                ];
                if(db('images')->insert($data)){
                    return $this->success('添加栏目成功！');
                }else{
                    return $this->error('添加栏目失败！');
                }

            }*/$files = request()->file('file');
            foreach ($files as $file) {

                    $info = $file->validate(['size' => 1567118, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static'. DS . 'uploads');
                    if($info){
                        $pic = $info->getSaveName();
                        /*$a=date('Ymd');*/
                        $c="/public/static/uploads/$pic";
                        echo $c;
                        $data=[
                            'images'=>$c,
                        ];
                        db('images')->insert($data);
                    }else{
                        // 上传失败获取错误信息
                        echo $file->getError();
                    }


            }


        }else{
        $list = Db('images')->select();
        $this->assign('list', $list);
        return $this->fetch();
        }
    }
        
    public function add()
    {	
    	if(request()->isPost()){

			$data=[
    			'goodsname'=>input('goodsname'),
                'catebid'=>input('catebid'),
    		];
    		if(db('goods')->insert($data)){
    			return $this->success('添加栏目成功！','index');
    		}else{
    			return $this->error('添加栏目失败！');
    		}
    		return;
    	}
        $as=db('catea')->select();
        $this->assign('as',$as);
		$bs=db('cateb')->select();
        $this->assign('bs',$bs); 
        return $this->fetch();

    }

    public function edit(){
    	$id=input('id');
    	$goods=db('goods')->find($id);
    	if(request()->isPost()){
    		$data=[
    			'id'=>input('id'),
    			'goodsname'=>input('goodsname'),
                'catebid'=>input('catebid'),
    		];
            $save=db('goods')->update($data);
    		if($save !== false){
    			$this->success('修改栏目成功！','index');
    		}else{
    			$this->error('修改栏目失败！');
    		}
    		return;
    	}
        $this->assign('goods',$goods);
        $bs=db('cateb')->select();
        $this->assign('bs',$bs);
        return $this->fetch();
    }

    public function del(){
    	$id=input('id');
    	if(db('goods')->delete(input('id'))){
    		$this->success('删除栏目成功！','index');
    	}else{
    		$this->error('删除栏目失败！');
    	}
    	
    }

    public function cate(){
        $id=input('id');
        $map['cateaid']=$id;
        $bs=db('cateb')->where($map)->select();
        $this->assign('bs',$bs);
        return $this->fetch('add');

    }




}
