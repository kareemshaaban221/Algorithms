

<?php

    class binaryHeap{ // min heap
        private $arr;
        private $len = 0;

        public function __construct($arr = array()){
            if(gettype($arr) != 'array'){
                throw new Exception("invalid input");
            }
            else{
                $this->arr = [];
                foreach($arr as $data){
                    $this->put($data); // log n
                }
                $len = count($arr);
            }
        }

        public function put($elem){
            array_push($this->arr, $elem);
            $this->swim($this->len - 1);
            $this->len++;
        }

        public function pull(){
            $this->swap(0, $this->len - 1);
            $res = array_pop($this->arr);
            $this->sink(0);
            $this->len--;
            return $res;
        }

        public function size(){
            return $this->len;
        }

        private function sink($index){ // O(log n)
            if($index >= $this->len){
                throw new Exception("overflow index from sink function");
            }
            else{
                $lChild = $index * 2 + 1;
                $rChild = $index * 2 + 2;
                if(isset($this->arr[$lChild])){
                    if(isset($this->arr[$rChild])){
                        if($this->arr[$lChild] <= $this->arr[$rChild] && $this->arr[$lChild] < $this->arr[$index]){
                            $this->swap($lChild, $index);
                            $this->sink($lChild);
                        }
                        elseif($this->arr[$lChild] > $this->arr[$rChild] && $this->arr[$rChild] < $this->arr[$index]){
                            $this->swap($rChild, $index);
                            $this->sink($rChild);
                        }
                        else return;
                    }
                    else { // added after presentation :)
                        if($this->arr[$lChild] < $this->arr[$index]){
                            $this->swap($lChild, $index);
                        }
                        return;
                    }
                }
                else return;
            }
        }

        private function swim($index){
            if($index >= $this->len){
                throw new Exception("overflow index from swim function");
            }
            else{
                $parent = ceil($index / 2 - 1);
                if($parent < 0){
                    return;
                }
                elseif($this->arr[$index] < $this->arr[$parent]){
                    $this->swap($index, $parent);
                    $this->swim($parent);
                }
                else{
                    return;
                }
            }
        }

        private function swap($i, $j){
            $temp = $this->arr[$i];
            $this->arr[$i] = $this->arr[$j];
            $this->arr[$j] = $temp;
        }
    }

    function heapSort(&$arr){
        $bh = new binaryHeap($arr); // nlogn
        $len = $bh->size();
        for($i = 0; $i < $len; $i++){ // nlogn
            $arr[$i] = $bh->pull();
        }
    }

    $arr = [2, 8, 1, 3, 6, 7, 5, 4];

    heapSort($arr);
    print_r($arr);

?>