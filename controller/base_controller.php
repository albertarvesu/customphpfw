<?php
    class BaseController
    {
        public $data = NULL;
        public $id = NULL;
        public $model =  NULL;
        
        
        public function setModel($model)
        {
            $this->model = $model;
        }

        public function setData($data)
        {
            $this->data = $data;
        }
        
        public function setId($id)
        {
            $this->id = (int)$id;
        }
        
        public function findAll($data=NULL, $cond=NULL, $order=NULL)
        {
            $data = is_array($data) ? $data : array("*");
            return $this->model->findAll($data, $cond, $order);
        }
        
        public function find($data, $cond=NULL)
        {            
            return $this->model->find($data, $cond);
        }
        
        public function findMax()
        {
            return $this->model->findMax();
        }
        
        public function add()
        {
            $this->model->setData($this->data);
            return $this->model->add();
        }
        
        public function update()
        {
            //ready for update, return the result
            $this->model->setData($this->data);
            $this->model->setId($this->id);
            return $this->model->update();
        }
        
        public function delete($id)
        {
            if( !$id ) return false;
            
            $this->model->setId($id);
            return $this->model->delete();
        }

    }
?>