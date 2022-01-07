<?php

    // check if array is sorted ==== O(n)
    function isSorted($arr){
        $len = count($arr);
        for($i = 1; $i < $len; $i++){
            if($arr[$i] < $arr[$i - 1]){
                return 0;
            }
        }
        return 1;
    }

    // sort the array ==== O(n^2), Omega(n)
    function insertionSort(&$arr){
        $len = count($arr);
        for($i = 1; $i < $len; $i++){
            $key = $arr[$i];
            $j = $i - 1; // outside loop to save $j status
            for( ; $j >= 0; $j--){
                if($arr[$j] > $key){
                    $arr[$j+1] = $arr[$j];
                }
                else break;
            }
            $arr[$j + 1] = $key; // placing the target element in this loop
        }
    }

    // merge sort
    function mergeSort($arr){
        $len = count($arr);
        if($len == 1 || !$len){
            return $arr;
        }
        
        $mid = floor( ($len-1) / 2 );
        // splitting $arr into to parts left & right
        $left = mergeSort( array_slice($arr, 0, $mid + 1) );
        $right = mergeSort( array_slice($arr, $mid+1, $len - $mid - 1) );

        return merge($left, $right);
    }
    function merge($left, $right){
        $i = $j = 0;
        $res = [];
        $lenLeft = count($left);
        $lenRight = count($right);

        // fill $res with element from smaller to bigger
        while($i < $lenLeft && $j < $lenRight){
            if($left[$i] <= $right[$j]){
                array_push($res, $left[$i]);
                $i++;
            }
            else{
                array_push($res, $right[$j]);
                $j++;
            }
        }

        // if $left has values put them in $res
        while($i < $lenLeft){
            array_push($res, $left[$i]);
            $i++;
        }
        // if $right has values put them in $res
        while($j < $lenRight){
            array_push($res, $right[$j]);
            $j++;
        }

        return $res;
    }

    class BinarySearch{
        private $arr;

        public function __construct($arr){
            if(gettype($arr) == 'array'){
                if(!isSorted($arr)){
                    insertionSort($arr);
                }
                $this->arr = $arr;
            }
            else throw new Exception("invalid data type");
        }
        // iterative binary search
        public function BSI($key){
            $l = count($this->arr);
            $f = 0;
            while($f <= $l){
                $mid = floor(($f+$l)/2);
                if($this->arr[$mid] == $key)    return $mid;
                elseif($this->arr[$mid] > $key) $l = $mid - 1;
                else                            $f = $mid + 1;
            }

            return -1;
        }
        // recursive binary search
        public function BSR($key){
            return $this->BSR2($this->arr, $key, 0, count($this->arr) - 1);
        }
        // helper method
        private function BSR2($arr, $key, $f, $l){
            if($f > $l) return -1;
            
            $mid = ($f+$l)/2;
            $mid = floor($mid);
            if($arr[$mid] == $key)      return $mid;
            elseif($arr[$mid] > $key)   return $this->BSR2($arr, $key, $f, $mid-1);
            else                        return $this->BSR2($arr, $key, $mid+1, $l);
        }
    }
    

    // $bs = new BinarySearch([1,2,3,4,5,6,7,10]);
    // echo $bs->BSR(2);

    $arr = [2, 8, 1, 3, 6, 7, 5, 4];
    echo isSorted($arr) . '<br />';
    insertionSort($arr);
    echo isSorted($arr) . '<br />';
    print_r($arr);

    // echo isSorted($arr) . '<br />';
    // $arr = mergeSort($arr);
    // echo isSorted($arr) . '<br />'; 
    // print_r($arr);
?>